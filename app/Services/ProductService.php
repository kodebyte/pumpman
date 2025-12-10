<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo
    ) {}

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Prepare Data Dasar
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);

            $data['has_variants'] = (bool) ($data['has_variants'] ?? false);
            $data['is_active'] = (bool) ($data['is_active'] ?? true);
            $data['is_featured'] = (bool) ($data['is_featured'] ?? false);

            // --- PERBAIKAN DISINI ---
            // Pastikan discount_value tidak NULL. Jika kosong, set ke 0.
            $data['discount_value'] = $data['discount_value'] ?? 0;
            
            // Opsional: Jika tipe diskon tidak dipilih, pastikan value 0
            if (empty($data['discount_type'])) {
                $data['discount_type'] = null;
                $data['discount_value'] = 0;
            }
            // ------------------------

            // 2. Simpan Produk Utama
            $product = $this->productRepo->create($data);

            // 3. Handle Relasi
            $this->handleRelations($product, $data);

            return $product;
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $product = $this->productRepo->findById($id);

            if (isset($data['name']) && $data['name'] !== $product->name) {
                $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
            }

            $data['has_variants'] = (bool) ($data['has_variants'] ?? false);
            $data['is_active'] = (bool) ($data['is_active'] ?? true);
            $data['is_featured'] = (bool) ($data['is_featured'] ?? false);

            // --- PERBAIKAN DISINI (Sama seperti Create) ---
            $data['discount_value'] = $data['discount_value'] ?? 0;
            
            if (empty($data['discount_type'])) {
                $data['discount_type'] = null;
                $data['discount_value'] = 0;
            }
            // ------------------------

            $this->productRepo->update($id, $data);

            // ... (sisa kode update sama seperti sebelumnya: delete images, handle relations) ...
            if (!empty($data['delete_images'])) {
                $imagesToDelete = $product->images()->whereIn('id', $data['delete_images'])->get();
                foreach ($imagesToDelete as $img) {
                    if (Storage::disk('public')->exists($img->image_path)) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    $img->delete();
                }
            }

            if (!empty($data['delete_downloads'])) {
                $downloadsToDelete = $product->downloads()->whereIn('id', $data['delete_downloads'])->get();
                
                foreach ($downloadsToDelete as $file) {
                    // 1. Hapus File Fisik
                    if (Storage::disk('public')->exists($file->file_path)) {
                        Storage::disk('public')->delete($file->file_path);
                    }
                    // 2. Hapus Record DB (Hard Delete sesuai kesepakatan)
                    $file->delete();
                }
            }

            $this->handleRelations($product->refresh(), $data);

            return $product;
        });
    }

    // ... method delete dan handleRelations tetap sama ...
    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {
            return $this->productRepo->delete($id);
        });
    }

    protected function handleRelations($product, array $data)
    {
        // ... (Kode handleRelations sama persis dengan jawaban sebelumnya) ...
        // Agar tidak panjang, pastikan Anda menggunakan handleRelations yang sudah lengkap 
        // (Image, Variant null check, Marketplace, Download) dari jawaban sebelumnya.
        
        // A. HANDLE IMAGES
        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $image) {
                if ($image instanceof UploadedFile) {
                    $path = $image->store('products/gallery', 'public');
                    $isFirstImage = $product->images()->count() === 0;
                    $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => $isFirstImage, 
                        'order'      => 0
                    ]);
                }
            }
        }

        // B. HANDLE VARIANTS
        $hasVariants = $data['has_variants'] ?? false;
        $variantsInput = $data['variants'] ?? [];

        if ($hasVariants) {
            
            // 1. Kumpulkan semua ID yang dikirim dari form (yang di-keep oleh user)
            // filter() membuang nilai null/kosong (varian baru belum punya ID)
            $keptVariantIds = collect($variantsInput)->pluck('id')->filter()->toArray();

            // 2. HAPUS varian di Database yang ID-nya TIDAK ADA di list $keptVariantIds
            // Ini akan menghapus varian yang di-klik tombol "Hapus" di form
            // Walaupun $keptVariantIds kosong (semua dihapus), whereNotIn akan menghapus semuanya.
            $product->variants()->whereNotIn('id', $keptVariantIds)->delete();

            // 3. Loop untuk Update atau Create Varian Baru
            foreach ($variantsInput as $variant) {
                // Pastikan nama tidak kosong (validasi form array kadang meloloskan row kosong)
                if (!empty($variant['name'])) {
                    $product->variants()->updateOrCreate(
                        // Kunci: ID (Jika null, buat baru)
                        ['id' => $variant['id'] ?? null],
                        
                        // Data
                        [
                            'name'      => $variant['name'],
                            'price'     => !empty($variant['price']) ? $variant['price'] : $product->price,
                            'stock'     => $variant['stock'] ?? 0,
                            'sku'       => $variant['sku'] ?? strtoupper(Str::random(8)),
                            'is_active' => true
                        ]
                    );
                }
            }

        } else {
            // Jika toggle "Has Variants" dimatikan, hapus SEMUA varian
            $product->variants()->delete();
        }

        // C. HANDLE MARKETPLACE LINKS
        if (isset($data['marketplaces']) && is_array($data['marketplaces'])) {
            $syncData = [];
            foreach ($data['marketplaces'] as $mp) {
                if (!empty($mp['link'])) {
                    $syncData[$mp['id']] = ['link' => $mp['link']];
                }
            }
            $product->marketplaces()->sync($syncData);
        }

        // D. HANDLE DOWNLOADS
        if (isset($data['downloads']) && is_array($data['downloads'])) {
            foreach ($data['downloads'] as $file) {
                if ($file instanceof UploadedFile) {
                    $path = $file->store('products/manuals', 'public');
                    $product->downloads()->create([
                        'title'     => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'type'      => 'manual'
                    ]);
                }
            }
        }
    }
}
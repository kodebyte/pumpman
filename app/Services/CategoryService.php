<?php

namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepo
    ) {}

    public function create(
        array $data
    )
    {
        $nameForSlug = $data['name']['en'] ?? $data['name']['id'] ?? 'category';
        $data['slug'] = Str::slug($nameForSlug);

        // 2. Handle Image Upload
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Simpan di folder 'categories' dalam disk 'public'
            // Hasil path: "categories/namafile.jpg"
            $data['image'] = $data['image']->store('categories', 'public');
        }

        return $this->categoryRepo->create($data);
    }

    public function update(
        int $id, 
        array $data
    )
    {
        // 1. Update Slug hanya jika nama berubah
        if (isset($data['name'])) {
            $nameForSlug = $data['name']['en'] ?? $data['name']['id'] ?? 'category';
            $data['slug'] = Str::slug($nameForSlug);
        }

        // 2. Handle Image Upload (Ganti Gambar)
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $category = $this->categoryRepo->findById($id);
            
            // Hapus gambar lama fisik jika ada
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            // Upload gambar baru
            $data['image'] = $data['image']->store('categories', 'public');
        }

        return $this->categoryRepo->update($id, $data);
    }

    public function delete(
        int $id
    )
    {
        return $this->categoryRepo->delete($id);
    }
}
<?php

namespace App\Services;

use App\Contracts\MarketplaceRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class MarketplaceService
{
    public function __construct(
        protected MarketplaceRepositoryInterface $marketplaceRepo
    ) {}

    public function create(array $data)
    {
        // 1. Logic Non-DB (Slug)
        $data['slug'] = Str::slug($data['name']);

        // 2. Logic Non-DB (Upload File)
        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            $data['icon'] = $data['icon']->store('marketplaces', 'public');
        }

        // 3. Single DB Query (Tidak butuh transaction manual)
        return $this->marketplaceRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        // 1. Logic Non-DB
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            // Ambil data lama untuk hapus gambar (Read Query)
            // Read query sebelum Write query masih aman tanpa transaksi di kasus sederhana
            $marketplace = $this->marketplaceRepo->findById($id);
            
            if ($marketplace->icon) {
                Storage::disk('public')->delete($marketplace->icon);
            }
            $data['icon'] = $data['icon']->store('marketplaces', 'public');
        }

        // 2. Single DB Query Update
        return $this->marketplaceRepo->update($id, $data);
    }

    public function delete(int $id)
    {
        // Single DB Query Delete
        return $this->marketplaceRepo->delete($id);
    }
}
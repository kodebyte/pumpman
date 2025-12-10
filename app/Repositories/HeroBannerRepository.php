<?php

namespace App\Repositories;

use App\Contracts\HeroBannerRepositoryInterface;
use App\Models\HeroBanner;

class HeroBannerRepository implements HeroBannerRepositoryInterface
{
    // Inject dengan nama spesifik $heroBanner
    public function __construct(
        protected HeroBanner $heroBanner
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->heroBanner->newQuery();

        // 1. Search (Tetap sama)
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where('title->en', 'like', "%{$search}%")
                ->orWhere('title->id', 'like', "%{$search}%");
        }

        // 2. Filter Status (Tetap sama)
        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // 3. Sorting Logic (BARU)
        // Default: Urutkan berdasarkan 'order' (Ascending) karena ini banner slider
        $sortColumn = $params['sort'] ?? 'order';
        $sortDirection = $params['direction'] ?? 'asc';
        
        $allowedSorts = ['title', 'order', 'is_active', 'created_at'];

        if (in_array($sortColumn, $allowedSorts)) {
            // Jika sort by Title (JSON), Laravel otomatis handle sort string JSON-nya
            $query->orderBy($sortColumn, $sortDirection)
                ->orderBy('id', 'asc');
        } else {
            $query->orderBy('order', 'asc');
        }

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    public function getActiveBanners()
    {
        $now = now();
        
        return $this->heroBanner->newQuery()
            ->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            })
            ->orderBy('order', 'asc')
            ->get();
    }

    public function findById(int $id)
    {
        return $this->heroBanner->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->heroBanner->create($data);
    }

    public function update(int $id, array $data)
    {
        $banner = $this->findById($id);
        $banner->update($data);
        return $banner;
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }
}
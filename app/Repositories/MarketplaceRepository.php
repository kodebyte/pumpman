<?php

namespace App\Repositories;

use App\Contracts\MarketplaceRepositoryInterface;
use App\Models\Marketplace;

class MarketplaceRepository implements MarketplaceRepositoryInterface
{
    public function __construct(
        protected Marketplace $marketplace
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->marketplace->newQuery();

        if (!empty($params['search'])) {
            $query->where('name', 'like', '%' . $params['search'] . '%');
        }

        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // --- UPDATE LOGIKA SORTING ---
        // Default sort column jadi 'order', direction 'asc'
        $sortColumn = $params['sort'] ?? 'order'; 
        $sortDirection = $params['direction'] ?? 'asc';
        
        $allowedSorts = [
            'name', 
            'is_active', 
            'created_at', 
            'order'
        ];

        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection)
                ->orderBy('id', 'asc');
        } else {
            $query->orderBy('order', 'asc');
        }

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->marketplace->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->marketplace->create($data);
    }

    public function update(int $id, array $data)
    {
        $marketplace = $this->findById($id);
        $marketplace->update($data);
        return $marketplace;
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }
}
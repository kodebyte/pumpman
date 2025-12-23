<?php

namespace App\Repositories;

use App\Contracts\StoreRepositoryInterface;
use App\Models\Store;

class StoreRepository implements StoreRepositoryInterface
{
    public function __construct(
        protected Store $store
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->store->newQuery();

        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
        }

        if (!empty($params['type'])) {
            $query->where('type', $params['type']);
        }

        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // Sorting
        $sortColumn = $params['sort'] ?? 'order';
        $sortDirection = $params['direction'] ?? 'asc';
        
        $allowedSorts = [
            'name', 
            'city', 
            'type', 
            'is_active', 
            'order'
        ];

        // Allowed sorts
        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection)->orderBy('id', 'asc');
        } else {
            $query->orderBy('order', 'asc');
        }

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    // ... Standard CRUD methods (findById, create, update, delete) ...
    public function findById(int $id) 
    { 
        return $this->store->findOrFail($id); 
    }

    public function create(array $data) 
    { 
        return $this->store->create($data); 
    }

    public function update(int $id, array $data) 
    { 
        $store = $this->findById($id);
        $store->update($data);
        return $store;
    }
    
    public function delete(int $id) 
    { 
        return $this->findById($id)->delete(); 
    }
}
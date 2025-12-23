<?php

namespace App\Repositories;

use App\Contracts\CourierRepositoryInterface;
use App\Models\Courier;

class CourierRepository implements CourierRepositoryInterface
{
    public function __construct(
        protected Courier $courier
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->courier->newQuery();

        // Filter Search (Name atau Code)
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        // Filter Status
        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // Sorting
        $sortColumn = $params['sort'] ?? 'created_at';
        $sortDirection = $params['direction'] ?? 'desc';
        
        $query->orderBy($sortColumn, $sortDirection);

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->courier->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->courier->create($data);
    }

    public function update(int $id, array $data)
    {
        $courier = $this->findById($id);
        $courier->update($data);
        return $courier;
    }

    public function delete(int $id)
    {
        $courier = $this->findById($id);
        return $courier->delete();
    }
}
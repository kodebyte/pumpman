<?php

namespace App\Repositories;

use App\Contracts\CareerRepositoryInterface;
use App\Models\Career;

class CareerRepository implements CareerRepositoryInterface
{
    public function __construct(
        protected Career $career
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->career->newQuery();

        // 1. Search (JSON Column)
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function($q) use ($search) {
                $q->where('title->en', 'like', "%{$search}%")
                  ->orWhere('title->id', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // 2. Filter Status
        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // 3. Sorting
        $sortColumn = $params['sort'] ?? 'order';
        $sortDirection = $params['direction'] ?? 'asc';
        
        $allowedSorts = ['location', 'type', 'closing_date', 'is_active', 'order', 'created_at'];

        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection)->orderBy('id', 'asc');
        } else {
            $query->orderBy('order', 'asc');
        }

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->career->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->career->create($data);
    }

    public function update(int $id, array $data)
    {
        $career = $this->findById($id);
        $career->update($data);
        return $career;
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }
}
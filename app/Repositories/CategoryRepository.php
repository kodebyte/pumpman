<?php

namespace App\Repositories;

use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository implements CategoryRepositoryInterface
{
    // Inject dengan nama spesifik $category
    public function __construct(
        protected Category $category
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->category->newQuery();

        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function($q) use ($search) {
                $q->where('name->en', 'like', '%' . $search . '%')
                ->orWhere('name->id', 'like', '%' . $search . '%');
            });
        }

        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        if (isset($params['is_featured']) && $params['is_featured'] !== '') {
            $query->where('is_featured', $params['is_featured']);
        }

        $sortColumn = $params['sort'] ?? 'created_at';
        $sortDirection = $params['direction'] ?? 'desc';
        $allowedSorts = ['name', 'created_at', 'is_active', 'is_featured'];

        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection)->orderBy('id', 'asc');
        } else {
            $query->latest();
        }

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->category->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->category->create($data);
    }

    public function update(int $id, array $data)
    {
        $category = $this->findById($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->findById($id);
        return $category->delete();
    }
}
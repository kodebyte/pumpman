<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        protected Product $product
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->product->newQuery()
            ->with(['category', 'images']) // Eager load untuk performa
            ->withCount('variants'); // Hitung varian

        // 1. Search (Nama atau SKU)
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // 2. Filter Category
        if (!empty($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        // 3. Filter Status
        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // 4. Sorting
        $sortColumn = $params['sort'] ?? 'created_at';
        $sortDirection = $params['direction'] ?? 'desc';
        
        $allowedSorts = [
            'name', 
            'price', 
            'stock', 
            'is_active', 
            'created_at'
        ];

        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection)->orderBy('id', 'asc');
        } else {
            $query->latest();
        }

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        // Load semua relasi yang dibutuhkan untuk halaman Edit
        return $this->product->with(['category', 'images', 'variants', 'downloads', 'marketplaces'])
                             ->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function update(int $id, array $data)
    {
        $product = $this->findById($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }
}
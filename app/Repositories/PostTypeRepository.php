<?php

namespace App\Repositories;

use App\Contracts\PostTypeRepositoryInterface;
use App\Models\PostType;

class PostTypeRepository implements PostTypeRepositoryInterface
{
    public function __construct(
        protected PostType $postType
    ) {}

   public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->postType->newQuery();

        // 1. Search Logic
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                  ->orWhere('name->en', 'like', "%{$search}%")
                  ->orWhere('name->id', 'like', "%{$search}%");
            });
        }

        // 2. Filter Status
        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // 3. Sorting Logic (BARU)
        if (!empty($params['sort']) && !empty($params['direction'])) {
            $direction = $params['direction'] === 'asc' ? 'asc' : 'desc';
            
            if ($params['sort'] === 'name') {
                // Sort JSON key 'en' (sesuaikan kebutuhan, bisa juga user preference)
                $query->orderBy('name->en', $direction);
            } else {
                // Sort kolom biasa (slug, is_active, created_at)
                $query->orderBy($params['sort'], $direction);
            }
        } else {
            // Default Sort: Created At Descending
            $query->latest(); 
        }

        // 4. Cursor Pagination Tiebreaker (WAJIB)
        // Cursor pagination membutuhkan kolom unik sebagai penentu akhir agar data konsisten.
        return $query->orderBy('id', 'desc')
                     ->cursorPaginate($perPage)
                     ->withQueryString();
    }

    public function findById(int $id) {
        return $this->postType->findOrFail($id);
    }

    public function create(array $data) {
        return $this->postType->create($data);
    }

    public function update(int $id, array $data) {
        $postType = $this->findById($id);
        $postType->update($data);
        return $postType;
    }

    public function delete(int $id) {
        return $this->findById($id)->delete();
    }
}
<?php

namespace App\Repositories;

use App\Contracts\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(
        protected Post $post
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->post->newQuery()->with('author');

        // Search di dalam JSON
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function($q) use ($search) {
                $q->where('title->en', 'like', "%{$search}%")
                  ->orWhere('title->id', 'like', "%{$search}%");
            });
        }

        if (!empty($params['type'])) {
            $query->where('type', $params['type']);
        }

        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        return $query->latest('published_at')
                     ->cursorPaginate($perPage)
                     ->withQueryString();
    }

    // ... method findById, create, update, delete standar (copy dari repository lain) ...
    
    public function findById(int $id) { return $this->post->findOrFail($id); }
    public function create(array $data) { return $this->post->create($data); }
    public function update(int $id, array $data) { 
        $post = $this->findById($id);
        $post->update($data);
        return $post;
    }
    public function delete(int $id) { return $this->findById($id)->delete(); }
}
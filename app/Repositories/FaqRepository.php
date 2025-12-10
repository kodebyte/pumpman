<?php

namespace App\Repositories;

use App\Contracts\FaqRepositoryInterface;
use App\Models\Faq;

class FaqRepository implements FaqRepositoryInterface
{
    public function __construct(
        protected Faq $faq
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->faq->newQuery()->with('parent');

        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title->en', 'like', "%{$search}%")
                ->orWhere('title->id', 'like', "%{$search}%")
                ->orWhere('answer->en', 'like', "%{$search}%")
                ->orWhere('answer->id', 'like', "%{$search}%");
            });
        }

        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }
        
        // Sorting: Parent dulu, baru Child, baru Order
        return $query->orderByRaw('COALESCE(parent_id, id), parent_id IS NOT NULL, `order`')
                    ->cursorPaginate($perPage);
    }

    // Update juga method ini karena Category Name sekarang JSON
    public function getCategoriesList()
    {
        return $this->faq->categories()->orderBy('order')->get();
    }

    public function findById(int $id)
    {
        return $this->faq->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->faq->create($data);
    }

    public function update(int $id, array $data)
    {
        $faq = $this->findById($id);
        $faq->update($data);
        return $faq;
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }
}
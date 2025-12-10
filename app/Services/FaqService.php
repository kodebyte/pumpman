<?php

namespace App\Services;

use App\Contracts\FaqRepositoryInterface;
use Illuminate\Support\Facades\DB;

class FaqService
{
    public function __construct(
        protected FaqRepositoryInterface $categoryRepo
    ) {}

    public function create(array $data)
    {
        // Default order 0 jika kosong
        $data['order'] = $data['order'] ?? 0;
        return $this->categoryRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->categoryRepo->update($id, $data);
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {
            return $this->categoryRepo->delete($id);
        });
    }
}
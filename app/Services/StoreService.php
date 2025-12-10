<?php

namespace App\Services;

use App\Contracts\StoreRepositoryInterface;

class StoreService
{
    public function __construct(
        protected StoreRepositoryInterface $storeRepo
    ) {}

    public function create(array $data)
    {
        // Simple logic, langsung create
        return $this->storeRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->storeRepo->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->storeRepo->delete($id);
    }
}
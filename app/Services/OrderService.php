<?php

namespace App\Services;

use App\Contracts\OrderRepositoryInterface;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepo
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        return $this->orderRepo->getAll($params, $perPage);
    }

    public function findById(int $id)
    {
        return $this->orderRepo->findById($id);
    }

    public function delete(int $id)
    {
        return $this->orderRepo->delete($id);
    }
}
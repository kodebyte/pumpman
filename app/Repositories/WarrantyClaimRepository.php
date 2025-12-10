<?php

namespace App\Repositories;

use App\Contracts\WarrantyClaimRepositoryInterface;
use App\Models\WarrantyClaim;

class WarrantyClaimRepository implements WarrantyClaimRepositoryInterface
{
    public function __construct(protected WarrantyClaim $model) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->model->newQuery()->with(['product', 'user']);

        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function($q) use ($search) {
                $q->where('claim_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        if (isset($params['status']) && $params['status'] !== '') {
            $query->where('status', $params['status']);
        }

        return $query->latest()->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->model->with(['product', 'user'])->findOrFail($id);
    }

    public function updateStatus(int $id, array $data)
    {
        $claim = $this->findById($id);
        $claim->update($data);
        return $claim;
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }
}
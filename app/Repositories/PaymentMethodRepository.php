<?php

namespace App\Repositories;

use App\Contracts\PaymentMethodRepositoryInterface;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    public function __construct(
        protected PaymentMethod $paymentMethod
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->paymentMethod->newQuery();

        // Filter Search
        if (!empty($params['search'])) {
            $query->where('name', 'like', '%' . $params['search'] . '%');
        }

        // Filter Status
        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // Sorting
        $sortColumn = $params['sort'] ?? 'order';
        $sortDirection = $params['direction'] ?? 'asc';
        
        $allowedSorts = ['name', 'order', 'is_active', 'created_at'];

        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection);
        } else {
            $query->orderBy('order', 'asc');
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->paymentMethod->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->paymentMethod->create($data);
    }

    public function update(int $id, array $data)
    {
        $paymentMethod = $this->findById($id);
        
        // Hapus gambar lama jika ada gambar baru
        if (isset($data['image']) && $paymentMethod->image && $paymentMethod->image !== $data['image']) {
            // Cek apakah gambar lokal (bukan URL eksternal dari seeder)
            if (!filter_var($paymentMethod->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($paymentMethod->image);
            }
        }

        $paymentMethod->update($data);
        return $paymentMethod;
    }

    public function delete(int $id)
    {
        $paymentMethod = $this->findById($id);
        
        if ($paymentMethod->image && !filter_var($paymentMethod->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($paymentMethod->image);
        }

        return $paymentMethod->delete();
    }
}
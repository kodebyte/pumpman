<?php

namespace App\Repositories;

use App\Contracts\EmployeeRepositoryInterface;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function __construct(
        protected Employee $employee
    ) {}

    // Tambahkan parameter $params = []
    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->employee->newQuery()->with('role');

        // 1. Logic Search (Nama & Email)
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Logic Filter Role (Jika ada dropdown role di UI)
        if (!empty($params['role_id'])) {
            $query->where('employee_role_id', $params['role_id']);
        }

        // 3. Logic Status (Active/Inactive)
        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // 4. Logic Sorting
        $sortColumn = $params['sort'] ?? 'created_at';
        $sortDirection = $params['direction'] ?? 'desc';

        $allowedSorts = [
            'name', 
            'email', 
            'created_at', 
            'is_active'
        ];

        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection)
                  ->orderBy('id', 'asc'); // Secondary sort untuk Cursor Pagination
        } else {
            $query->latest();
        }

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->employee->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->employee->create($data);
    }

    public function update(int $id, array $data)
    {
        $employee = $this->findById($id);
        $employee->update($data);
        return $employee;
    }

    public function delete(int $id)
    {
        $employee = $this->findById($id);
        return $employee->delete();
    }
}
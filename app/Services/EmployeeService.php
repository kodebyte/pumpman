<?php

namespace App\Services;

use App\Contracts\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{
    // PHP 8 Constructor Property Promotion
    // Tidak perlu lagi tulis: protected $employeeRepo; di atas
    public function __construct(
        protected EmployeeRepositoryInterface $employeeRepo
    ) {}

    public function create(
        array $data
    )
    {
        $data['password'] = Hash::make($data['password']);

        return $this->employeeRepo->create($data);
    }

    public function update(
        int $id, 
        array $data
    )
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->employeeRepo->update($id, $data);
    }

    public function delete(
        int $id
    )
    {
        if ($id == auth()->id()) {
            throw new \Exception("You cannot delete your own account.");
        }
        
        return $this->employeeRepo->delete($id);
    }
}
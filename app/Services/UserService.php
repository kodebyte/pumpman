<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    // Constructor Property Promotion
    public function __construct(
        protected UserRepositoryInterface $userRepo
    ) {}

    public function create(
        array $data
    )
    {
        $data['password'] = Hash::make($data['password']);

        return $this->userRepo->create($data);
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

        return $this->userRepo->update($id, $data);
    }

    public function delete(
        int $id
    )
    {
        return $this->userRepo->delete($id);
    }
}
<?php

namespace App\Services;

use App\Contracts\PostTypeRepositoryInterface;
use Exception;

class PostTypeService
{
    public function __construct(
        protected PostTypeRepositoryInterface $postTypeRepo
    ) {}

    public function create(array $data)
    {
        // Pastikan is_active boolean
        $data['is_active'] = isset($data['is_active']) ? (bool)$data['is_active'] : false;
        
        // Slug biasanya sudah divalidasi unik di Request, jadi langsung kirim
        return $this->postTypeRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        $data['is_active'] = isset($data['is_active']) ? (bool)$data['is_active'] : false;
        return $this->postTypeRepo->update($id, $data);
    }

    public function findById(int $id)
    {
        return $this->postTypeRepo->findById($id);
    }

    public function delete(int $id)
    {
        $postType = $this->postTypeRepo->findById($id);

        // Business Logic: Jangan hapus jika tipe ini sudah dipakai oleh Post
        if ($postType->posts()->exists()) {
            throw new Exception("Cannot delete type '{$postType->slug}' because it is assigned to existing posts.");
        }

        return $this->postTypeRepo->delete($id);
    }
}
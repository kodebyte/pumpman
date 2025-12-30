<?php

namespace App\Services;

use App\Contracts\WhatsappContactRepositoryInterface;
use App\Models\WhatsappContact;

class WhatsappContactService
{
    public function __construct(
        protected WhatsappContactRepositoryInterface $contactRepo
    ) {}

    public function create(array $data)
    {
        // Default order jika kosong: ambil max order + 1
        if (!isset($data['order'])) {
            $maxOrder = WhatsappContact::max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
        }
        
        return $this->contactRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->contactRepo->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->contactRepo->delete($id);
    }
}
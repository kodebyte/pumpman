<?php

namespace App\Services;

use App\Contracts\ContactMessageRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ContactMessageService
{
    public function __construct(
        protected ContactMessageRepositoryInterface $contactRepo
    ) {}

    public function showMessage(int $id)
    {
        $message = $this->contactRepo->findById($id);
        
        // Otomatis tandai sebagai sudah dibaca saat dibuka
        if (!$message->is_read) {
            $this->contactRepo->markAsRead($id);
        }

        return $message;
    }

    public function deleteMessage(int $id)
    {
        return $this->contactRepo->delete($id);
    }
}
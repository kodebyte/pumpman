<?php

namespace App\Repositories;

use App\Contracts\ContactMessageRepositoryInterface;
use App\Models\ContactMessage;

class ContactMessageRepository implements ContactMessageRepositoryInterface
{
    /**
     * Inject model ContactMessage.
     */
    public function __construct(
        protected ContactMessage $contactMessage
    ) {}

    /**
     * Mengambil semua pesan dengan filter pencarian dan status baca.
     * Konsisten dengan pola CategoryRepository.
     */
    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->contactMessage->newQuery();

        // Filter Pencarian (Nama, Email, atau Topik)
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('topic', 'like', '%' . $search . '%');
            });
        }

        // Filter Berdasarkan Status Baca
        if (isset($params['is_read']) && $params['is_read'] !== '') {
            $query->where('is_read', $params['is_read']);
        }

        // Pengaturan Sorting
        $sortColumn = $params['sort'] ?? 'created_at';
        $sortDirection = $params['direction'] ?? 'desc';
        $allowedSorts = ['name', 'created_at', 'topic', 'is_read'];

        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection)->orderBy('id', 'asc');
        } else {
            $query->latest();
        }

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    /**
     * Menemukan pesan berdasarkan ID.
     */
    public function findById(int $id)
    {
        return $this->contactMessage->findOrFail($id);
    }

    /**
     * Menandai pesan sebagai sudah dibaca.
     */
    public function markAsRead(int $id)
    {
        $message = $this->findById($id);
        $message->update(['is_read' => true]);
        return $message;
    }

    /**
     * Menghapus pesan (menggunakan Soft Deletes sesuai migrasi).
     */
    public function delete(int $id)
    {
        $message = $this->findById($id);
        return $message->delete();
    }

    /**
     * Menghitung jumlah pesan yang belum dibaca untuk Badge Sidebar.
     */
    public function getUnreadCount()
    {
        return $this->contactMessage->where('is_read', false)->count();
    }
}
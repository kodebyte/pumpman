<?php

namespace App\Repositories;

use App\Contracts\WhatsappContactRepositoryInterface;
use App\Models\WhatsappContact;

class WhatsappContactRepository implements WhatsappContactRepositoryInterface
{
    public function __construct(
        protected WhatsappContact $contact
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->contact->newQuery();

        // 1. Filter Search
        if (!empty($params['search'])) {
            $query->where(function($q) use ($params) {
                $q->where('title', 'like', '%' . $params['search'] . '%')
                  ->orWhere('phone', 'like', '%' . $params['search'] . '%');
            });
        }

        // 2. Filter Active Status
        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // 3. Sorting Logic (Diadaptasi dari CategoryRepository)
        // Default sort kita set ke 'order' ascending karena ini adalah kontak WA
        $sortColumn = $params['sort'] ?? 'order';
        $sortDirection = $params['direction'] ?? 'asc';
        
        // Whitelist kolom agar aman dari SQL Injection via order by
        $allowedSorts = ['title', 'phone', 'order', 'is_active', 'created_at'];

        if (in_array($sortColumn, $allowedSorts)) {
            // Secondary sort by ID desc agar urutan stabil jika nilainya sama
            $query->orderBy($sortColumn, $sortDirection)->orderBy('id', 'desc');
        } else {
            // Default behavior jika parameter sort tidak dikenali
            $query->orderBy('order', 'asc');
        }

        return $query->paginate($perPage)->withQueryString();
    }

    // ... method findById, create, update, delete tetap sama ...
    public function findById(int $id)
    {
        return $this->contact->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->contact->create($data);
    }

    public function update(int $id, array $data)
    {
        $contact = $this->findById($id);
        $contact->update($data);
        return $contact;
    }

    public function delete(int $id)
    {
        return $this->contact->destroy($id);
    }
}
<?php

namespace App\Repositories;

use App\Contracts\ClientRepositoryInterface;
use App\Models\Client;

class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        protected Client $client
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->client->newQuery();

        // Filter Search
        if (!empty($params['search'])) {
            $query->where('name', 'like', '%' . $params['search'] . '%');
        }

        // Filter Active
        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        // Sorting Logic
        $sortColumn = $params['sort'] ?? 'order';
        $sortDirection = $params['direction'] ?? 'asc';
        
        // Whitelist kolom agar aman
        $allowedSorts = ['name', 'created_at', 'order', 'is_active'];

        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection)->orderBy('id', 'desc');
        } else {
            $query->orderBy('order', 'asc');
        }

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->client->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->client->create($data);
    }

    public function update(int $id, array $data)
    {
        $client = $this->findById($id);
        $client->update($data);
        return $client;
    }

    public function delete(int $id)
    {
        $client = $this->findById($id);
        return $client->delete();
    }
}
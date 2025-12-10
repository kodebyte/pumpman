<?php

namespace App\Services;

use App\Contracts\NewsletterSubscriberRepositoryInterface;
use Illuminate\Support\Facades\DB;

class NewsletterSubscriberService
{
    public function __construct(
        protected NewsletterSubscriberRepositoryInterface $repo
    ) {}

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['is_active'] = $data['is_active'] ?? true;
            $data['email'] = strtolower($data['email']);
            return $this->repo->create($data);
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            if (isset($data['email'])) {
                $data['email'] = strtolower($data['email']);
            }
            return $this->repo->update($id, $data);
        });
    }

    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }
}
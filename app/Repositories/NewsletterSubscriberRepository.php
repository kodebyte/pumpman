<?php

namespace App\Repositories;

use App\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Models\NewsletterSubscriber;

class NewsletterSubscriberRepository implements NewsletterSubscriberRepositoryInterface
{
    public function __construct(
        protected NewsletterSubscriber $model
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->model->newQuery();

        if (!empty($params['search'])) {
            $query->where('email', 'like', '%' . $params['search'] . '%');
        }

        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        return $query->latest()->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $subscriber = $this->findById($id);
        $subscriber->update($data);
        return $subscriber;
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }
}
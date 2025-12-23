<?php

namespace App\Contracts;

interface ContactMessageRepositoryInterface
{
    public function getAll(array $params = [], int $perPage = 10);
    public function findById(int $id);
    public function markAsRead(int $id);
    public function delete(int $id);
    public function getUnreadCount();
}
<?php

namespace App\Contracts;

interface PostTypeRepositoryInterface
{
    public function getAll(array $params = [], int $perPage = 10);
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
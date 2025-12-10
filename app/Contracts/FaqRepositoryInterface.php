<?php

namespace App\Contracts;

interface FaqRepositoryInterface
{
    public function getAll(array $params = [], int $perPage = 10);
    public function getCategoriesList();
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
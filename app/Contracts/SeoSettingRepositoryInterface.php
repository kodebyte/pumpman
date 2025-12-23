<?php

namespace App\Contracts;

interface SeoSettingRepositoryInterface
{
    public function getAll(array $params = [], int $perPage = 10);
    public function findById(int $id);
    public function update(int $id, array $data);
}
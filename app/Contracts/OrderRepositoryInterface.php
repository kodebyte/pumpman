<?php

namespace App\Contracts;

interface OrderRepositoryInterface
{
    public function getAll(array $params = [], int $perPage = 10);
    public function findById(int $id);
    public function delete(int $id);
    public function getReportData(array $params);
}
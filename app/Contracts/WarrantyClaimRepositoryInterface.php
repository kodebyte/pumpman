<?php

namespace App\Contracts;

interface WarrantyClaimRepositoryInterface
{
    public function getAll(array $params = [], int $perPage = 10);
    public function findById(int $id);
    public function updateStatus(int $id, array $data); // Update status & note
    public function delete(int $id);
}
<?php

namespace App\Services;

use App\Contracts\WarrantyClaimRepositoryInterface;
use Illuminate\Support\Facades\DB;

class WarrantyClaimService
{
    public function __construct(protected WarrantyClaimRepositoryInterface $repo) {}

    public function updateStatus(int $id, array $data)
    {
        // Logic tambahan bisa ditaruh sini (misal kirim email notifikasi status berubah)
        return $this->repo->updateStatus($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }
}
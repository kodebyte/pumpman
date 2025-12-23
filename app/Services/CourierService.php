<?php

namespace App\Services;

use App\Contracts\CourierRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CourierService
{
    public function __construct(
        protected CourierRepositoryInterface $courierRepo
    ) {}

    public function create(array $data)
    {
        // Handle Logo Upload
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $data['logo'] = $data['logo']->store('couriers', 'public');
        }

        // Pastikan code lowercase
        $data['code'] = strtolower($data['code']);

        return $this->courierRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        // Handle Logo Replacement
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $courier = $this->courierRepo->findById($id);
            
            // Hapus logo lama jika ada
            if ($courier->logo && Storage::disk('public')->exists($courier->logo)) {
                Storage::disk('public')->delete($courier->logo);
            }

            $data['logo'] = $data['logo']->store('couriers', 'public');
        }

        if (isset($data['code'])) {
            $data['code'] = strtolower($data['code']);
        }

        return $this->courierRepo->update($id, $data);
    }

    public function delete(int $id)
    {
        $courier = $this->courierRepo->findById($id);
        
        // Hapus file fisik saat delete data
        if ($courier->logo && Storage::disk('public')->exists($courier->logo)) {
            Storage::disk('public')->delete($courier->logo);
        }

        return $this->courierRepo->delete($id);
    }
}
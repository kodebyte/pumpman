<?php

namespace App\Services;

use App\Contracts\ClientRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ClientService
{
    public function __construct(
        protected ClientRepositoryInterface $clientRepo
    ) {}

    public function create(array $data)
    {
        // Handle Logo Upload
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $data['logo'] = $data['logo']->store('clients', 'public');
        }

        return $this->clientRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        // Handle Logo Replacement
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $client = $this->clientRepo->findById($id);
            
            // Hapus logo lama fisik jika ada
            if ($client->logo && Storage::disk('public')->exists($client->logo)) {
                Storage::disk('public')->delete($client->logo);
            }

            // Upload logo baru
            $data['logo'] = $data['logo']->store('clients', 'public');
        }

        return $this->clientRepo->update($id, $data);
    }

    public function delete(int $id)
    {
        $client = $this->clientRepo->findById($id);

        // Hapus fisik logo saat delete (Opsional, tergantung kebijakan soft delete)
        // Jika menggunakan SoftDelete, biasanya gambar tidak langsung dihapus.
        // Uncomment baris di bawah jika ingin hapus gambar permanen.
        // if ($client->logo && Storage::disk('public')->exists($client->logo)) {
        //    Storage::disk('public')->delete($client->logo);
        // }

        return $this->clientRepo->delete($id);
    }
}
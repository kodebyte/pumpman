<?php

namespace App\Repositories;

use App\Contracts\ProductHighlightRepositoryInterface;
use App\Models\ProductHighlight;

class ProductHighlightRepository implements ProductHighlightRepositoryInterface
{
    public function getHighlight()
    {
        // Mengambil data pertama atau membuat record kosong jika tabel masih kosong
        return ProductHighlight::first() ?? new ProductHighlight();
    }

    public function update(array $data)
    {
        // UpdateOrCreate memastikan kita hanya mengelola satu baris data (Singleton-ish)
        return ProductHighlight::updateOrCreate(
            ['id' => 1], // Selalu kunci di ID 1
            $data
        );
    }
}
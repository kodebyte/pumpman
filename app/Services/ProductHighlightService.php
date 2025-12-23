<?php

namespace App\Services;

use App\Contracts\ProductHighlightRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductHighlightService
{
    public function __construct(
        protected ProductHighlightRepositoryInterface $highlightRepo
    ) {}

    public function update(array $data)
    {
        $highlight = $this->highlightRepo->getHighlight();

        // Handle Image Upload (Logika mirip SettingService)
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Hapus gambar lama jika ada
            if ($highlight->image) {
                Storage::disk('public')->delete($highlight->image);
            }
            $data['image'] = $data['image']->store('highlights', 'public');
        }

        return $this->highlightRepo->update($data);
    }
}
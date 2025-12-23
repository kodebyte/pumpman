<?php

namespace App\Services;

use App\Contracts\SeoSettingRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SeoSettingService
{
    public function __construct(
        protected SeoSettingRepositoryInterface $seoRepo
    ) {}

    public function update(int $id, array $data)
    {
        $setting = $this->seoRepo->findById($id);

        if (isset($data['og_image']) && $data['og_image'] instanceof UploadedFile) {
            if ($setting->og_image && Storage::disk('public')->exists($setting->og_image)) {
                Storage::disk('public')->delete($setting->og_image);
            }
            $data['og_image'] = $data['og_image']->store('seo', 'public');
        }

        return $this->seoRepo->update($id, $data);
    }
}
<?php

namespace App\Services;

use App\Contracts\HeroBannerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class HeroBannerService
{
    public function __construct(
        protected HeroBannerRepositoryInterface $bannerRepo
    ) {}

    public function create(
        array $data
    )
    {
        $data = $this->handleUploads($data);

        return $this->bannerRepo->create($data);
    }

    public function update(
        int $id, 
        array $data
    )
    {
        $banner = $this->bannerRepo->findById($id);

        $data = $this->handleUploads(
            $data, 
            $banner
        );

        return $this->bannerRepo->update($id, $data);
    }

    public function delete(
        int $id
    )
    {
        return $this->bannerRepo->delete($id);
    }

    protected function handleUploads(
        array $data, 
        $oldBanner = null
    )
    {
        // 1. Desktop Image
        if (isset($data['image_desktop']) && $data['image_desktop'] instanceof UploadedFile) {
            if ($oldBanner && $oldBanner->image_desktop) {
                Storage::disk('public')->delete($oldBanner->image_desktop);
            }
            $data['image_desktop'] = $data['image_desktop']->store('banners/desktop', 'public');
        }

        // 2. Mobile Image
        if (isset($data['image_mobile']) && $data['image_mobile'] instanceof UploadedFile) {
            if ($oldBanner && $oldBanner->image_mobile) {
                Storage::disk('public')->delete($oldBanner->image_mobile);
            }
            $data['image_mobile'] = $data['image_mobile']->store('banners/mobile', 'public');
        }

        // 3. Video
        if (isset($data['video']) && $data['video'] instanceof UploadedFile) {
            if ($oldBanner && $oldBanner->video_path) {
                Storage::disk('public')->delete($oldBanner->video_path);
            }
            $data['video_path'] = $data['video']->store('banners/videos', 'public');
        }
        
        // Hapus raw file object sebelum simpan ke DB
        unset($data['video']);

        return $data;
    }
}
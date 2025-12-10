<?php

namespace App\Services;

use App\Contracts\PostRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class PostService
{
    public function __construct(
        protected PostRepositoryInterface $postRepo
    ) {}

    public function create(array $data)
    {
        // 1. Generate Slug (Dari Title Inggris, fallback ke ID)
        $titleSlug = $data['title']['en'] ?? $data['title']['id'] ?? 'post';
        $data['slug'] = Str::slug($titleSlug) . '-' . Str::random(4);
        
        // 2. Set Author & Status
        $data['author_id'] = auth()->id();
        $data['is_active'] = isset($data['is_active']) ? (bool)$data['is_active'] : false;

        // 3. Upload Thumbnail
        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            $data['thumbnail'] = $data['thumbnail']->store('posts/thumbnails', 'public');
        }

        return $this->postRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        $post = $this->postRepo->findById($id);

        // 1. Update Slug jika title berubah (Opsional, bisa di-skip agar link lama tidak mati)
        if (isset($data['title']['en']) && $data['title']['en'] !== ($post->title['en'] ?? '')) {
            $data['slug'] = Str::slug($data['title']['en']) . '-' . Str::random(4);
        }

        $data['is_active'] = isset($data['is_active']) ? (bool)$data['is_active'] : false;

        // 2. Upload Thumbnail Baru
        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $data['thumbnail']->store('posts/thumbnails', 'public');
        }

        return $this->postRepo->update($id, $data);
    }

    public function delete(int $id)
    {
        // Soft delete aman, gambar fisik tidak dihapus dulu
        return $this->postRepo->delete($id);
    }
}
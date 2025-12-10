<?php

namespace App\Services;

use App\Contracts\CareerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CareerService
{
    public function __construct(
        protected CareerRepositoryInterface $careerRepo
    ) {}

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Generate Slug dari Title EN (Fallback ke ID)
            $titleSlug = $data['title']['en'] ?? $data['title']['id'] ?? 'career';
            $data['slug'] = Str::slug($titleSlug) . '-' . Str::random(4);

            // 2. Boolean Check
            $data['is_active'] = (bool) ($data['is_active'] ?? true);
            
            return $this->careerRepo->create($data);
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $career = $this->careerRepo->findById($id);

            // 1. Update Slug jika title berubah
            if (isset($data['title']['en']) && $data['title']['en'] !== ($career->title['en'] ?? '')) {
                $data['slug'] = Str::slug($data['title']['en']) . '-' . Str::random(4);
            }

            // 2. Boolean Check
            $data['is_active'] = (bool) ($data['is_active'] ?? false);

            return $this->careerRepo->update($id, $data);
        });
    }

    public function delete(int $id)
    {
        return $this->careerRepo->delete($id);
    }
}
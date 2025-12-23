<?php

namespace App\Repositories;

use App\Contracts\SeoSettingRepositoryInterface;
use App\Models\SeoSetting;

class SeoSettingRepository implements SeoSettingRepositoryInterface
{
    public function __construct(
        protected SeoSetting $seoSetting
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->seoSetting->newQuery();

        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where('page', 'like', '%' . $search . '%')
                  ->orWhere('page_route', 'like', '%' . $search . '%');
        }

        return $query->latest()->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->seoSetting->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $setting = $this->findById($id);
        $setting->update($data);
        return $setting;
    }
}
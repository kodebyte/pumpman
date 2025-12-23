<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\SeoSettingRepositoryInterface;
use App\Http\Requests\Admin\SeoSetting\UpdateSeoSettingRequest;
use App\Services\SeoSettingService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SeoSettingController extends Controller
{
    public function __construct(
        protected SeoSettingRepositoryInterface $seoRepo,
        protected SeoSettingService $seoService
    ) {}

    public function index(): View
    {
        $params = request()->only([
            'search']
        );

        $perPage = request('limit', 15);
        $settings = $this->seoRepo->getAll($params, $perPage);

        return view('admin.pages.seo.index', compact(
            'settings', 
            'perPage'
        ));
    }

    public function edit(int $id): View
    {
        $setting = $this->seoRepo->findById($id);

        return view('admin.pages.seo.edit', compact('setting'));
    }

    public function update(
        UpdateSeoSettingRequest $request, 
        string $id
    ): RedirectResponse
    {
        try {
            $this->seoService->update(
                $id, 
                $request->all()
            );
        } catch (\Exception $e) {
            \Log::error('Error update SEO Setting: ' . $e->getMessage());

            return back()->withInput()
            ->with('error', 'Failed to update SEO settings.');
        }

        return to_route('admin.seo.index')
                ->with('success', 'SEO settings updated successfully');
    }
}
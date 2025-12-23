<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\HeroBannerRepositoryInterface;
use App\Http\Requests\Admin\HeroBanner\StoreHeroBannerRequest;
use App\Http\Requests\Admin\HeroBanner\UpdateHeroBannerRequest;
use App\Services\HeroBannerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeroBannerController extends Controller
{
    public function __construct(
        protected HeroBannerRepositoryInterface $bannerRepo,
        protected HeroBannerService $bannerService
    ) {}

    public function index(): View
    {
        $params = request()->only([
            'search', 
            'is_active', 
            'sort', 
            'direction'
        ]);

        $perPage = request('limit', 15);
        $banners = $this->bannerRepo->getAll($params, $perPage);
        
        return view('admin.pages.banner.index', compact(
            'banners', 
            'perPage'
        ));
    }

    public function create(): View
    { 
        return view('admin.pages.banner.create'); 
    }

    public function store(
        StoreHeroBannerRequest $request
    ): RedirectResponse
    {
        try {
            $this->bannerService->create(
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Error creating banner: ' . $e->getMessage());

            return back()->withInput() // Form tidak kosong lagi
                    ->with('error', 'Failed to create banner. Please check your inputs or try again.');
        }

        return to_route('admin.banners.index')
                ->with('success', 'Banner created successfully');
    }

    public function edit(
        string $id
    ): View
    {
        $banner = $this->bannerRepo->findById($id);

        return view('admin.pages.banner.edit', compact('banner'));
    }

    public function update(
        UpdateHeroBannerRequest $request, 
        string $id
    ): RedirectResponse
    {
        try {
            $this->bannerService->update(
                $id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Error update banner: ' . $e->getMessage());

            return back()->withInput() 
                    ->with('error', 'Failed to update banner. Please try again.');
        }

        return to_route('admin.banners.index')
                ->with('success', 'Banner updated successfully');
    }

    public function destroy(
        string $id
    ): RedirectResponse
    {
        try {
            $this->bannerService->delete($id);
        } catch (\Exception $e) {
            \Log::error('Error delete banner: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete category. It might be linked to other data.');
        }

        return to_route('admin.banners.index')
                ->with('success', 'Banner deleted successfully');
    }
}
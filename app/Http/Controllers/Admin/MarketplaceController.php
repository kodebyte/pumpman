<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\MarketplaceRepositoryInterface;
use App\Services\MarketplaceService;
use App\Http\Requests\Admin\Marketplace\StoreMarketplaceRequest;
use App\Http\Requests\Admin\Marketplace\UpdateMarketplaceRequest;
use App\Models\Marketplace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function __construct(
        protected MarketplaceRepositoryInterface $marketplaceRepo,
        protected MarketplaceService $marketplaceService
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
        $marketplaces = $this->marketplaceRepo->getAll($params, $perPage);
        
        return view('admin.pages.marketplace.index', compact(
            'marketplaces', 
            'perPage'
        ));
    }

    public function create(): View
    {
        return view('admin.pages.marketplace.create');
    }

    public function store(
        StoreMarketplaceRequest $request
    ): RedirectResponse
    {
        try {
            // 1. Eksekusi Logic (Berisiko Error)
            $this->marketplaceService->create(
                $request->validated()
            );
        } catch (\Exception $e) {
            Log::error('Error creating marketplace: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to create marketplace.');
        }

        // 3. Happy Path (Success) - Di luar Try Block
        return to_route('admin.marketplaces.index')
                ->with('success', 'Marketplace created successfully');
    }

    public function edit(
        Marketplace $marketplace
    ): View
    {
        return view('admin.pages.marketplace.edit', compact('marketplace'));
    }

    public function update(
        UpdateMarketplaceRequest $request, 
        Marketplace $marketplace
    ): RedirectResponse
    {
        try {
            $this->marketplaceService->update(
                $marketplace->id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            Log::error('Error updating marketplace: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to update marketplace.');
        }

        return to_route('admin.marketplaces.index')
                ->with('success', 'Marketplace updated successfully');
    }

    public function destroy(
        Marketplace $marketplace
    ): RedirectResponse
    {
        try {
            $this->marketplaceService->delete($marketplace->id);
        } catch (\Exception $e) {
            Log::error('Error deleting marketplace: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete marketplace.');
        }

        return to_route('admin.marketplaces.index')
                ->with('success', 'Marketplace deleted successfully');
    }
}
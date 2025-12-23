<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\StoreRepositoryInterface;
use App\Services\StoreService;
use App\Http\Requests\Admin\Store\StoreStoreRequest;
use App\Http\Requests\Admin\Store\UpdateStoreRequest;
use App\Models\Store;

class StoreController extends Controller
{
    public function __construct(
        protected StoreRepositoryInterface $storeRepo,
        protected StoreService $storeService
    ) {}

    public function index()
    {
        $params = request()->only([
            'search', 
            'type', 
            'is_active', 
            'sort', 
            'direction'
        ]);

        $perPage = request('limit', 10);
        $stores = $this->storeRepo->getAll($params, $perPage);

        return view('admin.pages.store.index', compact(
            'stores', 
            'perPage'
        ));
    }

    public function create()
    {
        return view('admin.pages.store.create');
    }

    // Ganti Request dengan StoreStoreRequest
    public function store(
        StoreStoreRequest $request
    )
    {
        try {
            $this->storeService->create(
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Create store error: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to create store.');
        }

        return to_route('admin.stores.index')
                ->with('success', 'Store created successfully');
    }

    public function edit(
        Store $store
    )
    {
        return view('admin.pages.store.edit', compact('store'));
    }

    // Ganti Request dengan UpdateStoreRequest
    public function update(
        UpdateStoreRequest $request, 
        Store $store
    )
    {
        try {
            // Gunakan validated()
            $this->storeService->update(
                $store->id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Update store error: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to update store.');
        }

        return to_route('admin.stores.index')
                ->with('success', 'Store updated successfully');
    }

    public function destroy(
        Store $store
    )
    {
        try {
            $this->storeService->delete($store->id);
        } catch (\Exception $e) {
            \Log::error('Delete product error: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete store.');
        }

        return to_route('admin.stores.index')
                ->with('success', 'Store deleted successfully');
    }
}
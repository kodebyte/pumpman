<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\StoreRepositoryInterface;
use App\Services\StoreService;
use App\Http\Requests\Admin\Store\StoreStoreRequest;
use App\Http\Requests\Admin\Store\UpdateStoreRequest;
use Illuminate\Support\Facades\Log;
use Exception;

class StoreController extends Controller
{
    public function __construct(
        protected StoreRepositoryInterface $storeRepo,
        protected StoreService $storeService
    ) {}

    public function index()
    {
        $params = request()->only(['search', 'type', 'is_active', 'sort', 'direction']);
        $perPage = request('limit', 10);
        $stores = $this->storeRepo->getAll($params, $perPage);

        return view('admin.pages.store.index', compact('stores', 'perPage'));
    }

    public function create()
    {
        return view('admin.pages.store.create');
    }

    // Ganti Request dengan StoreStoreRequest
    public function store(StoreStoreRequest $request)
    {
        try {
            // Gunakan validated()
            $this->storeService->create($request->validated());
            
            return to_route('admin.stores.index')->with('success', 'Store created successfully');
        } catch (Exception $e) {
            Log::error('Create store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create store.');
        }
    }

    public function edit(string $id)
    {
        $store = $this->storeRepo->findById($id);
        return view('admin.pages.store.edit', compact('store'));
    }

    // Ganti Request dengan UpdateStoreRequest
    public function update(UpdateStoreRequest $request, string $id)
    {
        try {
            // Gunakan validated()
            $this->storeService->update($id, $request->validated());
            
            return to_route('admin.stores.index')->with('success', 'Store updated successfully');
        } catch (Exception $e) {
            Log::error('Update store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update store.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->storeService->delete($id);
            return to_route('admin.stores.index')->with('success', 'Store deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete store.');
        }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\PostTypeRepositoryInterface; // Interface Repository
use App\Services\PostTypeService;             // Service Logic
use App\Http\Requests\Admin\PostType\StorePostTypeRequest;
use App\Http\Requests\Admin\PostType\UpdatePostTypeRequest;

class PostTypeController extends Controller
{
    // Inject Repository (untuk Read) dan Service (untuk Write)
    public function __construct(
        protected PostTypeRepositoryInterface $postTypeRepo,
        protected PostTypeService $postTypeService
    ) {}

    public function index()
    {
        // 1. Ambil Parameter Filter
        $params = request()->only([
            'search', 
            'is_active',
            'sort',      // <--- Pastikan ini ada
            'direction'  // <--- Pastikan ini ada
        ]);
        
        $perPage = request('limit', 10);
        $types = $this->postTypeRepo->getAll($params, $perPage);

        return view('admin.pages.post-type.index', compact(
            'types', 
            'perPage'
        ));
    }

    public function create()
    {
        return view('admin.pages.post-type.create');
    }

    public function store(
        StorePostTypeRequest $request
    )
    {
        try {
            $this->postTypeService->create(
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Create post type error: ' . $e->getMessage());
            
            return back()->withInput()
                    ->with('error', 'Failed to create post type.');
        }

        return to_route('admin.post-types.index')
                ->with('success', 'Post Type created successfully');
    }

    public function edit(
        string $id
    )
    {
        // Ambil Data via Repository
        $type = $this->postTypeRepo->findById($id);
        
        return view('admin.pages.post-type.edit', compact('type'));
    }

    public function update(
        UpdatePostTypeRequest $request, 
        string $id
    )
    {
        try {
            $this->postTypeService->update(
                $id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Update post type error: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to update post type.');
        }

        return to_route('admin.post-types.index')
                ->with('success', 'Post Type updated successfully');
    }

    public function destroy(
        string $id
    )
    {
        try {
            // Delete Data via Service (Ada validasi relasi di dalamnya)
            $this->postTypeService->delete($id);
        } catch (\Exception $e) {
            // Pesan error biasanya dilempar dari Service jika tipe sedang dipakai
            \Log::error('Delete post type error: ' . $e->getMessage());

            return back()->with('error', $e->getMessage() ?? 'Failed to delete post type.');
        }

        return to_route('admin.post-types.index')
                ->with('success', 'Post Type deleted successfully');
    }
}
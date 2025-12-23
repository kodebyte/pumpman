<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\CategoryRepositoryInterface;
use App\Services\CategoryService;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepo,
        protected CategoryService $categoryService
    ) {}

    public function index(): View
    {
        $params = request()->only([
            'search', 
            'sort', 
            'direction', 
            'is_active', 
            'is_featured'
        ]);
        
        $perPage = request('limit', default: 15);

        $categories = $this->categoryRepo->getAll($params, $perPage);
        
        return view('admin.pages.product.category.index', compact('categories', 'perPage'));
    }

    public function create(): View
    {
        return view('admin.pages.product.category.create');
    }

    public function store(
        StoreCategoryRequest $request
    ): RedirectResponse
    {
        try {
             $this->categoryService->create(
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Error creating category: ' . $e->getMessage());

            return back()->withInput() // Form tidak kosong lagi
                    ->with('error', 'Failed to create category. Please check your inputs or try again.');
        }
        
        return to_route('admin.categories.index')
                ->with('success', 'Category created successfully');
    }

    public function edit(
        Category $category
    ): View
    {
        return view('admin.pages.product.category.edit', compact('category'));
    }

    public function update(
        UpdateCategoryRequest $request, 
        Category $category
    ): RedirectResponse
    {
        try {
             $this->categoryService->update(
                $category->id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Error update category: ' . $e->getMessage());

            return back()->withInput() // Form tidak kosong lagi
                    ->with('error', 'Failed to update category. Please try again.');
        }

        return to_route('admin.categories.index')
                ->with('success', 'Category updated successfully');
    }

    public function destroy(
        Category $category
    ): RedirectResponse
    {
        try {
            $this->categoryService->delete(
                $category->id
            );
        } catch (\Exception $e) {
            \Log::error('Error delete category: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete category. It might be linked to other data.');
        }
        
        return to_route('admin.categories.index')
                ->with('success', 'Category deleted successfully');
    }
}
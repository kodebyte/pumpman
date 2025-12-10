<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\ProductRepositoryInterface;
use App\Services\ProductService;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Marketplace;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductController extends Controller
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo,
        protected ProductService $productService
    ) {}

    public function index()
    {
        $params = request()->only(['search', 'category_id', 'is_active', 'sort', 'direction']);
        $perPage = request('limit', 10);
        
        $products = $this->productRepo->getAll($params, $perPage);
        $categories = Category::all(); // Untuk filter

        return view('admin.pages.product.data.index', compact('products', 'categories', 'perPage'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $marketplaces = Marketplace::where('is_active', true)->get();
        
        return view('admin.pages.product.data.create', compact('categories', 'marketplaces'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $this->productService->create($request->validated());
            return to_route('admin.products.index')->with('success', 'Product created successfully');
        } catch (Exception $e) {
            Log::error('Create product error: ' . $e->getMessage());
            // return back()->withInput()->with('error', 'Failed to create product.');
            throw $e;
        }
    }

    public function edit(string $id)
    {
        $product = $this->productRepo->findById($id);
        $categories = Category::all();
        $marketplaces = Marketplace::all();

        return view('admin.pages.product.data.edit', compact('product', 'categories', 'marketplaces'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        try {
            $this->productService->update($id, $request->validated());
            return to_route('admin.products.index')->with('success', 'Product updated successfully');
        } catch (Exception $e) {
            Log::error('Update product error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update product.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->productService->delete($id);
            return to_route('admin.products.index')->with('success', 'Product deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete product.');
        }
    }
}
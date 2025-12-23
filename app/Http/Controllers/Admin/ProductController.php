<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\ProductRepositoryInterface;
use App\Services\ProductService;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Marketplace;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo,
        protected ProductService $productService
    ) {}

    public function index()
    {
        $params = request()->only([
            'search', 
            'category_id', 
            'is_active', 
            'sort', 
            'direction'
        ]);

        $perPage = request('limit', 10);
        $products = $this->productRepo->getAll($params, $perPage);
        $categories = Category::all(); // Untuk filter

        return view('admin.pages.product.data.index', compact(
            'products', 
            'categories', 
            'perPage'
        ));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $marketplaces = Marketplace::active()->get();
        
        return view('admin.pages.product.data.create', compact(
            'categories', 
            'marketplaces'
        ));
    }

    public function store(
        StoreProductRequest $request
    )
    {
        try {
            $this->productService->create(
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Create product error: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to create product.');
        }

        return to_route('admin.products.index')
                ->with('success', 'Product created successfully');
    }

    public function edit(
        Product $product
    )
    {
        $categories = Category::all();
        $marketplaces = Marketplace::all();

        return view('admin.pages.product.data.edit', compact(
            'product', 
            'categories', 
            'marketplaces'
        ));
    }

    public function update(
        UpdateProductRequest $request, 
        Product $product
    )
    {
        try {
            $this->productService->update(
                $product->id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Update product error: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to update product.');
        }

        return to_route('admin.products.index')
                ->with('success', 'Product updated successfully');
    }

    public function destroy(
        Product $product
    )
    {
        try {
            $this->productService->delete($product->id);
        } catch (\Exception $e) {
            \Log::error('Delete product error: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete product.');
        }

        return to_route('admin.products.index')
                ->with('success', 'Product deleted successfully');
    }
}
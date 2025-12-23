<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(
        Request $request,
        ?Category $category = null
    )
    {
        $query = Product::query()
                    ->with(['category', 'images'])
                    ->where('is_active', true);

        // 2. LOGIKA BARU: Filter by SEO URL (Single Category)
        // Jika ada parameter $category dari route, filter langsung
        if ($category) {
            $query->where('category_id', $category->id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
                  // Jika ingin cari di deskripsi juga, uncomment baris bawah:
                  // ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        // 3. Filter Multi-Category (Fallback untuk Checkbox Sidebar/Query String)
        // Tetap kita pertahankan agar filter 'categories[]' dari query string tetap jalan
        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        // 4. Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc'); break;
                case 'price_high':
                    $query->orderBy('price', 'desc'); break;
                case 'latest':
                default:
                    $query->latest(); break;
            }
        } else {
            $query->latest();
        }

        $products = $query->cursorPaginate(12);
        
        // Hitung total (Perhatikan jika ada filter kategori)
        $totalQuery = Product::where('is_active', true);

        if ($category) {
            $totalQuery->where('category_id', $category->id);
        }
        $totalProducts = $totalQuery->count();

        $categories = Category::withCount('products')->get();

        // Return view static untuk styling dulu
        return view('web.pages.product.index', compact('products', 'categories', 'totalProducts'));
    }

    public function show(Product $product)
    {
        // Load relasi yang dibutuhkan
        $product->load(['category', 'images', 'variants', 'downloads']);

        // Ambil produk terkait (misal berdasarkan kategori yang sama)
        $relatedProducts = Product::where('category_id', $product->category_id)
                            ->where('id', '!=', $product->id)
                            ->where('is_active', true)
                            ->take(4)
                            ->get();

        return view('web.pages.product.show', compact('product', 'relatedProducts'));
    }

    public function recommendations()
    {
        // Ambil 4 produk acak untuk rekomendasi
        $recommendedProducts = Product::where('is_active', true)
                                ->inRandomOrder()
                                ->take(4)
                                ->get()
                                ->map(function($product) {
                                    return [
                                        'name' => $product->name,
                                        'price_formatted' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                                        'image' => $product->thumbnail ?: asset('assets/web/images/placeholder.png'),
                                        'url' => route('products.show', $product->slug)
                                    ];
                                });

        return response()->json($recommendedProducts);
    }
}

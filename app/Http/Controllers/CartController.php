<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Cart\AddToCartRequest;
use App\Http\Requests\Web\Cart\UpdateCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Province;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Helper: Ambil atau Buat Cart
    private function getCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id()]
            );
        } else {
            $sessionId = Session::getId();
            return Cart::firstOrCreate(
                ['session_id' => $sessionId]
            );
        }
    }

    public function index()
    {
        $cart = $this->getCart();
        $summary = $this->getCartSummary($cart); // Logic kalkulasi dipanggil 1 baris saja

        // Extract array ke variabel terpisah untuk view
        return view('web.pages.cart.index', [
            'cartItems'   => $summary['items'],
            'subtotal'    => $summary['subtotal'],
            'shippingFee' => $summary['shipping_fee'],
            'tax'         => $summary['tax'],
            'total'       => $summary['total']
        ]);
    }

    public function addToCart(AddToCartRequest $request)
    {
        try {
            $cart = $this->getCart();
            $product = Product::findOrFail($request->product_id);

            // 1. Validasi & Ambil Varian (Lebih Ringkas & Aman)
            $variant = null;
            if ($product->has_variants) {
                if (!$request->filled('variant_id')) {
                    return $this->errorResponse($request, 'Silakan pilih varian produk terlebih dahulu.');
                }
                
                // Query scope: Hanya cari varian milik produk ini
                $variant = $product->variants()->find($request->variant_id);
                
                if (!$variant) {
                    return $this->errorResponse($request, 'Varian tidak valid atau tidak ditemukan.');
                }
            }

            // 2. Tentukan Stok Maksimal
            $maxStock = $variant ? $variant->stock : $product->stock;

            // 3. Cari Item di Cart (Pakai firstOrNew agar logic bersih)
            // Kita cari item, kalau tidak ada, buat instance baru (belum di-save ke DB)
            $cartItem = CartItem::firstOrNew([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'variant_id' => $variant ? $variant->id : null,
            ]);

            // 4. Hitung Total Qty (Qty di DB + Qty Request)
            // Jika item baru, $cartItem->qty defaultnya 0 (atau null), jadi aman.
            $currentQtyInCart = $cartItem->exists ? $cartItem->qty : 0; 
            $totalRequestedQty = $currentQtyInCart + $request->qty;

            // 5. Validasi Stok (Logic Bisnis Kritis)
            if ($totalRequestedQty > $maxStock) {
                $message = "Stok yang Anda masukkan melebihi stok maksimal. Stok barang ini adalah {$maxStock} item.";
                return $this->errorResponse($request, $message);
            }

            // 6. Simpan Perubahan
            $cartItem->qty = $totalRequestedQty;
            $cartItem->save();

            // 7. Response Sukses
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Produk berhasil ditambahkan!',
                    'cart_count' => $cart->items()->count() // Hitung ulang total item unik
                ]);
            }

            return back()
                    ->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Add to Cart Error: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Server Error.'], 500);
            }
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    // Helper kecil agar tidak mengulang logic if(wantsJson)
    private function errorResponse($request, $message, $code = 422)
    {
        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $message], $code);
        }
        return back()->with('error', $message);
    }

    public function updateQty(UpdateCartRequest $request, $id)
    {
        // 1. Validasi sudah ditangani otomatis oleh UpdateCartRequest.
        // Tidak perlu menulis $request->validate() lagi di sini.

        $cart = $this->getCart();

        // 2. Cari Item (Query Scope via Cart Relation lebih aman)
        // find($id) otomatis mencari id yang terhubung dengan $cart->items()
        $item = $cart->items()->with(['product', 'variant'])->find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        // 3. Cek Stok (Auto Adjust Logic)
        $availableStock = $item->variant ? $item->variant->stock : $item->product->stock;
        
        $qtyToUpdate = $request->qty;
        $message = 'Cart updated';
        $adjusted = false; // Flag untuk status

        if ($qtyToUpdate > $availableStock) {
            $qtyToUpdate = $availableStock;
            $message = "Stok terbatas. Jumlah disesuaikan ke maksimal tersisa {$availableStock}.";
            $adjusted = true;
        }

        // 4. Update Qty
        $item->qty = $qtyToUpdate;
        $item->save(); // Gunakan save() agar trigger event Eloquent jika ada

        // 5. Ambil Kalkulasi Global (Re-use logic)
        $summary = $this->getCartSummary($cart);

        // Hitung subtotal item spesifik ini untuk update UI baris tersebut
        $currentItemPrice = $item->variant ? $item->variant->price : ($item->product->final_price ?? $item->product->price);
        $itemSubtotal = $currentItemPrice * $item->qty;

        return response()->json([
            'success'       => true,
            'message'       => $message,
            'is_adjusted'   => $adjusted, // Info tambahan ke frontend jika perlu warning warna
            'current_qty'   => $qtyToUpdate,
            
            // Return data formatting
            'item_subtotal' => 'Rp ' . number_format($itemSubtotal, 0, ',', '.'),
            'cart_subtotal' => 'Rp ' . number_format($summary['subtotal'], 0, ',', '.'),
            'cart_tax'      => 'Rp ' . number_format($summary['tax'], 0, ',', '.'),
            'cart_total'    => 'Rp ' . number_format($summary['total'], 0, ',', '.'),
            'cart_count'    => $summary['cart_count']
        ]);
    }
    
    // Function remove, update qty, checkout (bisa ditambahkan nanti)
    // Method baru untuk mengambil data cart via AJAX
   public function getCartData()
    {
        try {
            $cart = $this->getCart();
            
            // Eager load images juga untuk mencegah N+1 query
            $cartItems = $cart->items()->with(['product.images', 'variant'])->latest()->get();
            
            $items = $cartItems->map(function ($item) {
                $product = $item->product;
                $variant = $item->variant;
                
                // Logic Gambar Aman (Safe Fallback)
                $image = asset('assets/web/images/placeholder.png'); // Default
                
                if ($product->images && $product->images->count() > 0) {
                    $primary = $product->images->where('is_primary', true)->first();
                    if ($primary) {
                        $image = asset('storage/' . $primary->image_path);
                    } else {
                        $image = asset('storage/' . $product->images->first()->image_path);
                    }
                }

                return [
                    'id' => $item->id,
                    'name' => $product->name,
                    'variant_name' => $variant ? $variant->name : null,
                    'price_formatted' => 'Rp ' . number_format($item->subtotal, 0, ',', '.'),
                    'qty' => $item->qty,
                    'image' => $image,
                    'remove_url' => route('cart.remove', $item->id),
                ];
            });

            $total = $cartItems->sum(fn($item) => $item->subtotal);

            return response()->json([
                'count' => $cartItems->count(),
                'items' => $items,
                'subtotal' => 'Rp ' . number_format($total, 0, ',', '.'),
                'cart_url' => route('cart.index'),
                'checkout_url' => route('cart.checkout') 
            ]);

        } catch (\Exception $e) {
            // Ini akan membantu kita melihat error aslinya di Console Network
            return response()->json(['error' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
    
    // Method untuk menghapus item (Dipakai tombol Remove di dropdown)
    public function remove($id)
    {
        $cart = $this->getCart();
        
        $item = CartItem::where('cart_id', $cart->id)->where('id', $id)->first();
        
        if ($item) {
            $item->delete();
            return response()->json(['success' => true, 'message' => 'Item removed']);
        }
        
        return response()->json(['success' => false, 'message' => 'Item not found'], 404);
    }

    public function checkout()
    {
        $cart = $this->getCart();

        // 1. Validasi Cart Kosong
        // Cek langsung jumlah item di DB tanpa load semua data dulu (lebih ringan)
        if ($cart->items()->count() === 0) {
            return to_route('cart.index')
                    ->with('error', 'Keranjang belanja Anda kosong.');
        }

        // 2. Ambil Kalkulasi dari Helper (DRY Principle)
        // Kita tidak perlu menulis ulang rumus pajak/ongkir di sini.
        $summary = $this->getCartSummary($cart);

        // 3. Ambil Data Pendukung (Provinces)
        $provinces = Province::orderBy('name')->get();

        // 4. Return View
        // Kita pecah array $summary agar variabel di View tetap sama ($cartItems, $subtotal, dll)
        return view('web.pages.cart.checkout', [
            'cartItems'   => $summary['items'],
            'subtotal'    => $summary['subtotal'],
            'shippingFee' => $summary['shipping_fee'], // Perhatikan key-nya disesuaikan dengan view
            'tax'         => $summary['tax'],
            'total'       => $summary['total'],
            'provinces'   => $provinces
        ]);
    }

    /**
     * Helper terpusat untuk menghitung total belanja.
     * Mengembalikan array data yang siap pakai.
    */
    private function getCartSummary($cart)
    {
        // Eager load untuk mencegah N+1
        $items = $cart->items()
                    ->with(['product', 'variant'])
                    ->get();

        // Hitung Subtotal
        $subtotal = $items->sum(function ($item) {
            $price = $item->variant ? $item->variant->price : ($item->product->final_price ?? $item->product->price);
            return (int)$price * $item->qty;
        });

        // --- UPDATE START: Integrasi Database Setting ---

        // 1. Ambil Ongkir (Default 50.000)
        // Pastikan import model Setting di paling atas file: use App\Models\Setting;
        $shippingFee = Setting::getValue('flat_shipping_fee', 50000);

        // 2. Ambil Persentase Pajak (Default 11)
        $taxPercentage = Setting::getValue('tax_rate', 11);
        
        // 3. Hitung Nominal Pajak (Persen / 100 * Subtotal)
        $tax = $subtotal * ($taxPercentage / 100);

        // 4. Hitung Total Akhir
        $total = $subtotal + $shippingFee + $tax;

        return [
            'items'        => $items,
            'subtotal'     => $subtotal,
            'shipping_fee' => $shippingFee,
            'tax'          => $tax,
            'tax_percent'  => $taxPercentage, // <--- Penting untuk label dinamis di View
            'total'        => $total,
            'cart_count'   => $items->count()
        ];
    }
}
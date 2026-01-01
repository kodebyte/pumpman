<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Cart\CheckoutRequest;
use App\Mail\Admin\NewOrderNotification;
use App\Mail\Admin\PaymentReceivedNotification;
use App\Mail\OrderInvoice;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail; // Import Facade Mail
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Mail\OrderPlaced; // Import Mailable
use App\Mail\OrderPaid;   // Import Mailable
use Pest\Support\Str;

class CheckoutController extends Controller
{
    public function process(
        CheckoutRequest $request
    )
    {
        // 2. Ambil Data Cart User
        $cartQuery = Cart::query();

        if (Auth::check()) {
            // Skenario A: User Login
            // Cari cart milik user tersebut
            $cartQuery->where('user_id', Auth::id());
        } else {
            // Skenario B: Guest
            // Cari cart berdasarkan Session ID saat ini
            $cartQuery->where('session_id', session()->getId());
        }

        $cart = $cartQuery->first();

        // Validasi Cart
        if (!$cart || $cart->items()->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        // Gunakan Database Transaction agar jika ada error di tengah, semua data dibatalkan (Rollback)
        try {
            $order = DB::transaction(function()use($request, $cart) {
                if (Auth::check()) {
                    $user = Auth::user();
                    // Kita update data user dengan data pengiriman terbaru
                    $user->update([
                        'phone'       => $request->phone,
                        'address'     => $request->address,
                        'province_id' => $request->province_id,
                        'city_id'     => $request->city_id,
                        'postal_code' => $request->postal_code,
                    ]);
                }

                // 3. Hitung Ulang Total (Jangan percaya input dari frontend demi keamanan)
                $cartItems = $cart->items()->with(['product', 'variant'])->get();
                $subtotal = 0;
                $itemsForMidtrans = [];

                foreach ($cartItems as $item) {
                    // Tentukan harga (Varian atau Produk Utama)
                    $price = $item->variant ? $item->variant->price : ($item->product->final_price ?? $item->product->price);
                    $subtotal += $price * $item->qty;

                    // Siapkan array item untuk Midtrans (Optional tapi bagus untuk detail di popup)
                    $itemsForMidtrans[] = [
                        'id'       => $item->variant_id ? 'VAR-'.$item->variant_id : 'PROD-'.$item->product_id,
                        'price'    => (int)$price,
                        'quantity' => $item->qty,
                        'name'     => substr($item->product->name . ($item->variant ? ' - ' . $item->variant->name : ''), 0, 50),
                    ];
                }

                // Biaya Tambahan (Sesuai CartController)
                $shippingFee = 50000;
                $taxRate = 0.11;
                $tax = $subtotal * $taxRate;
                $grandTotal = $subtotal + $shippingFee + $tax;

                // Tambahkan Shipping & Tax ke list item Midtrans agar totalnya match
                if ($shippingFee > 0) {
                    $itemsForMidtrans[] = [
                        'id' => 'SHIPPING',
                        'price' => (int)$shippingFee,
                        'quantity' => 1,
                        'name' => 'Shipping Fee (Flat Rate)'
                    ];
                }
                if ($tax > 0) {
                    $itemsForMidtrans[] = [
                        'id' => 'TAX',
                        'price' => (int)$tax,
                        'quantity' => 1,
                        'name' => 'Tax (PPN 11%)'
                    ];
                }

                $tempOrderNumber = 'TEMP-' . Str::random(10);

                $order = Order::create([
                    'user_id'       => Auth::id(), // Null jika gues
                    'order_number'  => $tempOrderNumber,
                    'status'        => 'pending',
                    'payment_status'=> 'unpaid',
                    'first_name'    => $request->first_name,
                    'last_name'     => $request->last_name,
                    'email'         => $request->email,
                    'phone'         => $request->phone,
                    'address'       => $request->address,
                    'province_id'   => $request->province_id,
                    'province_name' => $request->province_name,
                    'city_id'       => $request->city_id,
                    'city_name'     => $request->city_name,
                    'postal_code'   => $request->postal_code,
                    'total_price'   => $grandTotal,
                    'shipping_price'=> $shippingFee,
                    'tax_price'     => $tax,
                ]);

                $date = now()->format('dmy');
                $randomStr = strtoupper(Str::random(2));
                
                // Gunakan str_pad agar ID 5 menjadi 0005. 
                // Jika ID sudah 10000, str_pad tidak akan memotongnya, tetap jadi 10000.
                $idCounter = str_pad($order->id, 4, '0', STR_PAD_LEFT);

                $orderNumber = "ODP-{$date}-{$randomStr}-{$idCounter}";

                $order->update([
                    'order_number' => $orderNumber
                ]);

                // 5. Pindahkan Item Cart ke Order Items
                foreach ($cartItems as $item) {
                    // Tentukan target stok: Apakah Varian atau Produk Utama?
                    $stockSource = $item->variant ? $item->variant : $item->product;

                    // A. VALIDASI STOK TERAKHIR (Penting untuk Race Condition)
                    // Cek lagi apakah stok cukup sebelum dikurangi
                    if ($stockSource->stock < $item->qty) {
                        throw new \Exception("Stok untuk produk {$item->product->name} tidak mencukupi. Tersisa: {$stockSource->stock}");
                    }

                    // B. KURANGI STOK (RESERVE)
                    $stockSource->decrement('stock', $item->qty);

                    // C. Simpan ke OrderItem
                    $price = $item->variant ? $item->variant->price : ($item->product->final_price ?? $item->product->price);
                    
                    OrderItem::create([
                        'order_id'      => $order->id,
                        'product_id'    => $item->product_id,
                        'variant_id'    => $item->variant_id,
                        'product_name'  => $item->product->name,
                        'variant_name'  => $item->variant ? $item->variant->name : null,
                        'qty'           => $item->qty,
                        'price'         => $price,
                        'subtotal'      => $price * $item->qty,
                    ]);
                }

                // 6. Integrasi Midtrans Snap
                // Set konfigurasi Midtrans
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized = config('midtrans.is_sanitized');
                Config::$is3ds = config('midtrans.is_3ds');

                // Parameter untuk request Snap Token
                $midtransParams = [
                    'transaction_details' => [
                        'order_id' => $orderNumber, // Gunakan Order Number kita sebagai ID di Midtrans
                        'gross_amount' => (int)$grandTotal, // Total harus bulat (integer)
                    ],
                    'customer_details' => [
                        'first_name' => $request->first_name,
                        'last_name'  => $request->last_name,
                        'email'      => $request->email,
                        'phone'      => $request->phone,
                    ],
                    'item_details' => $itemsForMidtrans, // Opsional: Tampilkan detail item di popup
                ];

                // Dapatkan Snap Token dari Midtrans
                $snapToken = Snap::getSnapToken($midtransParams);

                // Simpan Snap Token ke Database Order
                $order->update(['snap_token' => $snapToken]);

                // 7. Hapus Cart User (Karena sudah jadi Order)
                $cart->items()->delete();
                // Opsional: $cart->delete(); jika ingin menghapus sesi cart-nya juga

                return $order;
            });

            Mail::to($order->email)
                ->send(new OrderPlaced($order));

            $adminEmail = config('mail.admin_address', 'postman@aiwa.id'); // Atau ganti dengan email spesifik admin

            Mail::to($adminEmail)
                ->send(new NewOrderNotification($order));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to(
            URL::signedRoute('checkout.success', ['orderNumber' => $order->order_number])
        );
    }

    public function callback(Request $request)
    {
        // 1. Set Konfigurasi
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // 2. Ambil Notifikasi
        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid Notification Payload'], 400);
        }

        // --- KEAMANAN TAMBAHAN: VERIFIKASI SIGNATURE KEY (WAJIB) ---
        // Rumus Midtrans: SHA512(order_id + status_code + gross_amount + ServerKey)
        $validSignature = hash('sha512',
        $notification->order_id . 
            $notification->status_code . 
            $notification->gross_amount . 
            config('midtrans.server_key')
        );

        if ($notification->signature_key !== $validSignature) {
            return response()->json(['message' => 'Invalid Signature'], 403);
        }
        // -----------------------------------------------------------

        // 3. Ambil Data Transaksi
        
        $order_id = $notification->order_id;
        
        // Gunakan lockForUpdate() untuk mencegah race condition (dua request memproses order yg sama)
        $order = Order::with('items.variant', 'items.product')
                      ->where('order_number', $order_id)
                      ->lockForUpdate() // Kunci baris ini selama transaksi berjalan
                      ->first();

        if (!$order) {
            return response()->json(['message' => 'Order Not Found'], 404);
        }

        if ($order->payment_status === 'paid') {
            return response()->json(['message' => 'Payment already processed']);
        }

        // --- KEAMANAN TAMBAHAN: VERIFIKASI JUMLAH (Opsional tapi disarankan) ---
        // Pastikan nominal yang dibayar sama persis dengan tagihan di database
        // Cegah hacker membayar Rp 1.000 untuk barang seharga Rp 1.000.000
        if ((int)$notification->gross_amount != (int)$order->total_price) {
            return response()->json(['message' => 'Invalid Amount'], 400);
        }
        // ---------------------------------------------------------------------

        try {
            DB::transaction(function()use($notification, $order)  {
                $status = $notification->transaction_status;
                $type = $notification->payment_type;
                $fraud = $notification->fraud_status;

                $paymentType = $notification->payment_type; // cth: bank_transfer, credit_card
                $paymentInfo = [];

                // Ambil detail spesifik tergantung tipe
                if ($paymentType == 'bank_transfer') {
                    // Untuk VA (BCA, BNI, BRI, Permata)
                    if (isset($notification->va_numbers[0])) {
                        $paymentInfo = [
                            'bank' => $notification->va_numbers[0]->bank,
                            'va_number' => $notification->va_numbers[0]->va_number
                        ];
                    } 
                    // Khusus Mandiri Bill Payment
                    elseif (isset($notification->biller_code)) { 
                        $paymentInfo = [
                            'bank' => 'mandiri',
                            'biller_code' => $notification->biller_code,
                            'bill_key' => $notification->bill_key
                        ];
                    }
                } elseif ($paymentType == 'credit_card') {
                    $paymentInfo = [
                        'bank' => $notification->bank ?? null,
                        'card_type' => $notification->card_type ?? null,
                        'masked_card' => $notification->masked_card ?? null
                    ];
                } elseif ($paymentType == 'gopay' || $paymentType == 'qris') {
                    // E-Wallet biasanya tidak ada detail bank, cukup tipe-nya saja
                } else {
                    // Echannel / Store (Indomaret/Alfamart)
                    $paymentInfo = [
                        'store' => $notification->store ?? null,
                    ];
                }

                // UPDATE DATA ORDER DENGAN INFO PEMBAYARAN
                $order->update([
                    'payment_type' => $paymentType,
                    'payment_info' => $paymentInfo // Laravel otomatis cast array ke JSON jika di model dicast
                ]);
        
                // 5. Update Status (Sama seperti sebelumnya)
                if ($status == 'capture') {
                    // Logic Khusus Kartu Kredit
                    if ($type == 'credit_card') {
                        if ($fraud == 'challenge') {
                            // Jika mencurigakan, jangan set Paid. Biarkan pending menunggu keputusan Admin.
                            $order->update(['payment_status' => 'unpaid', 'status' => 'pending']);
                        } else {
                            // Jika aman (fraud status == accept)
                            $order->update(['payment_status' => 'paid', 'status' => 'processing']);
                        }
                    }
                } elseif ($status == 'settlement') {
                    // Logic untuk Transfer Bank, E-Wallet, dll (Pasti Lunas)
                    $order->update(['payment_status' => 'paid', 'status' => 'processing']);
                }elseif ($status == 'pending') {
                    $order->update(['payment_status' => 'unpaid', 'status' => 'pending']);
                } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                    // GAGAL: KEMBALIKAN STOK (RESTOCK)
                    // Kita harus loop item di order ini untuk dikembalikan ke database produk
                    
                    // Cek dulu agar tidak restock 2x (jika midtrans kirim notif double)
                    if ($order->status !== 'cancelled') {
                        foreach ($order->items as $item) {
                            if ($item->variant_id) {
                                // Kembalikan ke Varian
                                $item->variant->increment('stock', $item->qty);
                            } else {
                                // Kembalikan ke Produk Utama
                                $item->product->increment('stock', $item->qty);
                            }
                        }
                    }

                    $order->update(['payment_status' => 'failed',    'status' => 'cancelled']);
                }

                if ($status == 'settlement' || ($status == 'capture' && $fraud == 'accept')) {
                    try {   
                        Mail::to($order->email)->send(new OrderPaid($order));

                        Mail::to($order->email)->send(new OrderInvoice($order));

                        $adminEmail = config('mail.admin_address', 'postman@aiwa.id');
                        Mail::to($adminEmail)->send(new PaymentReceivedNotification($order));
                    } catch (\Exception $e) {
                        \Log::error('Gagal kirim email: ' . $e->getMessage());
                    }
                }
            });
        } catch (\Exception $e) {
            \Log::error('Callback Error: ' . $e->getMessage());
            
            // Return 500 agar Midtrans tahu request gagal dan mencoba kirim lagi nanti
            return response()->json(['message' => 'Internal Server Error'], 500);
        }

        return response()->json(['message' => 'Callback received successfully']);
    }
    public function success($orderNumber)
    {
        // Cari order berdasarkan Order Number
        $order = Order::with('items')
                    ->where('order_number', $orderNumber)
                    ->firstOrFail();

        session()->flash('last_order_id', $order->id);

        // Tampilkan halaman sukses (dimana popup Midtrans akan muncul)
        return view('web.pages.cart.checkout-success', compact('order'));
    }

    public function paymentSuccess($orderNumber)
    {
        // Cari order
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return view('web.pages.cart.payment-success', compact('order'));
    }
}
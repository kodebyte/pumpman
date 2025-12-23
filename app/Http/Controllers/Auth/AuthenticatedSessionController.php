<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\LoginRequest;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('web.pages.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. TANGKAP SESSION ID GUEST (PENTING: Sebelum Login)
        // Kita simpan ID session saat ini (Guest) ke variabel, 
        // karena setelah authenticate(), session ID mungkin berubah.
        $guestSessionId = $request->session()->getId();

        // 2. Proses Login
        $request->authenticate();

        // 3. JALANKAN LOGIC MERGE CART DISINI (Manual)
        // Kita panggil fungsi helper private di bawah, kirim Session ID Guest & User
        $this->mergeCart($guestSessionId, Auth::user());

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function mergeCart($guestSessionId, $user)
    {
        // 1. Ambil Keranjang Guest berdasarkan ID yang sudah kita tangkap tadi
        $guestCart = Cart::with('items')
                        ->where('session_id', $guestSessionId)
                        ->whereNull('user_id')
                        ->first();

        if (!$guestCart) {
            return; // Tidak ada keranjang guest, selesai.
        }

        // 2. Ambil Keranjang User
        $userCart = Cart::where('user_id', $user->id)->first();

        // SKENARIO A: User belum punya keranjang
        if (!$userCart) {
            $guestCart->update([
                'user_id' => $user->id,
                'session_id' => null
            ]);
        } 
        // SKENARIO B: User sudah punya keranjang
        else {
            foreach ($guestCart->items as $guestItem) {
                // Cek duplikat item
                $existingUserItem = $userCart->items()
                    ->where('product_id', $guestItem->product_id)
                    ->where('variant_id', $guestItem->variant_id)
                    ->first();

                if ($existingUserItem) {
                    $existingUserItem->increment('qty', $guestItem->qty);
                    $guestItem->delete();
                } else {
                    $guestItem->update(['cart_id' => $userCart->id]);
                }
            }
            // Hapus cart guest sisa
            $guestCart->delete();
        }
    }
}

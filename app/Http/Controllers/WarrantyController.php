<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\Warranty\StoreWarrantyClaimRequest;
use App\Mail\WarrantyClaimSubmitted;
use App\Models\Product;
use App\Models\WarrantyClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class WarrantyController extends Controller
{
    public function claim()
    {
        $products = Product::where('is_active', true)
                    ->orderBy('name')->get(['id', 'name', 'sku']);

        return view('web.pages.warranty.claim', compact('products'));
    }

    public function success()
    {
        if (!session()->has('claim_code')) {
            return redirect()->route('warranty-claim');
        }

        return view('web.pages.warranty.claim-success');
    }

    public function store(StoreWarrantyClaimRequest $request)
    {
        try {
            $result = \DB::transaction(function() use($request) {
                $evidencePaths = [];
                
                if ($request->hasFile('invoice')) {
                    $path = $request->file('invoice')->store('warranty-claims/invoices', 'public');
                    $evidencePaths['invoice'] = $path;
                }

                if ($request->hasFile('warranty_card')) {
                    $path = $request->file('warranty_card')->store('warranty-claims/cards', 'public');
                    $evidencePaths['warranty_card'] = $path;
                }

                // 2. Generate Claim Code (WC-YYYYMMDD-RANDOM)
                $claimCode = 'WCA-' . date('ymd') . '-' . strtoupper(Str::random(5));

                // 3. Simpan ke Database
                $warrantyClaim = WarrantyClaim::create([
                    'claim_code' => $claimCode,
                    'user_id' => auth()->id() ?? null, // Jika user login
                    'product_id' => $request->product_id,
                    'serial_number' => $request->serial_number,
                    'purchase_date' => $request->purchase_date,
                    'description' => $request->issue, // Mapping 'issue' form ke 'description' DB
                    'evidence_photos' => $evidencePaths, // Simpan array path file
                    'customer_name' => $request->name,
                    'customer_phone' => $request->phone,
                    'customer_email' => $request->email, // Simpan ke kolom baru
                    'shipping_address' => $request->address, // Simpan alamat murni saja
                    'status' => 'pending'
                ]);

                return [
                    'claimCode' => $claimCode,
                    'warrantyClaim' => $warrantyClaim
                ];
            });

            try {
                Mail::to($request->email)
                    ->send(new WarrantyClaimSubmitted($result['warrantyClaim']));
            } catch (\Exception $e) {
                \Log::error('Gagal kirim email klaim (Code: '.$result['claimCode'].'): ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            return redirect()
                    ->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }

        return redirect()
                ->route('warranty-claim.success')
                ->with('claim_code', $result['claimCode']);

    }

    public function status(
        Request $request,
    )
    {
        $claim = null;

        if ($request->has('ticket')) {
            $ticketCode = trim($request->ticket);
            
            $claim = WarrantyClaim::where('claim_code', $ticketCode)
                ->with('product') // Load relasi produk agar nama produk muncul
                ->first();

            if (!$claim) {
                return back()
                        ->with('error', "Nomor Tiket '{$ticketCode}' tidak ditemukan. Mohon periksa kembali.");
            }
        }
        
        return view('web.pages.warranty.check', compact('claim'));
    }
}

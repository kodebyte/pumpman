<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreLocatorController extends Controller
{
    public function index(Request $request)
    {
        // 1. Query Dasar
        $query = Store::where('is_active', true)->orderBy('order')->orderBy('name');

        // 2. Filter Pencarian (Opsional)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // 3. Filter Provinsi (Opsional)
        if ($request->filled('province') && $request->province !== 'All Provinces') {
            $query->where('province', $request->province);
        }

        $stores = $query->get();

        // 4. Ambil List Provinsi Unik untuk Dropdown
        $provinces = Store::where('is_active', true)
                        ->distinct()
                        ->pluck('province')
                        ->sort();

        return view('web.pages.store.find', compact('stores', 'provinces'));
    }
}

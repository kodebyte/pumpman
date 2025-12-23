<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data wilayah untuk dropdown
        $provinces = Province::orderBy('name', 'asc')->get();
        $cities = $user->province_id ? City::where('province_id', $user->province_id)->get() : [];
        $districts = $user->city_id ? District::where('city_id', $user->city_id)->get() : [];

        return view('web.pages.user.account.index', compact('user', 'provinces', 'cities', 'districts'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'required|numeric|digits_between:10,14',
            'password' => 'nullable|min:8|confirmed', // Opsional ganti password
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateAddress(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'address' => 'required|string|max:500',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'postal_code' => 'required|numeric',
        ]);

        $user->update([
            'address' => $request->address,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'postal_code' => $request->postal_code,
        ]);

        return back()->with('success', 'Alamat pengiriman berhasil disimpan.');
    }
}
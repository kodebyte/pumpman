<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmployeeLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
   public function create(): View
    {
        return view('admin.pages.auth.login');
    }

    public function store(EmployeeLoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()
                ->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('employee')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
                ->route('admin.login');
    }
}

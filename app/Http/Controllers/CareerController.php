<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $careers = Career::where('is_active', true)
                        ->orderBy('order', 'asc')
                        ->get();
                        
        return view('web.pages.career.index', compact('careers'));
    }
}

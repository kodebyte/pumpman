<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $faqCategories = Faq::whereNull('parent_id')
                            ->where('is_active', true)
                            ->orderBy('order')
                            ->with(['children' => function($query) {
                                $query->where('is_active', true)->orderBy('order');
                            }])
                            ->get();

        return view('web.pages.faq.index', compact('faqCategories'));
    }
}

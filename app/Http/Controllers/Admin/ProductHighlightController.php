<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\ProductHighlightRepositoryInterface;
use App\Services\ProductHighlightService;
use Illuminate\Http\Request;

class ProductHighlightController extends Controller
{
    public function __construct(
        protected ProductHighlightRepositoryInterface $highlightRepo,
        protected ProductHighlightService $highlightService
    ) {}

    public function index()
    {
        $highlight = $this->highlightRepo->getHighlight();

        return view('admin.pages.product-highlight.index', compact('highlight'));
    }

    public function update(
        Request $request
    )
    {
        try {
            $this->highlightService->update($request->only([
                'image',
                'tagline',
                'title',
                'description',
                'features', 
                'button_text',
                'button_url',
                'is_active'
            ]));
        } catch (\Exception $e) {
            \Log::error('Highlight update error: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to update highlight.');
        }

         return back()
                ->with('success', 'Product Highlight updated successfully');
    }
}
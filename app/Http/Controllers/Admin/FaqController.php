<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\FaqRepositoryInterface;
use App\Services\FaqService;
use App\Http\Requests\Admin\Faq\StoreFaqRequest;
use App\Http\Requests\Admin\Faq\UpdateFaqRequest;
use App\Models\Faq;

class FaqController extends Controller
{
    // Dependency Injection
    public function __construct(
        protected FaqRepositoryInterface $faqRepo,
        protected FaqService $faqService
    ) {}

    /**
     * Menampilkan daftar FAQ (Kategori & Pertanyaan).
     */
    public function index()
    {
        // 1. Tangkap parameter filter & sort
        $params = request()->only([
            'search', 
            'is_active', 
            'sort', 
            'direction'
        ]);

        $perPage = request('limit', 15);
        $faqs = $this->faqRepo->getAll($params, $perPage);
        
        return view('admin.pages.faq.index', compact(
            'faqs', 
            'perPage'
        ));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        $categories = $this->faqRepo->getCategoriesList();
        
        return view('admin.pages.faq.create', compact('categories'));
    }

    /**
     * Menyimpan data baru.
     */
    public function store(
        StoreFaqRequest $request
    )
    {
        try {
            $this->faqService->create(
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Create FAQ error: ' . $e->getMessage());
            
            return back()->withInput()
                    ->with('error', 'Failed to create FAQ. Please try again.');
        }

        return to_route('admin.faqs.index')
                ->with('success', 'FAQ created successfully');
    }

   /**
     * Menampilkan form edit.
     */
    public function edit(
        Faq $faq
    )
    {
        $allCategories = $this->faqRepo->getCategoriesList();

        $categories = $allCategories->filter(function ($cat) use ($faq) {
            return $cat->id !== $faq->id;
        });

        return view('admin.pages.faq.edit', compact(
            'faq', 
            'categories'
        ));
    }

    /**
     * Memperbarui data.
     */
    public function update(
        UpdateFaqRequest $request, 
        Faq $faq
    )
    {
        try {
            $this->faqService->update(
                $faq->id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Update FAQ error: ' . $e->getMessage());
            
            return back()->withInput()
                    ->with('error', 'Failed to update FAQ.');
        }

        return to_route('admin.faqs.index')
                ->with('success', 'FAQ updated successfully');
    }

    /**
     * Menghapus data.
     */
    public function destroy(
        Faq $faq
    )
    {
        try {
            $this->faqService->delete($faq->id);
        } catch (\Exception $e) {
            \Log::error('Delete FAQ error: ' . $e->getMessage());
            
            return back()
                    ->with('error', 'Failed to delete FAQ.');
        }

        return to_route('admin.faqs.index')
                ->with('success', 'FAQ deleted successfully');
    }
}
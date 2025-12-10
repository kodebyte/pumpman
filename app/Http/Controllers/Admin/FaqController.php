<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\FaqRepositoryInterface;
use App\Services\FaqService;
use App\Http\Requests\Admin\Faq\StoreFaqRequest;
use App\Http\Requests\Admin\Faq\UpdateFaqRequest;
use Illuminate\Support\Facades\Log;
use Exception;

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
        $params = request()->only(['search', 'is_active', 'sort', 'direction']);
        $perPage = request('limit', 15);
        
        // 2. Ambil data dari Repository
        $faqs = $this->faqRepo->getAll($params, $perPage);
        
        return view('admin.pages.faq.index', compact('faqs', 'perPage'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        // Kita butuh list Kategori (Parent) untuk dropdown "Assign to Category"
        $categories = $this->faqRepo->getCategoriesList();
        
        return view('admin.pages.faq.create', compact('categories'));
    }

    /**
     * Menyimpan data baru.
     */
    public function store(StoreFaqRequest $request)
    {
        try {
            $this->faqService->create($request->validated());
            
            return to_route('admin.faqs.index')
                    ->with('success', 'FAQ created successfully');
        } catch (Exception $e) {
            Log::error('Create FAQ error: ' . $e->getMessage());
            
            return back()->withInput()
                    ->with('error', 'Failed to create FAQ. Please try again.');
        }
    }

   /**
     * Menampilkan form edit.
     */
    public function edit(string $id)
    {
        // 1. Konversi ID ke integer agar aman
        $faqId = (int) $id;

        // 2. Ambil data FAQ (Akan otomatis 404 jika tidak ditemukan)
        // Kita tidak pakai try-catch disini agar jika error, Laravel menampilkan detailnya.
        $faq = $this->faqRepo->findById($faqId);
        
        // 3. Ambil list kategori untuk dropdown parent
        $allCategories = $this->faqRepo->getCategoriesList();

        // 4. Filter: Hapus diri sendiri dari list kategori (agar tidak jadi parent buat diri sendiri)
        $categories = $allCategories->filter(function ($cat) use ($faqId) {
            return $cat->id !== $faqId;
        });

        return view('admin.pages.faq.edit', compact('faq', 'categories'));
    }

    /**
     * Memperbarui data.
     */
    public function update(UpdateFaqRequest $request, string $id)
    {
        try {
            $this->faqService->update($id, $request->validated());
            
            return to_route('admin.faqs.index')
                ->with('success', 'FAQ updated successfully');

        } catch (Exception $e) {
            Log::error('Update FAQ error: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Failed to update FAQ.');
        }
    }

    /**
     * Menghapus data.
     */
    public function destroy(string $id)
    {
        try {
            // Peringatan: Jika Kategori dihapus, semua anaknya (pertanyaan) 
            // akan ikut terhapus karena 'onDelete cascade' di migration.
            $this->faqService->delete($id);
            
            return to_route('admin.faqs.index')
                ->with('success', 'FAQ deleted successfully');

        } catch (Exception $e) {
            Log::error('Delete FAQ error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to delete FAQ.');
        }
    }
}
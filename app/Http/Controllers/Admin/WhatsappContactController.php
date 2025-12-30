<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\WhatsappContactRepositoryInterface;
use App\Services\WhatsappContactService;
use App\Http\Requests\Admin\WhatsappContact\StoreWhatsappContactRequest;
use App\Http\Requests\Admin\WhatsappContact\UpdateWhatsappContactRequest;
use App\Models\WhatsappContact;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WhatsappContactController extends Controller
{
    public function __construct(
        protected WhatsappContactRepositoryInterface $contactRepo,
        protected WhatsappContactService $contactService
    ) {}

    public function index(): View
    {
        // Tambahkan 'sort' dan 'direction' ke sini
        $params = request()->only(['search', 'is_active', 'sort', 'direction']);
        
        $contacts = $this->contactRepo->getAll($params);
        
        return view('admin.pages.whatsapp.index', compact('contacts'));
    }

    public function create(): View
    {
        return view('admin.pages.whatsapp.create');
    }

    public function store(StoreWhatsappContactRequest $request): RedirectResponse
    {
        try {
            $this->contactService->create($request->validated());
            return to_route('admin.whatsapp.index')->with('success', 'Contact created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create contact: ' . $e->getMessage());
        }
    }

    public function edit(WhatsappContact $whatsapp): View
    {
        // Note: Route parameter binding biasanya menggunakan nama model (whatsapp), 
        // tapi di view kita pakai variabel $contact agar konsisten
        return view('admin.pages.whatsapp.edit', ['contact' => $whatsapp]);
    }

    public function update(UpdateWhatsappContactRequest $request, WhatsappContact $whatsapp): RedirectResponse
    {
        try {
            $this->contactService->update($whatsapp->id, $request->validated());
            return to_route('admin.whatsapp.index')->with('success', 'Contact updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update contact: ' . $e->getMessage());
        }
    }

    public function destroy(WhatsappContact $whatsapp): RedirectResponse
    {
        try {
            $this->contactService->delete($whatsapp->id);
            return to_route('admin.whatsapp.index')->with('success', 'Contact deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete contact.');
        }
    }
}
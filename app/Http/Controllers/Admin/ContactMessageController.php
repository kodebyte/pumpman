<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\ContactMessageRepositoryInterface;
use App\Services\ContactMessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function __construct(
        protected ContactMessageRepositoryInterface $contactRepo,
        protected ContactMessageService $contactService
    ) {}

    public function index(): View
    {
        $params = request()->only([
            'search', 
            'is_read'
        ]);

        $perPage = request('limit', default: 15);
        $messages = $this->contactRepo->getAll($params, $perPage);
        
        return view('admin.pages.contact.index', compact(
            'messages', 
            'perPage'
        ));
    }

    public function show(
        string $id
    )
    {
        $message = $this->contactService->showMessage($id);
        
        return view('admin.pages.contact.show', compact('message'));
    }

    public function destroy(
        string $id
    ): RedirectResponse
    {
        try {
            $this->contactService->deleteMessage($id);
        } catch (\Exception $e) {
            \Log::error('Error deleting contact message: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete message.');
        }
        
        return to_route('admin.contacts.index')
                ->with('success', 'Message deleted successfully');
    }
}
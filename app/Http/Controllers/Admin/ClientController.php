<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\ClientRepositoryInterface;
use App\Services\ClientService;
use App\Http\Requests\Admin\Client\StoreClientRequest;
use App\Http\Requests\Admin\Client\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function __construct(
        protected ClientRepositoryInterface $clientRepo,
        protected ClientService $clientService
    ) {}

    public function index(): View
    {
        $params = request()->only(['search', 'sort', 'direction', 'is_active']);
        $perPage = request('limit', 15);

        $clients = $this->clientRepo->getAll($params, $perPage);
        
        return view('admin.pages.client.index', compact('clients', 'perPage'));
    }

    public function create(): View
    {
        return view('admin.pages.client.create');
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        try {
             $this->clientService->create($request->validated());
        } catch (\Exception $e) {
            \Log::error('Error creating client: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create client.');
        }
        
        return to_route('admin.clients.index')->with('success', 'Client created successfully');
    }

    public function edit(Client $client): View
    {
        return view('admin.pages.client.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        try {
             $this->clientService->update($client->id, $request->validated());
        } catch (\Exception $e) {
            \Log::error('Error update client: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update client.');
        }

        return to_route('admin.clients.index')->with('success', 'Client updated successfully');
    }

    public function destroy(Client $client): RedirectResponse
    {
        try {
            $this->clientService->delete($client->id);
        } catch (\Exception $e) {
            \Log::error('Error delete client: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete client.');
        }
        
        return to_route('admin.clients.index')->with('success', 'Client deleted successfully');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\WarrantyClaimRepositoryInterface;
use App\Services\WarrantyClaimService;
use Illuminate\Http\Request;

class WarrantyClaimController extends Controller
{
    public function __construct(
        protected WarrantyClaimRepositoryInterface $repo,
        protected WarrantyClaimService $service
    ) {}

    public function index()
    {
        $params = request()->only(['search', 'status']);
        $perPage = request('limit', 10);
        $claims = $this->repo->getAll($params, $perPage);

        return view('admin.pages.warranty.index', compact('claims', 'perPage'));
    }

    public function show(string $id)
    {
        $claim = $this->repo->findById($id);
        return view('admin.pages.warranty.show', compact('claim'));
    }

    public function update(Request $request, string $id)
    {
        // Admin hanya update status & notes
        $validated = $request->validate([
            'status' => 'required|string',
            'admin_notes' => 'nullable|string',
            'admin_tracking_number' => 'nullable|string',
        ]);

        $this->service->updateStatus($id, $validated);

        return back()->with('success', 'Warranty claim status updated.');
    }

    public function destroy(string $id)
    {
        try {
            $this->service->delete($id);
            return to_route('admin.warranty-claims.index')->with('success', 'Claim deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete claim.');
        }
    }
}
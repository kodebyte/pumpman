<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\WarrantyClaimRepositoryInterface;
use App\Http\Requests\Admin\Warranty\UpdateWarrantyRequest;
use App\Services\WarrantyClaimService;

class WarrantyClaimController extends Controller
{
    public function __construct(
        protected WarrantyClaimRepositoryInterface $repo,
        protected WarrantyClaimService $service
    ) {}

    public function index()
    {
        $params = request()->only([
            'search', 
            'status'
        ]);

        $perPage = request('limit', 10);
        $claims = $this->repo->getAll($params, $perPage);

        return view('admin.pages.warranty.index', compact(
            'claims', 
            'perPage'
        ));
    }

    public function show(
        string $id
    )
    {
        $claim = $this->repo->findById($id);

        return view('admin.pages.warranty.show', compact('claim'));
    }

    public function update(
        UpdateWarrantyRequest $request, 
        string $id
    )
    {
        try {
             $this->service->updateStatus(
                $id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Error update warranty: ' . $e->getMessage());

            return back()->withInput() // Form tidak kosong lagi
                    ->with('error', 'Failed to update warranty. Please try again.');
        }

        return to_route('admin.warranty-claims.index')
                ->with('success', 'Warranty claim status updated.');
    }

    public function destroy(
        string $id
    )
    {
        try {
            $this->service->delete($id);
        } catch (\Exception $e) {
            \Log::error('Error delete warranty: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete claim.');
        }

        return to_route('admin.warranty-claims.index')
                ->with('success', 'Claim deleted successfully');
    }
}
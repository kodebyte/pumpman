<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\CareerRepositoryInterface;
use App\Services\CareerService;
use App\Http\Requests\Admin\Career\StoreCareerRequest;
use App\Http\Requests\Admin\Career\UpdateCareerRequest;
use App\Models\Career;
use Illuminate\Support\Facades\Log;

class CareerController extends Controller
{
    public function __construct(
        protected CareerRepositoryInterface $careerRepo,
        protected CareerService $careerService
    ) {}

    public function index()
    {
        $params = request()->only([
            'search', 
            'is_active', 
            'sort', 
            'direction'
        ]);

        $perPage = request('limit', 15);
        
        $careers = $this->careerRepo->getAll($params, $perPage);
        
        return view('admin.pages.career.index', compact('careers', 'perPage'));
    }

    public function create()
    {
        return view('admin.pages.career.create');
    }

    public function store(
        StoreCareerRequest $request
    )
    {
        try {
            $this->careerService->create(
                $request->validated()
            );
        } catch (\Exception $e) {
            Log::error('Create career error: ' . $e->getMessage());

            return back()->withInput()
                     ->with('error', 'Failed to create career.');
        }

        return to_route('admin.careers.index')
                ->with('success', 'Career created successfully');
    }

    public function edit(
        Career $career
    )
    {
        return view('admin.pages.career.edit', compact('career'));
    }

    public function update(
        UpdateCareerRequest $request, 
        Career $career
    )
    {
        try {
            $this->careerService->update(
                $career->id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            Log::error('Update career error: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to update career.');
        }

        return to_route('admin.careers.index')
                ->with('success', 'Career updated successfully');
    }

    public function destroy(
        Career $career
    )
    {
        try {
            $this->careerService->delete($career->id);
            
            return to_route('admin.careers.index')
                    ->with('success', 'Career deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Error deleting career message: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete career.');
        }
    }
}
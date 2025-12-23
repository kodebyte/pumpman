<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\CourierRepositoryInterface;
use App\Services\CourierService;
use App\Http\Requests\Admin\Courier\StoreCourierRequest;
use App\Http\Requests\Admin\Courier\UpdateCourierRequest;
use App\Models\Courier;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CourierController extends Controller
{
    public function __construct(
        protected CourierRepositoryInterface $courierRepo,
        protected CourierService $courierService
    ) {}

    public function index(): View
    {
        $params = request()->only([
            'search', 
            'sort', 
            'direction', 
            'is_active'
        ]);

        $perPage = request('limit', default: 15);
        $couriers = $this->courierRepo->getAll($params, $perPage);
        
        return view('admin.pages.courier.index', compact(
            'couriers', 
            'perPage'
        ));
    }

    public function create(): View
    {
        return view('admin.pages.courier.create');
    }

    public function store(
        StoreCourierRequest $request
    ): RedirectResponse
    {
        try {
            $this->courierService->create($request->validated());
        } catch (\Exception $e) {
            \Log::error('Error creating courier: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to create courier.');
        }
        
        return to_route('admin.couriers.index')
                ->with('success', 'Courier created successfully');
    }

    public function edit(
        Courier $courier
    ): View
    {
        return view('admin.pages.courier.edit', compact('courier'));
    }

    public function update(
        UpdateCourierRequest $request, 
        Courier $courier
    ): RedirectResponse
    {
        try {
            $this->courierService->update(
                $courier->id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Error update courier: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to update courier.');
        }

        return to_route('admin.couriers.index')
                ->with('success', 'Courier updated successfully');
    }

    public function destroy(
        Courier $courier
    ): RedirectResponse
    {
        try {
            $this->courierService->delete($courier->id);
        } catch (\Exception $e) {
            \Log::error('Error delete courier: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete courier. It might be linked to orders.');
        }
        
        return to_route('admin.couriers.index')
                ->with('success', 'Courier deleted successfully');
    }
}
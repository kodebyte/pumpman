<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\EmployeeRepositoryInterface;
use App\Services\EmployeeService;
use App\Http\Requests\Admin\Employee\StoreEmployeeRequest;
use App\Http\Requests\Admin\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\EmployeeRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeRepositoryInterface $employeeRepo,
        protected EmployeeService $employeeService
    ) {}

   public function index(): View
    {
        $params = request()->only([
            'search', 
            'sort', 
            'direction', 
            'role_id'
        ]);

        $perPage = request('limit', 15);
        $employees = $this->employeeRepo->getAll($params, $perPage);

        $roles = EmployeeRole::all();

        return view('admin.pages.employee.index', compact(
            'employees', 
            'roles', 
            'perPage'
        ));
    }

    public function create(): View
    {
        $roles = EmployeeRole::all();

        return view('admin.pages.employee.create', compact('roles'));
    }

    public function store(
        StoreEmployeeRequest $request
    ): RedirectResponse
    {
        try {
            $this->employeeService->create(
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Error creating employee: ' . $e->getMessage());

            return back()->withInput() // Form tidak kosong lagi
                    ->with('error', 'Failed to create employee. Please check your inputs or try again.');
        }

        return to_route('admin.employees.index')
                ->with('success', 'Employee created successfully');
    }

    public function edit(
        Employee $employee
    ): View
    {
        $roles = EmployeeRole::all();

        return view('admin.pages.employee.edit', compact('employee', 'roles'));
    }

    public function update(
        UpdateEmployeeRequest $request, 
        Employee $employee
    ): RedirectResponse
    {
        try {
             $this->employeeService->update(
                $employee->id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Error update employee: ' . $e->getMessage());

            return back()->withInput() // Form tidak kosong lagi
                    ->with('error', 'Failed to update employee. Please try again.');
        }
        
        return to_route('admin.employees.index')
                ->with('success', 'Employee updated successfully');
    }

    public function destroy(
        Employee $employee
    ): RedirectResponse
    {
        try {
            $this->employeeService->delete(
                $employee->id
            );
        } catch (\Exception $e) {
            \Log::error('Error delete category: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete employee. It might be linked to other data.');
        }

        return to_route('admin.employees.index')
                ->with('success', 'Employee deleted successfully');
    }
}
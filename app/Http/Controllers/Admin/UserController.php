<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\UserRepositoryInterface;
use App\Services\UserService;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepo,
        protected UserService $userService
    ) {}

    public function index(): View
    {
        $params = request()->only([
            'search', 
            'sort', 
            'direction', 
            'is_active'
        ]);

        $perPage = request('limit', 15);
        $users = $this->userRepo->getAll($params, $perPage);
        
        return view('admin.pages.user.index', compact(
            'users', 
            'perPage'
        ));
    }

    public function create(): View
    {
        return view('admin.pages.user.create');
    }

    public function store(
        StoreUserRequest $request
    ): RedirectResponse
    {
        try {
             $this->userService->create(
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());

            return back()->withInput() // Form tidak kosong lagi
                    ->with('error', 'Failed to create user. Please check your inputs or try again.');
        }
        
        return to_route('admin.users.index')
                ->with('success', 'User created successfully');
    }

    public function edit(
        User $user
    ): View
    {
        return view('admin.pages.user.edit', compact('user'));
    }

    public function update(
        UpdateUserRequest $request, 
        User $user
    ): RedirectResponse
    {
        try {
             $this->userService->update(
                $user->id, 
                $request->validated()
            );
        } catch (\Exception $e) {
            \Log::error('Error update user: ' . $e->getMessage());

            return back()->withInput() // Form tidak kosong lagi
                    ->with('error', 'Failed to update user. Please try again.');
        }
        
        return to_route('admin.users.index')
                ->with('success', 'User updated successfully');
    }

    public function destroy(
        User $user
    ): RedirectResponse
    {
        try {
            $this->userService->delete($user->id);
        } catch (\Exception $e) {
            \Log::error('Error delete user: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete user. It might be linked to other data.');
        }
        
        return to_route('admin.users.index')
                ->with('success', 'User deleted successfully (Soft Deleted)');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\PostRepositoryInterface;
use App\Services\PostService;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use Illuminate\Support\Facades\Log;
use Exception;

class PostController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $postRepo,
        protected PostService $postService
    ) {}

    public function index()
    {
        $params = request()->only([
            'search', 
            'type', 
            'is_active', 
            'sort', 
            'direction'
        ]);
        $perPage = request('limit', 10);

        $posts = $this->postRepo->getAll(
            $params, 
            $perPage
        );
        
        return view('admin.pages.post.index', compact('posts', 'perPage'));
    }

    public function create()
    {
        return view('admin.pages.post.create');
    }

    public function store(StorePostRequest $request)
    {
        try {
            $this->postService
                ->create($request
                ->validated());

            return to_route('admin.posts.index')
                    ->with('success', 'Post created successfully');
        } catch (Exception $e) {
            Log::error('Create post error: ' . $e->getMessage());
            return back()->withInput()
                    ->with('error', 'Failed to create post.');
        }
    }

    public function edit(string $id)
    {
        $post = $this->postRepo->findById($id);
        return view('admin.pages.post.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, string $id)
    {
        try {
            $this->postService->update($id, $request->validated());
            return to_route('admin.posts.index')->with('success', 'Post updated successfully');
        } catch (Exception $e) {
            Log::error('Update post error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update post.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->postService->delete($id);
            return to_route('admin.posts.index')->with('success', 'Post deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete post.');
        }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\PostRepositoryInterface;
use App\Services\PostService;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostType;
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
            'post_type_id',
            'is_active', 
            'sort', 
            'direction'
        ]);
        $perPage = request('limit', 10);

        $posts = $this->postRepo->getAll(
            $params, 
            $perPage
        );

        $types = PostType::where('is_active', true)->get();
        
        return view('admin.pages.post.index', compact('posts', 'perPage', 'types'));
    }

    public function create()
    {
        $types = PostType::where('is_active', true)
                    ->get();

        return view('admin.pages.post.create', compact('types'));
    }

    public function store(
        StorePostRequest $request
    )
    {
        try {
            $this->postService->create(
                $request->validated()
            );
        } catch (Exception $e) {
            Log::error('Create post error: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to create post.');
        }

        return to_route('admin.posts.index')
                ->with('success', 'Post created successfully');
    }

    public function edit(
        Post $post
    )
    {
        $types = PostType::where('is_active', true)
                    ->get();
        
        return view('admin.pages.post.edit', compact('post', 'types'));
    }

    public function update(
        UpdatePostRequest $request, 
        Post $post
    )
    {
        try {
            $this->postService->update(
                $post->id, 
                $request->validated()
            );
        } catch (Exception $e) {
            Log::error('Update post error: ' . $e->getMessage());

            return back()->withInput()
                    ->with('error', 'Failed to update post.');
        }

        return to_route('admin.posts.index')
                ->with('success', 'Post updated successfully');
    }

    public function destroy(
        Post $post
    )
    {
        try {
            $this->postService->delete($post->id);
        } catch (Exception $e) {
            Log::error('Delete post error: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete post.');
        }

        return to_route('admin.posts.index')
                ->with('success', 'Post deleted successfully');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostType;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(?PostType $postType = null)
    {
        // 1. Buat query dasar untuk postingan yang sudah dipublish
        $query = Post::with(['author', 'type'])->published();

        // 2. Filter berdasarkan kategori jika ada
        if ($postType && $postType->exists) {
            $query->where('post_type_id', $postType->id);
        }

        // 3. Ambil 1 Post Terbaru sebagai Featured (Highlight Utama)
        // Gunakan clone agar query asli ($query) tidak terpengaruh limit/first
        $featuredPost = (clone $query)->latest('published_at')->first();

        // 4. Jika ada featured post, kecualikan dari list utama agar tidak double
        if ($featuredPost) {
            $query->where('id', '!=', $featuredPost->id);
        }

        // 5. Ambil sisa postingan dengan Cursor Pagination
        $posts = $query->latest('published_at')->cursorPaginate(9);

        // 6. Ambil semua tipe postingan untuk filter di view
        $postTypes = PostType::active()
                        ->orderBy('name', 'asc')
                        ->get();

        return view('web.pages.post.index', [
            'postTypes'    => $postTypes,
            'posts'        => $posts,
            'featuredPost' => $featuredPost, // Kirim langsung objeknya, bukan query
        ]);
    }

    public function show($slug)
    {
        $post = Post::with(['author', 'type'])
                ->where('slug', $slug)
                ->published()
                ->firstOrFail();

        $relatedPosts = Post::published()
                        ->where('id', '!=', $post->id)
                        ->latest('published_at')
                        ->take(3)
                        ->get();

        // SEO Data
        $title       = $post->getTranslation('meta_title') ?: $post->getTranslation('title');
        $description = $post->getTranslation('meta_description') ?: str($post->getTranslation('content'))->limit(150)->stripTags();
        $image       = $post->thumbnail ? asset('storage/' . $post->thumbnail) : null;

        return view('web.pages.post.show', compact('post', 'relatedPosts', 'title', 'description', 'image'));
    }
}
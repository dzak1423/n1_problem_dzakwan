<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(): View
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        $posts = Post::with('author')->latest('published_at')->simplePaginate(16);

        $posts->each(function (Post $post): void {
            $post->author;
        });

        return view('posts.index', [
            'posts' => $posts,
            'queryCount' => count(DB::getQueryLog()),
        ]);
    }
    

    public function report(): View
    {
        DB::flushQueryLog();
        DB::enableQueryLog();
    
        $posts = Post::with('author', 'category', 'tags')
            ->withCount('comments')
            ->latest('published_at')
            ->simplePaginate(200);
    
        return view('posts.report', [
            'posts' => $posts,
            'queryCount' => count(DB::getQueryLog()),
        ]);
    }
}

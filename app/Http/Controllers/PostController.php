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

        $posts = Post::query()->latest('published_at')->paginate(12);

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

        $posts = Post::query()->latest('published_at')->limit(200)->get();

        $posts->each(function (Post $post): void {
            $post->author;
            $post->category;
            $post->tags;
            $post->comments->count();
        });

        return view('posts.report', [
            'posts' => $posts,
            'queryCount' => count(DB::getQueryLog()),
        ]);
    }
}

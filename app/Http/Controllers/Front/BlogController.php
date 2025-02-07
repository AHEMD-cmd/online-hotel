<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Page;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(9);
        return view('front.blog', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->total_view = $post->total_view + 1;
        $post->update();
        return view('front.post', compact('post'));
    }
}

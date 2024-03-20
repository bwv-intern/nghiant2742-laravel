<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        if (!session('isLogin')) {
            return redirect()->route('login');
        }

        $posts = Http::get('https://jsonplaceholder.typicode.com/posts');
        $posts = json_decode($posts);
        return view('post.index', ['posts' => $posts]);
    }

}

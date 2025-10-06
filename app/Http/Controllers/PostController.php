<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with( ['user', 'comments.user'])->latest()->get();
        return view('blog.index', ['posts' => $posts]);
    }

    public function create() {
        return view('blog.modal-post');
    }

    public function store(Request $req) {
        $validated = $req->validate([
            'content' => 'required|string'
        ]);
        
        $post = $req->user()->posts()->create($validated);

        return redirect()->route('blog.index', $post);
    }

    public function addComment(Request $req, Post $post) {
        $validated = $req->validate([
            'content' => 'required|string'
        ]);

        $comment = $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        $comments = $post->comments()->with('user')->latest()->get();

        return view('components.comment', ['comments' => $comments]);

        
    }

    public function fetchComments(Post $post) {
        $comments = $post->comments()->with('user')->latest()->get();
        return view('components.comment', compact('comments'));
    }

}

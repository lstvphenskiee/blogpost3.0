<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with([
            'user',
            'comments' => function ($query) {
                $query->whereNull('parent_id')
                    ->with(['user', 'replies.user', 'replies.replies.user'])
                    ->latest();
            }
        ])->latest()->get();
        return view('blog.index', ['posts' => $posts]);
    }

    public function create() {
        return view('blog.modal-post');
    }

    // public function store(Request $req) {
    //     $validated = $req->validate([
    //         'content' => 'required|string'
    //     ]);
        
    //     $post = $req->user()->posts()->create($validated);

    //     $post->load('user', 'comments.user');

    //     return redirect()->route('components.post', ['post' => $post]);
    // }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'content' => 'required|string',
        ]);

        $post = $req->user()->posts()->create($validated);

        // load relationships for display
        $post->load('user', 'comments.user');

        // Return only a small partial for the new post
        return view('components.post', ['post' => $post]);
    }

    public function addComment(Request $req, Post $post) {
        $validated = $req->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',

        ]);

        $comment = $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'parent_id' =>$validated['parent_id'] ?? null,
        ]);

        $comments = $post->comments()
            ->with(['user', 'replies.user', 'replies.replies.user'])
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return view('components.comment', ['comments' => $comments]);
    }

    public function fetchComments(Post $post) {
        $comments = $post->comments()
        ->with(['user', 'replies.user', 'replies.replies.user'])
        ->whereNull('parent_id')
        ->latest()
        ->get();

        return view('components.comment', ['comments' => $comments]);
    }

}

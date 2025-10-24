<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Interfaces\PostRepositoryInterface;
use App\Http\Requests\PostRequest;
use App\Http\Requests\CommentRequest;

class PostController extends Controller
{
    private $post;

    public function __construct(PostRepositoryInterface $postRepo) {
        $this->post = $postRepo;
    }

    public function index() {
        $posts = $this->post->getPost();

        return view('blog.index', ['posts' => $posts]);
    }

    public function create() {
        return view('blog.modal-post');
    }

    public function store(PostRequest $req) {;
        $data = $req->validated();

        $post = $this->post->createPost($req->user(), $data);

        $post->load('user', 'comments.user');

        return view('components.post', ['post' => $post]);
    }

    public function update(PostRequest $req, Post $post) {
        // $validated = $request->validate([
        //     'content' => 'required|string',
        // ]);

        $data = $req->validated();

        // Check ownership
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // $post->update($validated);
        $updatePost = $this->post->updatePost($post, $data);

        // $post->load('user', 'comments.user');

        return view('components.post', ['post' => $post]);
    }

    public function destroy(Post $post) {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $this->post->deletePost($post);

        return response()->json(['success' => true]);
       
    }

    public function addComment(CommentRequest $req, Post $post) {
        $validated = $req->validated();

        $comments = $this->post->addComment($post, $validated);

        return view('components.comment', ['comments' => $comments]);
    }

    public function fetchComments(Post $post) {
        $comments = $this->post->fetchComments($post);

        return view('components.comment', ['comments' => $comments]);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use App\Http\Requests\CommentRequest;
use App\Services\PostService;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPosts();

        //wrap each post
        $postResources = PostResource::collection($posts);

        return view('blog.index', ['posts' => $postResources]);
    }

    public function create()
    {
        return view('blog.modal-post');
    }

    public function store(PostRequest $req)
    {
        $data = $req->validated();

        $post = $this->postService->createPost($req->user(), $data);
        $post->load('user', 'comments.user');

        // Wrap post with resource
        $postResource = new PostResource($post);

        return view('components.post', ['post' => $postResource]);
    }

    public function update(PostRequest $req, Post $post)
    {
        $data = $req->validated();

        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->postService->updatePost($post, $data);
        $post->load('user', 'comments.user');

        return view('components.post', ['post' => new PostResource($post)]);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $this->postService->deletePost($post);
        return response()->json(['success' => true]);
    }

    public function addComment(CommentRequest $req, Post $post)
    {
        $validated = $req->validated();
        $comments = $this->postService->addComment($post, $validated);

        return view('components.comment', ['comments' => $comments]);
    }

    public function fetchComments(Post $post)
    {
        $comments = $this->postService->fetchComments($post);
        return view('components.comment', ['comments' => $comments]);
    }
}
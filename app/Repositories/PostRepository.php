<?php


namespace App\Repositories;

use App\Models\Post;
use App\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function getPost() {
        $post = Post::with([
            'user',
            'comments' => function($query) {
                $query->whereNull('parent_id')
                ->with('user', 'replies.user', 'replies.replies.user')
                ->latest();
            }
        ])
        ->latest()
        ->get();
        return $post;
    }

    public function createPost($user, array $data) {
        // return Post::create($data);
        return $user->posts()->create($data);
    }

    public function updatePost($post, array $data) {
        // Check ownership
        if (!($post instanceof Post)) {
            $post = Post::findOrFail($post);
        }

        $post->update($data);

        return $post->fresh(['user', 'comments.user']);
    }

    public function deletePost($post) {
        if (!($post instanceof Post)) {
            $post = Post::findOrFail($post);
        }

        return $post->delete();
    }

    public function addComment($post, array $data) {
        if (!($post instanceof Post)) {
            $post = Post::findOrFail($post);
        }

        // Create comment
        $comment = $post->comments()->create([
            'content'   => $data['content'],
            'user_id'   => auth()->id(),
            'parent_id' => $data['parent_id'] ?? null,
        ]);

        // Get updated comments with relationships
        $comments = $post->comments()
            ->with(['user', 'replies.user', 'replies.replies.user'])
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return $comments;
    }

    public function fetchComments($post) {
        if (!($post instanceof Post)) {
            $post = Post::findOrFail($post);
        }

        return $post->comments()
            ->with(['user', 'replies.user', 'replies.replies.user'])
            ->whereNull('parent_id')
            ->latest()
            ->get();
    }

}
<?php

namespace App\Services;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostService
{
    protected $postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    // Get all posts
    public function getAllPosts()
    {
        return $this->postRepo->getPost();
    }

    // Create a new post
    public function createPost($user, array $data)
    {
        return $this->postRepo->createPost($user, $data);
    }

    // Update an existing post
    public function updatePost(Post $post, array $data)
    {
        return $this->postRepo->updatePost($post, $data);
    }

    // Delete a post
    public function deletePost(Post $post)
    {
        return $this->postRepo->deletePost($post);
    }

    // Add a comment
    public function addComment(Post $post, array $data)
    {
        return $this->postRepo->addComment($post, $data);
    }

    // Fetch comments
    public function fetchComments(Post $post)
    {
        return $this->postRepo->fetchComments($post);
    }
}
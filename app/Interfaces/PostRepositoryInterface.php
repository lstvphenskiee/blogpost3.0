<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function getPost();

    // public function findPost($id);

    public function createPost($user, array $post);

    public function updatePost($post, array $data);

    public function deletePost($id);

    public function addComment($id, array $data);

    public function fetchComments($id);
}
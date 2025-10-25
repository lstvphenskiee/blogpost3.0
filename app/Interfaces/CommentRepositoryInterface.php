<?php

namespace App\Interfaces;

interface CommentRepositoryInterface
{
    public function updateComment($comment, array $data);

    public function deleteComment($comment);
}

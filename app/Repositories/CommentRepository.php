<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function updateComment($comment, array $data) {
        if (!($comment instanceof Comment)) {
            $comment = Comment::findOrFail($comment);
        }

        $comment->update($data);

        return $comment;
    }

    public function deleteComment($comment) {
        if (!($comment instanceof Comment)) {
            $comment = Comment::findOrFail($comment);
        }

        return $comment->delete();
    }
}
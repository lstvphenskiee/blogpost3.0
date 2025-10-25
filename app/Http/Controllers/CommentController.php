<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Interfaces\CommentRepositoryInterface;
use App\http\Requests\CommentRequest;

class CommentController extends Controller
{
    private $comment;

    public function __construct(CommentRepositoryInterface $commentRepo) {
        return $this->comment = $commentRepo;
    }

    public function update(CommentRequest $request, Comment $comment) {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validated();

        $updated = $this->comment->updateComment($comment, $data);

        return response()->json([
            'success' => true,
            'content' => $updated->content,
        ]);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post = $comment->id;

        $comment = $this->comment->deleteComment($comment);

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully.',
            'comment_id' => $post,
        ]);
    }
}

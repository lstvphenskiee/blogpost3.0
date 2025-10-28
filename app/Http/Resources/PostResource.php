<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'user' => [
                'id' => $this->user->id ?? null,
                'name' => $this->user->name ?? 'Unknown',
            ],
            'comments' => $this->whenLoaded('comments', function () {
                return $this->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'content' => $comment->content,
                        'user' => [
                            'id' => $comment->user->id ?? null,
                            'name' => $comment->user->name ?? 'Unknown',
                        ],
                    ];
                });
            }),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
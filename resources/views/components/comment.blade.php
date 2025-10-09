@if(isset($comments) && $comments)
    @forelse($comments as $comment)
        <div class="mb-3 border-bottom pb-2 ms-{{ $comment->parent_id ? '4' : '0' }}" data-comment-id="{{ $comment->id }}">
            
            <p class="mb-1 fw-bold">{{ $comment->user->name }}</p>

            <div class="comment-content" data-comment-id="{{ $comment->id }}">
                <p class="mb-1 comment-text">{{ $comment->content }}</p>

                <x-form class="editCommentForm d-none" data-comment-id="{{ $comment->id }}">
                    <textarea name="content" class="form-control mb-2" rows="2">{{ $comment->content }}</textarea>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary saveCommentBtn">Save</button>
                        <button type="button" class="btn btn-sm btn-secondary cancelEditBtn">Cancel</button>
                    </div>
                </x-form>
            </div>

            <small class="text-muted d-block mb-2">
                {{ $comment->created_at->format('F j, Y \\a\\t h:i A') }}
            </small>

            {{-- Action Buttons --}}
            <div class="d-flex align-items-center gap-1 mb-2">
                <button class="btn btn-sm btn-link text-decoration-none replyToggle" data-comment-id="{{ $comment->id }}">
                    Reply
                </button>

                @if(Auth::id() === $comment->user_id)
                    <div class="btn-group btn-group-sm" role="group" aria-label="Comment actions">
                        <button class="btn btn-outline-secondary editCommentBtn"
                            data-comment-id="{{ $comment->id }}"
                            data-content="{{ $comment->content }}">
                            Edit
                        </button>

                        <button class="btn btn-outline-danger deleteCommentBtn"
                            data-comment-id="{{ $comment->id }}">
                            Delete
                        </button>
                    </div>
                @endif
            </div>

            {{-- Reply Form --}}
            <x-form class="replyForm mt-2 d-none"
                data-post-id="{{ $comment->post_id }}"
                data-parent-id="{{ $comment->id }}"
                action="{{ route('blog.comment', $comment->post_id) }}">
                <textarea name="content" class="form-control mb-2" rows="2" placeholder="Write a reply..."></textarea>
                <x-submit-btn class="btn btn-sm">Reply</x-submit-btn>
            </x-form>

            {{-- Recursive Replies --}}
            @if($comment->replies && $comment->replies->count())
                <div class="ms-4 mt-3">
                    @include('components.comment', ['comments' => $comment->replies])
                </div>
            @endif

        </div>
    @empty
        <p class="text-muted">No comments yet.</p>
    @endforelse

@elseif(isset($comment))
    {{-- Single comment --}}
    <div class="mb-3 border-bottom pb-2" data-comment-id="{{ $comment->id }}">
        <p class="mb-1 fw-bold">{{ $comment->user->name }}</p>

        <div class="comment-content" data-comment-id="{{ $comment->id }}">
            <p class="mb-1 comment-text">{{ $comment->content }}</p>

            <form class="editCommentForm d-none" data-comment-id="{{ $comment->id }}">
                <textarea name="content" class="form-control mb-2" rows="2">{{ $comment->content }}</textarea>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary saveCommentBtn">Save</button>
                    <button type="button" class="btn btn-sm btn-secondary cancelEditBtn">Cancel</button>
                </div>
            </form>
        </div>

        <small class="text-muted d-block mb-2">
            {{ $comment->created_at->format('F j, Y \\a\\t h:i A') }}
        </small>

        @if(Auth::id() === $comment->user_id)
            <div class="btn-group btn-group-sm" role="group">
                <button class="btn btn-outline-secondary editCommentBtn"
                    data-comment-id="{{ $comment->id }}"
                    data-content="{{ $comment->content }}">
                    Edit
                </button>
                <button class="btn btn-outline-danger deleteCommentBtn"
                    data-comment-id="{{ $comment->id }}">
                    Delete
                </button>
            </div>
        @endif
    </div>
@else
    <p class="text-muted">No comments yet.</p>
@endif
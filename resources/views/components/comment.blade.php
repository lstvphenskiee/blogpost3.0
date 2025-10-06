@if(isset($comments) && $comments)
    @forelse($comments as $comment)
        <div class="mb-3 border-bottom pb-2 ms-{{ $comment->parent_id ? '4' : '0' }}">
            <p class="mb-1 fw-bold">{{ $comment->user->name }}</p>
            <p class="mb-1">{{ $comment->content }}</p>
            <small class="text-muted">{{ $comment->created_at->format('F j, Y \\a\\t h:i A') }}</small>

            <button class="btn btn-sm btn-link text-decoration-none replyToggle" data-comment-id="{{ $comment->id }}">
                Reply
            </button>

            {{-- REPLY FORM --}}
            <x-form class="replyForm mt-2 d-none" data-post-id="{{ $comment->post_id }}" data-parent-id="{{ $comment->id }}" action="{{ route('blog.comment', $comment->post_id) }}">
                <textarea name="content" class="form-control mb-2" rows="2" placeholder="Write a reply..."></textarea>
                <x-submit-btn class="btn btn-sm">
                    Reply
                </x-submit-btn>
            </x-form>

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
        <div class="mb-3 border-bottom pb-2">
            <p class="mb-1 fw-bold">{{ $comment->user->name }}</p>
            <p class="mb-1">{{ $comment->content }}</p>
            <small class="text-muted">{{ $comment->created_at->format('F j, Y \\a\\t h:i A') }}</small>
        </div>

    @else
        <p class="text-muted">No comments yet.</p>

@endif
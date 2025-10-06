@if (isset($comments) && $comments)
    @forelse ($comments as $comment)
        <div class="mb-3 border-bottom pb-2">
            <p class="mb-1 fw-bold">{{ $comment->user->name }}</p>
            <p class="mb-1">{{ $comment->content }}</p>
            <small class="text-muted">{{ $comment->created_at->format('F j, Y \\a\\t h:i A') }}</small>
        </div>
    @empty
        <p class="text-muted">No comments yet.</p>
    @endforelse

@elseif (isset($comment))
    {{-- single comment --}}
    <div class="mb-3 border-bottom pb-2">
        <p class="mb-1 fw-bold">{{ $comment->user->name }}</p>
        <p class="mb-1">{{ $comment->content }}</p>
        <small class="text-muted">{{ $comment->created_at->format('F j, Y \\a\\t h:i A') }}</small>
    </div>

@else
    <p class="text-muted">No comments yet.</p>
@endif


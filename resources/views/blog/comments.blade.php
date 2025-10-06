@forelse($comments as $comment)
    @include('components.comment', ['comment' => $comment])
@empty
    <p>No comments yet.</p>
@endforelse

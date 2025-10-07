<div class="card mb-3" data-post-id="{{ $post->id }}">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4 class="mb-0">{{ $post->user->name }}</h4>
                <small class="text-muted">
                    {{ $post->created_at->format('F j, Y \\a\\t h:i A') }}
                </small>
            </div>

            @if(Auth::id() === $post->user_id)
                <div class="d-flex gap-1">
                    <button class="btn btn-sm btn-outline-secondary editPostBtn"
                        data-bs-toggle="modal"
                        data-bs-target="#editPostModal"
                        data-post-id="{{ $post->id }}"
                        data-content="{{ $post->content }}">
                        Edit
                    </button>

                    <button class="btn btn-sm btn-outline-danger deletePostBtn"
                        data-post-id="{{ $post->id }}">
                        Delete
                    </button>
                </div>
            @endif
        </div>

        <p class="card-text mt-3">{{ Str::limit($post->content, 150) }}</p>

        <x-button variant="none" class="toggleComments" data-post-id="{{ $post->id }}">
            View Comment
        </x-button>

        <div class="commentSection mt-3 d-none" data-post-id="{{ $post->id }}">
            <h4>Comments</h4>
            <div class="commentsContainer overflow-auto" style="max-height: 200px;"></div>

            <x-form class="commentForm" data-post-id="{{ $post->id }}" 
                action="{{ route('blog.comment', $post) }}" method="POST">
                <div class="mb-3">
                    <label for="commentText" class="form-label">Comment</label>
                    <textarea name="content" class="form-control" rows="3" placeholder="Write your comment..."></textarea>
                </div>
                <x-submit-btn>Comment</x-submit-btn>
            </x-form>
        </div>
    </div>
</div>
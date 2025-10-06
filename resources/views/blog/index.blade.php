<x-dashboard title="Dashboard">
    <h1>All Post</h1>
    @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h4>{{ $post->user->name }}</h4>
                <small class="text-muted">{{ $post->created_at->format('F j, Y \\a\\t h:i A') }}</small>
                <p class="card-text">{{ Str::limit($post->content, 150) }}</p>

                <x-button variant="none" class="toggleComments" data-post-id="{{ $post->id }}">
                    View Comments
                </x-button>

                <div class="commentSection mt-3 d-none" data-post-id="{{ $post->id }}">
                    <h4>Comments</h4>
                    <div class="commentsContainer overflow-auto" style="max-height: 200px;">
                        @include('components.comment', ['comments' => $post->comments])
                    </div>

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
    @endforeach
</x-dashboard>
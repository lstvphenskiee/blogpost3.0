<div id="create-post" tabindex="-1">
    <div class="mb-3">
        <div class="modal-header">
            <h5 class="modal-title">New Post</h5>
            <button type="button" class="btn-close" aria-label="Close" id="closeModal"></button>
        </div>
        <div class="modal-body">
            <x-form id="createPostForm" action="{{ route('blog.store') }}" method="POST">
                <div class="mb-3">
                    <textarea name="content" class="form-control" style="height: 200px" rows="3"
                        placeholder="What's on your mind?"></textarea>
                </div>
                <x-submit-btn>Post</x-submit-btn>
            </x-form>
        </div>
    </div>
</div>

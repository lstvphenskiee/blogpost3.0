{{-- Modal --}}
<div id="create-post"  tabindex="-1">
    <div class="mb-3">
        <div class="modal-header">
            <h5 class="modal-title">New Post</h5>
            <button type="button" class="btn-close" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <x-form method="POST" action="{{ route('blog.store') }}">
                <div class="form-floating mb-3">
                    <textarea name="content" id="body" class="form-control" style="height: 200px;" placeholder="Enter body"></textarea>
                </div>

                <x-button type="submit" variant="primary" class="mt-3" style="width: 20%">Post</x-button>
            </x-form>
        </div>
    </div>
</div>
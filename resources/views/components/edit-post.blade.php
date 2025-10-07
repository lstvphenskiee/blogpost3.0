<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <x-form id="editPostForm">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="editContent" class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="4"></textarea>
          </div>
          <x-submit-btn>
            Save Changes
          </x-submit-btn>
        </x-form>
      </div>
    </div>
  </div>
</div>

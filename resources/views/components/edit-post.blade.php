<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-3">
      
      <div class="modal-header bg-label-primary">
        <h5 class="modal-title text-primary fw-semibold" id="editPostModalLabel">
          <i class="bx bx-edit-alt me-2"></i> Edit Post
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="editPostForm" method="POST">
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="editPostContent" class="form-label fw-semibold">Content</label>
            <textarea 
              class="form-control" 
              id="editPostContent" 
              name="content" 
              rows="4" 
              placeholder="Update your post..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button 
            type="button" 
            class="btn btn-label-secondary" 
            data-bs-dismiss="modal">
            <i class="bx bx-x me-1"></i> Cancel
          </button>
          <button 
            type="submit" 
            class="btn btn-primary">
            <i class="bx bx-save me-1"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
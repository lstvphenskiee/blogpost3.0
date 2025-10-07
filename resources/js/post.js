import $ from 'jquery';
import * as bootstrap from 'bootstrap';

$(() => {
    // CREATING POST
    $(document).on('submit', '#createPostForm', function (e) {
        e.preventDefault();

        const $form = $(this);
        const url = $form.attr('action');
        const data = $form.serialize();
        const $submitBtn = $form.find('button[type="submit"], .submit-btn');

        $submitBtn.prop('disabled', true).text('Posting...');

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.trim() !== '') {
                    $('#postsContainer').prepend(response);
                }

                $form.trigger('reset');

                closeModal();
            },
            error: function (xhr) {
                console.error('Error creating post:', xhr.responseText);
                alert('Error creating post.');
            },
            complete: function () {
                $submitBtn.prop('disabled', false).text('Post');
            }
        });
    });

    function closeModal() {
        $('#modal-overlay').addClass('d-none');
        $('#modal').empty();
    }

    // UPDATE SECTION
    $(document).on('click', '.editPostBtn', function (e) {
        e.preventDefault();

        const postId = $(this).data('post-id');
        const content = $(this).data('content');

        $('#editPostModal textarea[name="content"]').val(content);
        $('#editPostModal form').attr('action', `/posts/${postId}`);

        const modal = $('#editPostModal');
        modal.show();
    });

    $(document).on('submit', '#editPostForm', function (e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');
        const data = form.serialize();
        const postId = url.split('/').pop().trim();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                const $updatedPost = $(response).filter('.card').first();
                const $oldPost = $(`.card[data-post-id="${postId}"]`);

                if ($oldPost.length && $updatedPost.length) {
                    $oldPost.replaceWith($updatedPost);

                    const newBtn = $(`.card[data-post-id="${postId}"] .editPostBtn`);
                    newBtn.attr('data-content', $updatedPost.find('.card-text').text().trim());
                } else {
                    console.warn(`Could not find post ${postId} in DOM or response`);
                }

                const modal = bootstrap.Modal.getInstance(document.getElementById('editPostModal'));
                if (modal) modal.hide();

                form.trigger('reset');
            },
            error: function (xhr) {
                console.error('Error updating post:', xhr.responseText);
                alert('Error updating post. Please try again.');
            }
        });
    });

    // DELETE SECTION
    $(document).on('click', '.deletePostBtn', function (e) {
        e.preventDefault();

        const postId = $(this).data('post-id');
        const confirmed = confirm('Are you sure you want to delete this post?');

        if (!confirmed) return;

        $.ajax({
            url: `/posts/${postId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $(`.card[data-post-id="${postId}"]`).fadeOut(300, function () {
                        $(this).remove();
                    });
                }
            },
            error: function (xhr) {
                console.error('Error deleting post:', xhr.responseText);
                alert('Error deleting post. Please try again.');
            }
        });

    });
});
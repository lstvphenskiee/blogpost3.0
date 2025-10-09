import $ from 'jquery';
import * as bootstrap from 'bootstrap';
import Swal from 'sweetalert2';

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

    Swal.fire({
        title: 'Are you sure?',
        text: "This post will be permanently deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/posts/${postId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        // Fade out post card
                        $(`.card[data-post-id="${postId}"]`).fadeOut(300, function () {
                            $(this).remove();
                        });

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Your post has been deleted.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to delete post.'
                        });
                    }
                },
                error: function (xhr) {
                    console.error('Error deleting post:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.'
                    });
                }
            });
        }
    });
});

});
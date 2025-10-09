import $ from 'jquery';
import Swal from 'sweetalert2';

$(() => {
    $(document).on('click', '.toggleComments', function (e) {
        e.preventDefault();

        const $button = $(this);
        const postId = $button.data('post-id');
        const $cardBody = $button.closest('.card-body');
        const $commentSection = $cardBody.find(`.commentSection[data-post-id="${postId}"]`);
        const $commentsContainer = $commentSection.find('.commentsContainer');

        if ($commentSection.hasClass('d-none')) {
            $.ajax({
                url: `/posts/${postId}/comments`,
                method: 'GET',
                success: function (response) {
                    console.log("response");
                    $commentsContainer.html(response);
                    $commentSection.removeClass('d-none');
                    $button.text('Hide Comment');
                },
                error: function (xhr) {
                    $commentsContainer.html(`<p class="text-danger">Error loading comments: ${xhr.status}</p>`);
                    $commentSection.removeClass('d-none');
                }
            });
        } else {
            $commentSection.addClass('d-none');
            $button.text('View Comment');
        }
    });

    // COMMENT FORM
    $(document).on('submit', '.commentForm', function (e) {
        e.preventDefault();

        const $form = $(this);
        const postId = $form.data('post-id');
        const $commentsContainer = $form.closest('.commentSection').find('.commentsContainer');
        const formData = $form.serialize();
        const $submitBtn = $form.find('button[type="submit"], .submit-btn');

        $submitBtn.prop('disabled', true).text('Posting...');

        $.ajax({
            url: `/posts/${postId}/comment`,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $commentsContainer.html(response);
                $form.find('textarea[name="content"]').val('');
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Error adding comment: ' + xhr.status);
            },
            complete: function () {
                $submitBtn.prop('disabled', false).text('Comment');
            }
        });
    });

    // REPLIES
    $(document).on('click', '.replyToggle', function (e) {
        e.preventDefault();

        const $commentContainer = $(this).closest('div.mb-3'); // main comment wrapper
        const $replyForm = $commentContainer.find('.replyForm').first();

        $replyForm.toggleClass('d-none');
    });


    $(document).on('submit', '.replyForm', function (e) {
        e.preventDefault();

        const $form = $(this);
        const postId = $form.data('post-id');
        const parentId = $form.data('parent-id');
        const $commentsContainer = $form.closest('.commentsContainer');
        const formData = $form.serialize() + `&parent_id=${parentId}`;

        $.ajax({
            url: `/posts/${postId}/comment`,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $commentsContainer.html(response);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Error submitting reply.');
            }
        });
    });

    $(document).on('click', '.editCommentBtn', function (e) {
        e.preventDefault();
        const $commentContainer = $(this).closest('div.mb-3');
        const $text = $commentContainer.find('.comment-text');
        const $form = $commentContainer.find('.editCommentForm');

        $text.addClass('d-none');
        $form.removeClass('d-none');
    });

    $(document).on('click', '.cancelEditBtn', function (e) {
        e.preventDefault();
        const $commentContainer = $(this).closest('div.mb-3');
        const $text = $commentContainer.find('.comment-text');
        const $form = $commentContainer.find('.editCommentForm');

        $form.addClass('d-none');
        $text.removeClass('d-none');
    });

    $(document).on('submit', '.editCommentForm', function (e) {
        e.preventDefault();
        const $form = $(this);
        const commentId = $form.data('comment-id');
        const newContent = $form.find('textarea[name="content"]').val();
        const $commentContainer = $form.closest('div.mb-3');
        const $text = $commentContainer.find('.comment-text');

        $.ajax({
            url: `/comments/${commentId}`,
            type: 'PUT',
            data: {
                content: newContent,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $text.text(response.content);
                $form.addClass('d-none');
                $text.removeClass('d-none');
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Error editing comment.');
            }
        });
    });

    $(document).on('click', '.deleteCommentBtn', function (e) {
        e.preventDefault();

        const $btn = $(this);
        const commentId = $btn.data('comment-id');
        const url = `/comments/${commentId}`;
        const $commentBlock = $btn.closest('div.mb-3');

        Swal.fire({
            title: 'Delete Comment?',
            text: 'This comment will be permanently removed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.close();
                        if (response.success) {
                            // Fade out and remove the comment
                            $commentBlock.fadeOut(300, function () {
                                $(this).remove();
                            });

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The comment has been removed.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Error deleting comment.'
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.close();
                        console.error('Error deleting comment:', xhr.responseText);

                        if (xhr.status === 403) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Unauthorized',
                                text: 'You are not authorized to delete this comment.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong. Please try again.'
                            });
                        }
                    }
                });
            }
        });
    });

});

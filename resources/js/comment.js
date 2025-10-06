import $ from 'jquery';

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
        const $form = $(this).siblings('.replyForm');
        $form.toggleClass('d-none');
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

});

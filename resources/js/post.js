import $ from 'jquery';

$(() => {
    // Submit create post form via AJAX
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
});
import $ from 'jquery';

$(() => {
    $(document).on('click', '#create-btn', function (e) {
        e.preventDefault();

        $('#modal').load('/create-post #create-post', function (response, status, xhr) {
            if (status === "error") {
                console.error("Error:", xhr.status, xhr.statusText);
            } else {
                $('#modal-overlay').removeClass('d-none');
            }
        });
    });

    $(document).on('click', '#modal-overlay', function (e) {
        if ($(e.target).is('#modal-overlay')) {
            $('#modal-overlay').addClass('d-none').find('#modal').empty();
        }
    });
});

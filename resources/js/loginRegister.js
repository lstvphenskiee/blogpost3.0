import $ from 'jquery';

$(() => {

    // REGISTER FORM
    $(document).on('click', '#show-register', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/registers',
            method: 'GET',
            success: function(response) {
                const html = $(response).find('#register-module');
                $('#form-container').html(html);
            },
            error: function(xhr) {
                $('#form-container').html(`<p class="text-danger">Error loading register form: ${xhr.status}</p>`);
            }
        });
    });

    // LOGIN FORM
    $(document).on('click', '#show-login', function (e) {
        e.preventDefault();

        $.ajax({
            url: '/',
            method: 'GET',
            success: function(response) {
                const html = $(response).find('#login-module');
                $('#form-container').html(html);
            },
            error: function(xhr) {
                $('#form-container').html(`<p class="text-danger">Error loading login form: ${xhr.status}</p>`);
            }
        });
    });

});

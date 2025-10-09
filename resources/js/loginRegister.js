import $ from 'jquery';
import Swal from 'sweetalert2';

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

$(() => {
    if (window.loginError) {
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: window.loginError,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Try Again'
        });
    }

    // Register success alert
    if (window.registerSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Registration Complete!',
            text: window.registerSuccess,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Login Now'
        });
    }

});

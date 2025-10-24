// import $ from 'jquery';

// $(() => {
//     $(document).on('click', '#create-btn', function (e) {
//         e.preventDefault();

//         $.ajax({
//             url: '/create-post',
//             method: 'GET',
//             success: function (response) {
//                 const html = $('<div>').html(response);
//                 const content = html.find('#create-post').html();
//                 $('#modal').html(content);
//                 $('#modal-overlay').removeClass('d-none');
//             },
//             error: function (xhr) {
//                 console.error("Error loading modal:", xhr.status, xhr.statusText);
//             }
//         });
//     });

//     $(document).on('click', '#closeModal', function (e) {
//         $('#modal-overlay').addClass('d-none').find('#modal').empty();
//     });

//     $(document).on('click', '#modal-overlay', function (e) {
//         if ($(e.target).is('#modal-overlay')) {
//             $('#modal-overlay').addClass('d-none').find('#modal').empty();
//         }
//     });
// });

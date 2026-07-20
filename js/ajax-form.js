jQuery(document).ready(function ($) {
    if (typeof ajax_object === 'undefined') {
        return;
    }
    $('#contactForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&action=handle_contact_form_submission';

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    alert('Message sent successfully!');
                    $('#contactForm')[0].reset();
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function () {
                alert('An error occurred. Please try again.');
            }
        });
    });
});
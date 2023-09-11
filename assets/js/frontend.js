jQuery(document).ready(function($) {
    $('#ads-frontend-form-submission').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        console.log(ads_frontend_form_submission);

        $.ajax({
            type: 'POST',
            url: ads_frontend_form_submission.ajax_url,
            data: {
                action: 'handle_frontend_form_submission',
                nonce: ads_frontend_form_submission.nonce,
                form_data: formData
            },
            success: function(response) {
                // Handle the server response here
                console.log(response);
            }
        });
    });
});

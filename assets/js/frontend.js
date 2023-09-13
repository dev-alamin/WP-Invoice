jQuery(document).ready(function($) {
    $('#ads-frontend-form-submission').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
            type: 'POST',
            url: ads_frontend_form_submission.ajax_url,
            data: {
                action: 'handle_frontend_form_submission',
                nonce: ads_frontend_form_submission.nonce,
                form_data: formData
            },
            dataType: 'json', // Expect JSON response
            success: function(response) {
                // Handle the server response here
                var errorContainer = $('#error-container');
                errorContainer.empty();
                if (!response.success) {
                    if (response.data) {
                        // Iterate through the error object and display each error
                        $.each(response.data, function(field, errorMessage) {
                            errorContainer.append('<p>' + errorMessage + '</p>');
                        });
                    } else {
                        errorContainer.html('<p>Unknown error occurred.</p>');
                    }
                } else {
                    // Handle successful form submission
                    $("#thankYou").text('Your invoice has been sent successfully!');

                    $('#amount').val('');
                    $('#buyer').val('');
                    $('#receipt_id').val('');
                    $('#items').val('');
                    $('#buyer_email').val('');
                    $('#note').val('');
                    $('#city').val('');
                    $('#phone').val('');
                }
            },
            error: function() {
                // Handle AJAX error
            }
        });
    });

    $('#phone').on('input', function() {
        var phoneNumber = $(this).val();
        
        // Remove all non-numeric characters
        phoneNumber = phoneNumber.replace(/[^0-9]/g, '');
        
        // Check if "880" is not already at the beginning of the phone number
        if (phoneNumber.length > 0 && !phoneNumber.startsWith('880')) {
            phoneNumber = '880' + phoneNumber;
        }
        
        // Update the input field value
        $(this).val(phoneNumber);
    });
});

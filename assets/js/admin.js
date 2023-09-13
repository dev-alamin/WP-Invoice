;(function($) {
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

})(jQuery);
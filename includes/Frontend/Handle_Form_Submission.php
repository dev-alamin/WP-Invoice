<?php 
namespace ADS\Frontend;
use ADS\Traits\Form_Error;
use ADS\Traits\Helper;

/**
 * Class Handle_Form_Submission
 *
 * Handles the submission of frontend forms and processes the submitted data.
 *
 * This class validates and processes form data and inserts it into the database table.
 *
 * @package ADS\Frontend
 */
class Handle_Form_Submission {
    use Form_Error;
    use Helper;
    /**
     * Handles the submission of frontend forms and processes the submitted data.
     *
     * This method validates the form data and inserts it into the database table.
     *
     * @since 1.0.0
     */
    
    public function handle_form() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ads_frontend_form_submission';
    
        parse_str($_POST['form_data'], $form_data);

        $buyer_ip = $this->get_user_ip();

        $salt = 'fb4cd15ba80ea647620f6a6907ab6e20';

        $hash_key = hash('sha512', $form_data['receipt_id'] . $salt);

        $entry_at = current_time('mysql', true);

        $entry_by = is_user_logged_in() ? get_current_user_id() : '0';

        // Prepare the data for insertion into the database using placeholders
        $data = [
            'amount' => sanitize_text_field($form_data['amount']),
            'buyer' => sanitize_text_field($form_data['buyer']),
            'receipt_id' => sanitize_text_field($form_data['receipt_id']),
            'items' => sanitize_text_field($form_data['items']),
            'buyer_email' => sanitize_email($form_data['buyer_email']),
            'buyer_ip' => $buyer_ip,
            'note' => sanitize_textarea_field($form_data['note']),
            'city' => sanitize_text_field($form_data['city']),
            'phone' => sanitize_text_field($form_data['phone']),
            'hash_key' => $hash_key,
            'entry_at' => $entry_at,
            'entry_by' => $entry_by,
        ];

        if (empty($data['amount'])) {
            $this->errors['amount'] = __('Amount is required.', 'frontend-form-submission');
        } elseif (!is_numeric($data['amount'])) {
            $this->errors['amount'] = __('Amount must be a number.', 'frontend-form-submission');
        }
        
        if (empty($data['buyer'])) {
            $this->errors['buyer'] = __('Buyer is required.', 'frontend-form-submission');
        } elseif (strlen($data['buyer']) > 20 || !preg_match('/^[A-Za-z0-9\s]+$/', $data['buyer'])) {
            $this->errors['buyer'] = __('Buyer must be alphanumeric and not exceed 20 characters.', 'frontend-form-submission');
        }
        
        if (empty($data['buyer_email'])) {
            $this->errors['buyer_email'] = __('Buyer Email is required.', 'frontend-form-submission');
        } elseif (!is_email($data['buyer_email'])) {
            $this->errors['buyer_email'] = __('Invalid email format for Buyer Email.', 'frontend-form-submission');
        }
        
        if (empty($data['note'])) {
            $this->errors['note'] = __('Note is required.', 'frontend-form-submission');
        } elseif (str_word_count($data['note']) > 30) {
            $this->errors['note'] = __('Note cannot exceed 30 words.', 'frontend-form-submission');
        }
        
        if (empty($data['city'])) {
            $this->errors['city'] = __('City is required.', 'frontend-form-submission');
        } elseif (!preg_match('/^[A-Za-z\s]+$/', $data['city'])) {
            $this->errors['city'] = __('City must contain only letters and spaces.', 'frontend-form-submission');
        }
        
        $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']); // Remove non-numeric characters
        if (empty($data['phone'])) {
            $this->errors['phone'] = __('Phone number is required.', 'frontend-form-submission');
        } elseif (strlen($data['phone']) < 10 || strlen( $data['phone'] ) > 20 ) {
            $this->errors['phone'] = __('Phone number must be in between 10 to 20.', 'frontend-form-submission');
        }
        

        if (!empty($this->errors)) {
            wp_send_json_error($this->errors);
            return;
        }

        // Define the format of the placeholders
        $format = [
            '%d', // amount (integer)
            '%s', // buyer (string)
            '%s', // receipt_id (string)
            '%s', // items (string)
            '%s', // buyer_email (email)
            '%s', // note (string)
            '%s', // city (string)
            '%s', // phone (string)
            '%s', // buyer_ip (string)
            '%s', // hash_key (string)
            '%s', // entry_at (string)
            '%d', // entry_by (string)
        ];

        // Insert the data into the database table
        $insert_result = false;

        if( empty( $this->errors) ) {
            $insert_result = $wpdb->insert($table_name, $data, $format);
            $insert_result = true;
        }

        if ($insert_result === false) {
            wp_send_json_error('Database error. Form data could not be saved.');
        } else {
            wp_send_json_success('Form submitted successfully!');
        }

        wp_die( 'We are done.' );
    }
}
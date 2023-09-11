<?php 
namespace ADS;
use ADS\Traits\Helper;

class Ajax{
    use Helper;
    public function __construct(){
        add_action('wp_ajax_handle_frontend_form_submission', [ $this, 'handle_form' ]);
        add_action('wp_ajax_nopriv_handle_frontend_form_submission', [ $this, 'handle_form' ]); 
    }

    public function handle_form() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ads_frontend_form_submission';
    
        parse_str($_POST['form_data'], $form_data);

        $amount = sanitize_text_field($form_data['amount']);
        if (!preg_match('/^\d+$/', $amount)) {
            wp_send_json_error('Amount must contain only numbers.');
        }

        // Backend validation for 'buyer' (only text, spaces, and numbers, not more than 20 characters)
        $buyer = sanitize_text_field($form_data['buyer']);
        if (!preg_match('/^[a-zA-Z0-9\s]{1,20}$/', $buyer)) {
            wp_send_json_error('Buyer must contain only text, spaces, and numbers, and be no more than 20 characters.');
        }

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
            'note' => sanitize_text_field($form_data['note']),
            'city' => sanitize_text_field($form_data['city']),
            'phone' => sanitize_text_field($form_data['phone']),
            'hash_key' => $hash_key,
            'entry_at' => $entry_at,
            'entry_by' => $entry_by,
        ];

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
        $insert_result = $wpdb->insert($table_name, $data, $format);

        if ($insert_result === false) {
            wp_send_json_error('Database error. Form data could not be saved.');
        } else {
            wp_send_json_success('Form submitted successfully!');
        }

        wp_die( 'We are done.' );
    }
}
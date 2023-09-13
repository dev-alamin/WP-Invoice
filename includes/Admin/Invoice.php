<?php 
namespace ADS\Admin;
use ADS\Traits\Helper;
use ADS\Traits\Form_Error;
/**
 * Represents an Invoice management class.
 *
 * This class handles the creation, editing, and deletion of invoices in the WordPress admin area.
 *
 * @package FrontendFormSubmission
 */
class Invoice{
    use Helper;
    use Form_Error;

    /**
     * Constructor method for the Invoice class.
     *
     * Initializes the class and registers the form_handler method to handle form submissions.
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'admin_init', [ $this, 'form_handler'] );
    }

    /**
     * Handles the rendering of plugin pages based on the 'action' parameter.
     *
     * @since 1.0.0
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ?  $_GET['action'] : 'list';
        $id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : '0';

        switch( $action ) {
            case 'new':
                $template = __DIR__ . '/views/invoice-new.php';
                break;

            case 'edit':
                $invoice = $this->get_invoice( $id ); // Used on the edit template

                $template = __DIR__ . '/views/invoice-edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/views/invoice-view.php';
                break;

            default:
                $template = __DIR__ . '/views/invoice-list.php';
                break;
        }

        if( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handles form submissions for creating or editing invoices.
     *
     * Validates form input, inserts or updates invoices in the database, and redirects accordingly.
     *
     * @since 1.0.0
     */
    public function form_handler() {
        if( ! isset( $_POST['add_invoice'] ) ) {
            return;
        }

        if( ! wp_verify_nonce( $_POST['_wpnonce'], 'invoice-nonce' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if( ! current_user_can( 'edit_others_posts' ) ) {
            wp_die( 'Sorry, you are not allowed' );
        }

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $amount = isset($_POST['amount']) ? intval($_POST['amount']) : 0;
        if (!is_numeric($amount)) {
            $this->errors['amount'] = __('Amount must be a number.', 'frontend-form-submission');
        }elseif( empty( $amount ) ) {
            $this->errors['amount'] = __( 'Please provide amount', 'frontend-form-submission' );
        }
        
        $buyer = isset($_POST['buyer']) ? sanitize_text_field($_POST['buyer']) : '';
        if (strlen($buyer) > 20 || !preg_match('/^[A-Za-z0-9\s]+$/', $buyer)) {
            $this->errors['buyer'] = __('Buyer must be alphanumeric and not exceed 20 characters.', 'frontend-form-submission');
        }elseif( empty( $buyer ) ) {
            $this->errors['buyer'] = __( 'Please provide buyer', 'frontend-form-submission' );
        }
        
        $receipt_id = isset($_POST['receipt_id']) ? sanitize_text_field($_POST['receipt_id']) : '';
        
        if( empty( $receipt_id ) ) {
            $this->errors['receipt_id'] = __( 'Please provide receipt ID', 'frontend-form-submission' );
        }

        $items = isset($_POST['items']) ? sanitize_text_field($_POST['items']) : '';

        if( empty( $items ) ) {
            $this->errors['items'] = __( 'Please provide items', 'frontend-form-submission' );
        }
        
        $buyer_email = isset($_POST['buyer_email']) ? sanitize_email($_POST['buyer_email']) : '';
        if (!is_email($buyer_email)) {
            $this->errors['buyer_email'] = __('Invalid email format for Buyer Email.', 'frontend-form-submission');
        }elseif( empty( $buyer_email ) ) {
            $this->errors['buyer_email'] = __( 'Please provide buyer email', 'frontend-form-submission' );
        }
        
        $note = isset($_POST['note']) ? sanitize_textarea_field($_POST['note']) : '';
        if (str_word_count($note) > 30) {
            $this->errors['note'] = __('Note cannot exceed 30 words.', 'frontend-form-submission');
        }elseif( empty( $note ) ) {
            $this->errors['note'] = __( 'Please provide note', 'frontend-form-submission' );
        }

        
        $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
        if (!preg_match('/^[A-Za-z\s]+$/', $city)) {
            $this->errors['city'] = __('City must contain only letters and spaces.', 'frontend-form-submission');
        }elseif( empty( $city ) ) {
            $this->errors['city'] = __( 'Please provide city', 'frontend-form-submission' );
        }
        
        $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $phone = preg_replace('/[^0-9]/', '', $phone); // Remove non-numeric characters
        if (strlen($phone) < 10 || strlen( $phone ) > 20) {
            $this->errors['phone'] = __('Phone number must be at least 10 digits and max 20 digits.', 'frontend-form-submission');
        }elseif( empty( $phone ) ) {
            $this->errors['phone'] = __( 'Please provide phone', 'frontend-form-submission' );
        }

        if( ! empty( $this->errors ) ) {
            return;
        }

        // Prepare data for insertion
        $args = array(
            'amount'      => $amount,
            'buyer'       => $buyer,
            'receipt_id'  => $receipt_id,
            'items'       => $items,
            'buyer_email' => $buyer_email,
            'note'        => $note,
            'city'        => $city,
            'phone'       => $phone
        );

        if( $id ) {
            $args['id'] = $id;
        }

        $inserted_id = $this->insert_invoice( $args );
        
        if( is_wp_error( $inserted_id ) ) {
            wp_die( $inserted_id->get_error_message() );
        }

        if( $id ) {
            $redirect_to = admin_url( 'admin.php?page=wp-invoice&action=edit&edited=true&id=' . $id );
        }else{
            $redirect_to = admin_url( 'admin.php?page=wp-invoice&inserted=true' );
        }

        wp_redirect( $redirect_to );
        exit;
    }

    /**
     * Deletes an invoice from the database.
     *
     * Handles the deletion of an invoice and redirects to appropriate pages based on success or failure.
     *
     * @since 1.0.0
     */
    public function delete_invoice() {
        global $wpdb;

        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wp-invoice-delete' ) ) {
            wp_die( 'Are you cheating?' ); // Protect SCRF
        }

        if ( ! current_user_can( 'edit_others_posts' ) ) {
            wp_die( 'Sorry you are not allowed!' );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

        $table = $wpdb->prefix . 'ads_frontend_form_submission';
        
        $deleted = $wpdb->delete( $table, ['id' => $id] );

        if ( $deleted ) {
            $redirected_to = admin_url( 'admin.php?page=wp-invoice&invoice-deleted=true' );
        } else {
            $redirected_to = admin_url( 'admin.php?page=wp-invoice&invoice-deleted=false' );
        }

        wp_redirect( $redirected_to );

        exit;
    }
}
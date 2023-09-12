<?php 
namespace ADS\Admin;
use ADS\Traits\Helper;
use ADS\Traits\Form_Error;
class Invoice{
    use Helper;
    use Form_Error;

    public function __construct() {
        add_action( 'admin_init', [ $this, 'form_handler'] );
    }

    public function plugin_page() {
        $action = isset( $_GET['action'] ) ?  $_GET['action'] : 'list';
        $id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : '0';

        switch( $action ) {
            case 'new':
                $template = __DIR__ . '/views/invoice-new.php';
                break;

            case 'edit':
                $invoice = $this->get_invoice( $id );

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

    public function form_handler() {
        if( ! isset( $_POST['add_invoice'] ) ) {
            return;
        }

        if( ! wp_verify_nonce( $_POST['_wpnonce'], 'invoice-nonce' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Sorry, you are not allowed' );
        }

        $id          = isset($_GET['id'] ) ? intval($_GET['id'] ) : '0';
        $amount      = isset( $_POST['amount'] ) ? sanitize_text_field( $_POST['amount'] ) : '';
        $buyer       = isset( $_POST['buyer'] ) ? sanitize_text_field( $_POST['buyer'] ) : '';
        $receipt_id  = isset( $_POST['receipt_id'] ) ? sanitize_text_field( $_POST['receipt_id'] ) : '';
        $items       = isset( $_POST['items'] ) ? sanitize_text_field( $_POST['items'] ) : '';
        $buyer_email = isset( $_POST['buyer_email'] ) ? sanitize_email( $_POST['buyer_email'] ) : '';
        $note        = isset( $_POST['note'] ) ? sanitize_textarea_field( $_POST['note'] ) : '';
        $city        = isset( $_POST['city'] ) ? sanitize_text_field( $_POST['city'] ) : '';
        $phone       = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
        $entry_by    = get_current_user_id();
        $entry_at    = current_time('mysql', true);
        
        // Check if mandatory fields are empty and set error messages
        if( empty( $amount ) ) {
            $this->errors['amount'] = __( 'Please provide amount', 'frontend-form-submission' );
        }
        
        if( empty( $buyer ) ) {
            $this->errors['buyer'] = __( 'Please provide buyer', 'frontend-form-submission' );
        }
        
        if( empty( $receipt_id ) ) {
            $this->errors['receipt_id'] = __( 'Please provide receipt ID', 'frontend-form-submission' );
        }
        
        if( empty( $items ) ) {
            $this->errors['items'] = __( 'Please provide items', 'frontend-form-submission' );
        }
        
        if( empty( $buyer_email ) ) {
            $this->errors['buyer_email'] = __( 'Please provide buyer email', 'frontend-form-submission' );
        }
        
        if( empty( $note ) ) {
            $this->errors['note'] = __( 'Please provide note', 'frontend-form-submission' );
        }
        
        if( empty( $city ) ) {
            $this->errors['city'] = __( 'Please provide city', 'frontend-form-submission' );
        }
        
        if( empty( $phone ) ) {
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
            'phone'       => $phone,
            'entry_at'    => $entry_at,
            'entry_by'    => $entry_by,
        );

        $inserted_id = $this->insert_invoice( $args );
        
        if( is_wp_error( $inserted_id ) ) {
            wp_die( $inserted_id->get_error_message() );
        }

        if( $id ) {
            $redirect_to = admin_url( 'admin.php?page=wp-invoice&action=invoice-updated=true&id=' . $id );
        }else{
            $redirect_to = admin_url( 'admin.php?page=wp-invoice&inserted=true' );
        }

        wp_redirect( $redirect_to );
        exit;
    }

    public function edit_invoice(){

    }

    public function delete_invoice() {
        
    }
}
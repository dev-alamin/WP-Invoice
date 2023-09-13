<?php
/**
 * Trait Helper
 *
 * A trait containing helper methods for various tasks.
 *
 * @package ADS\Traits
 */
namespace ADS\Traits;

trait Helper {
    /**
     * Get the user's IP address.
     *
     * @return string The user's IP address.
     */
    public function get_user_ip() {
        if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Fetch all data from the custom database table.
     *
     * @return array|false Array of records on success, false on failure.
     */
    public function get_invoices() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ads_frontend_form_submission';

        // Query to retrieve all records from the table
        $query = "SELECT * FROM $table_name";

        // Use $wpdb to perform the query
        $results = $wpdb->get_results($query, ARRAY_A);

        return $results;
    }

    /**
     * Get an individual invoice by ID.
     *
     * @param int $id The ID of the invoice to retrieve.
     *
     * @return object|false The invoice object on success, false on failure.
     */
    public function get_invoice( $id ) {
        global $wpdb;
    
        $address = $wpdb->get_row(
            $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ads_frontend_form_submission WHERE id = %d", $id )
        );

        return $address;
    }

    /**
     * Insert a new invoice into the database.
     *
     * @param array $data An associative array containing invoice data.
     *
     * @return int|false The ID of the inserted invoice on success, false on failure.
     */
    public function insert_invoice( $args = [] ) {
        global $wpdb;

        $default = array(
            'amount'      => '',
            'buyer'       => '',
            'receipt_id'  => '',
            'items'       => '',
            'buyer_email' => '',
            'note'        => '',
            'city'        => '',
            'phone'       => '',
            'entry_at'    => current_time( 'mysql', true ),
            'entry_by'    => get_current_user_id(),
        );

        $data = wp_parse_args( $args, $default );

        $table = $wpdb->prefix . 'ads_frontend_form_submission';
        
        $format = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');
        
        if( isset( $data['id'] ) ) {
            $id = $data['id'];
            unset( $data['id'] );

            $updated = $wpdb->update( $table, $data, [ 'id' => $id ], $format );

            if( $updated ) {
                return $updated;
            }else{
                return new \WP_Error( 'failed-to-update', __( 'Failed to update invoice', 'frontend-form-submission' ));
            }

        }else{
            $wpdb->insert($table, $data, $format);

            if ($wpdb->insert_id) {
                return $wpdb->insert_id;
            } else {
                return new \WP_Error( 'failed-to-insert', __( 'Failed to inster invoice', 'frontend-form-submission' ) );
            }
        }
    }

    public function delete_invoice( $invoice_id ) {
        global $wpdb;
        $table = $wpdb->prefix . 'ads_frontend_form_submission';
    
        return $wpdb->delete(
            $table,
            [ 'id' => $invoice_id ],
            [ '%d' ]
        );
    }
    
}

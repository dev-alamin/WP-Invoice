<?php 
namespace ADS\Traits;

trait Helper {
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

    public function get_invoice( $id ) {
        global $wpdb;
    
        $address = $wpdb->get_row(
            $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ads_frontend_form_submission WHERE id = %d", $id )
        );

        return $address;
    }

}
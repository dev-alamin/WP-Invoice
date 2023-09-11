<?php 
namespace ADS\Admin;

class Menu{
    private $invoice;

    public function __construct(){
        add_action( 'admin_menu', [ $this, 'invoice_menu' ] );
        $this->invoice = new \ADS\Admin\Invoice();

    }
    
    public function invoice_menu(){
        // Add a top-level menu page
        add_menu_page(
            __( 'WP Invoice', 'frontend-form-submission' ), // Page title
            __( 'WP Invoice', 'frontend-form-submission' ), // Menu title
            'manage_options', // Capability required to access the menu page
            'wp-invoice', // Menu slug (unique identifier)
            [ $this->invoice, 'plugin_page' ], // Callback function to display page content
            'dashicons-chart-area' // Icon URL or Dashicon class for the menu icon
        );
    } 
}
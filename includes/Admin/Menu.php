<?php 
namespace ADS\Admin;

/**
 * Class Menu
 *
 * Represents the menu management class for the WP Invoice plugin.
 *
 * This class is responsible for adding the WP Invoice menu item to the WordPress admin menu.
 *
 * @package FrontendFormSubmission
 */
class Menu{
    /**
     * Invoice instance.
     *
     * @var Invoice
     */
    private $invoice;

    /**
     * Constructor method for the Menu class.
     *
     * Initializes the class and registers the 'invoice_menu' action hook.
     * Also, initializes the Invoice instance.
     *
     * @since 1.0.0
     */
    public function __construct(){
        add_action( 'admin_menu', [ $this, 'invoice_menu' ] );
        $this->invoice = new \ADS\Admin\Invoice();

    }
    
    /**
     * Callback function to add the WP Invoice menu item to the WordPress admin menu.
     *
     * @since 1.0.0
     */
    public function invoice_menu(){
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
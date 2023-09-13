<?php 
namespace ADS;

use ADS\Admin\Invoice;

/**
 * The main class responsible for managing the plugin's admin functionality.
 *
 * This class initializes the admin menu and handles actions related to admin functionality.
 *
 * @since 1.0.0
 * @package FrontendFormSubmission
 */
class Admin {
    /**
     * An instance of the Invoice class.
     *
     * @var Invoice $invoice An instance of the Invoice class.
     */
    public $invoice;

    /**
     * Constructor for the Admin class.
     *
     * Initializes the Invoice instance and sets up admin-related actions.
     *
     * @since 1.0.0
     * @param Invoice $invoice An instance of the Invoice class.
     */
    public function __construct( Invoice $invoice ) {
        $this->invoice = $invoice;

        // Initialize the admin menu
        new \ADS\Admin\Menu();

        // Hook into the 'admin_post_wp-invoice-delete' action to handle invoice deletion
        add_action( 'admin_post_wp-invoice-delete', [ $this->invoice, 'delete_invoice' ] );
    }
}

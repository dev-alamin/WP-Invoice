<?php 
namespace ADS;

/**
 * The class responsible for managing plugin assets.
 *
 * This class enqueues and localizes styles and scripts for both the frontend and admin areas.
 *
 * @since 1.0.0
 * @package FrontendFormSubmission
 */
class Assets {
    /**
     * Constructor for the Assets class.
     *
     * Initializes actions for enqueueing styles and scripts.
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
    }

    /**
     * Enqueue frontend scripts and styles.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts() {
        // Enqueue frontend stylesheet
        wp_enqueue_style( 'ads-frontend-form-submission', ADS_FFS_PLUGIN_ASSET . 'css/frontend.css', null, time(), 'all' );

        // Check if the current post content contains the 'ads_frontend_form' shortcode
        if ( has_shortcode( get_post()->post_content, 'ads_frontend_form' ) ) {
            // Enqueue frontend JavaScript
            wp_enqueue_script( 'ads-frontend-form-submission', ADS_FFS_PLUGIN_ASSET . 'js/frontend.js', [ 'jquery' ], time(), true );

            // Localize the script to pass data to JavaScript
            wp_localize_script( 'ads-frontend-form-submission', 'ads_frontend_form_submission', array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'frontend-form-submission-nonce' ),
            ) );
        }

        if ( has_shortcode( get_post()->post_content, 'ads_display_invoices' ) ) {
            wp_enqueue_style('wp-invoice-datatables', '//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css', '1.11.6', 'all');
            wp_enqueue_script('wp-invoice-datatables', '//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', ['jquery'], '1.11.6', true);
        }
    }

    /**
     * Enqueue admin scripts and localize data.
     *
     * @since 1.0.0
     */
    public function admin_scripts() {
        // Enqueue admin JavaScript
        wp_enqueue_script( 'invoice-admin-script', ADS_FFS_PLUGIN_ASSET . 'js/admin.js', [ 'jquery' ], time(), true );

        // Localize data for admin scripts
        wp_localize_script( 'invoice-admin-script', 'InvoiceScripts', [
            'nonce'    => wp_create_nonce( 'ads-delete-invoice' ),
            'confirm'  => __( 'Are you sure to delete', 'frontend-form-submission' ),
            'error'    => __( 'Something went Wrong!', 'frontend-form-submission' ),
            'adminUrl' => admin_url( 'admin-ajax.php' ),
        ] );
    }
}

<?php 
namespace ADS;

class Assets{
    public function __construct(){
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts'] );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'ads-frontend-form-submission', ADS_FFS_PLUGIN_ASSET . 'css/frontend.css', null, time(), 'all');
       
        // Check if the current post content contains the 'ads_frontend_form' shortcode
        if (has_shortcode(get_post()->post_content, 'ads_frontend_form')) {
            wp_enqueue_script('ads-frontend-form-submission', ADS_FFS_PLUGIN_ASSET . 'js/frontend.js', ['jquery'], time(), true);
            
            // Localize the script to pass data
            wp_localize_script('ads-frontend-form-submission', 'ads_frontend_form_submission', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('frontend-form-submission-nonce')
            ));
        }
    }

    public function admin_scripts() {
        wp_enqueue_script( 'invoice-admin-script', ADS_FFS_PLUGIN_ASSET . 'js/admin.js', [ 'jquery' ], time(), true );

        wp_localize_script( 'invoice-admin-script', 'InvoiceScripts', [
            'nonce'    => wp_create_nonce( 'ads-delete-invoice' ),
            'confirm'  => __( 'Are you sure to delete', 'frontend-form-submission' ),
            'error'    => __( 'Something went Wrong!', 'frontend-form-submission' ),
            'adminUrl' => admin_url( 'admin-ajax.php' ),
        ]);
    }
}
<?php 
namespace ADS;

class Assets{
    public function __construct(){
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts'] );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'ads-frontend-form-submission', ADS_FFS_PLUGIN_ASSET . 'css/frontend.css', null, time(), 'all');

        wp_enqueue_script( 'ads-frontend-form-submission', ADS_FFS_PLUGIN_ASSET . 'js/frontend.js', [ 'jquery' ], time(), true );

        // Localize the script to pass data
        wp_localize_script('ads-frontend-form-submission', 'ads_frontend_form_submission', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('frontend-form-submission-nonce')
        ));
    }
}
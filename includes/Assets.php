<?php 
namespace ADS;

class Assets{
    public function __construct(){
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts'] );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'ads-frontend-form-submission', ADS_FFS_PLUGIN_ASSET . 'css/frontend.css', null, time(), 'all');
    }
}
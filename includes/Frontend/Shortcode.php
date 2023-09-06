<?php 
namespace ADS\Frontend;

class Shortcode{
    public function __construct() {
        add_shortcode( 'ads_frontend_form', [ $this, 'frontend_form' ] );
    }
    public function frontend_form() {
        ob_start();
        $form = __DIR__ . '/../../templates/html-form.php';

        if( file_exists( $form ) ) {
            include $form;
        }else{
            echo _e( 'Target file does not exists', 'frontend-form-submission');
        }

        ob_end_flush();
    }
}
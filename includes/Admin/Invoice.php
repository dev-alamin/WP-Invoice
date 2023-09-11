<?php 
namespace ADS\Admin;
use ADS\Traits\Helper;

class Invoice{
    use Helper;

    public function __construct() {
        add_action( 'admin_init', [ $this, 'form_handler'] );
    }

    public function plugin_page() {
        $action = isset( $_GET['action'] ) ?  $_GET['action'] : 'list';
        $id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : '0';

        switch( $action ) {
            case 'new':
                $template = __DIR__ . '/views/invoice-new.php';
                break;

            case 'edit':
                $invoice = $this->get_invoice( $id );

                $template = __DIR__ . '/views/invoice-edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/views/invoice-view.php';
                break;

            default:
                $template = __DIR__ . '/views/invoice-list.php';
                break;
        }

        if( file_exists( $template ) ) {
            include $template;
        }
    }

    public function form_handler(){

    }

    public function edit_invoice(){

    }

    public function delete_invoice() {
        
    }
}
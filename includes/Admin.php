<?php 
namespace ADS;
use ADS\Admin\Invoice;
class Admin{
    public $invoice;

    public function __construct(Invoice $invoice){
        $this->invoice = $invoice;
        new \ADS\Admin\Menu();

        add_action( 'admin_post_wp-invoice-delete', [ $this->invoice, 'delete_invoice'] );
    }
}
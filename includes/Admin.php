<?php 
namespace ADS;
use ADS\Admin\Invoice_List_Table;
class Admin{
    public function __construct(){
        new \ADS\Admin\Menu();
    }   
}
<?php 
namespace ADS;

class Frontend{
    public function __construct(){
        new \ADS\Frontend\Shortcode();
        new \ADS\Frontend\Handle_Form_Submission();
    }
}
<?php 
namespace ADS;

/**
 * The main class for handling frontend functionality.
 *
 * This class initializes frontend components, such as shortcodes and form submission handling.
 *
 * @since 1.0.0
 * @package FrontendFormSubmission
 */
class Frontend {
    /**
     * Constructor for the Frontend class.
     *
     * Initializes frontend components.
     *
     * @since 1.0.0
     */
    public function __construct() {
        // Initialize the Shortcode component
        new \ADS\Frontend\Shortcode();

        // Initialize the Form Submission Handling component
        new \ADS\Frontend\Handle_Form_Submission();
    }
}

<?php 
namespace ADS;
use ADS\Traits\Helper;
use ADS\Frontend\Handle_Form_Submission;

/**
 * Class Ajax
 *
 * Handles AJAX requests for frontend form submissions.
 *
 * This class sets up the necessary AJAX action hooks and delegates the handling of AJAX requests
 * to the Handle_Form_Submission class.
 *
 * @package FrontendFormSubmission
 */
class Ajax {
    use Helper;

    /**
     * Instance of Handle_Form_Submission class.
     *
     * @var Handle_Form_Submission
     */
    private $handleForm;

    /**
     * Constructor method for the Ajax class.
     *
     * Initializes the class and sets up AJAX action hooks for handling frontend form submissions.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->handleForm = new Handle_Form_Submission();

        // Set up AJAX action hooks for handling form submissions
        add_action('wp_ajax_handle_frontend_form_submission', [ $this->handleForm, 'handle_form' ]);
        add_action('wp_ajax_nopriv_handle_frontend_form_submission', [ $this->handleForm, 'handle_form' ]);
    }
}

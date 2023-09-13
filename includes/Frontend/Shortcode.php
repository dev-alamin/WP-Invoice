<?php 
namespace ADS\Frontend;
use ADS\Traits\Helper;
/**
 * Class Shortcode
 *
 * This class handles the registration and rendering of the 'ads_frontend_form' shortcode.
 *
 * @package ADS\Frontend
 */
class Shortcode {
    use Helper;
    /**
     * Shortcode constructor.
     *
     * Initializes the 'ads_frontend_form' shortcode.
     */
    public function __construct() {
        add_shortcode( 'ads_frontend_form', [ $this, 'frontend_form' ] );
        add_shortcode('ads_display_invoices', [ $this, 'display_invoices_shortcode' ]);
    }

    /**
     * Render the frontend form content.
     *
     * This method is called when the 'ads_frontend_form' shortcode is used, and it renders the frontend form.
     *
     * @return string The HTML content of the frontend form.
     */
    public function frontend_form() {
        ob_start();
        $form = __DIR__ . '/../../templates/html-form.php';

        if ( file_exists( $form ) ) {
            include $form;
        } else {
            echo _e( 'Target file does not exist', 'frontend-form-submission' );
        }

        ob_end_flush();
    }

    public function display_invoices_shortcode() {
        // Check if the user has the "editor" role
        if (current_user_can('edit_others_posts')) {
            // Retrieve invoices from the database and format them
            $invoices = $this->get_invoices(); // Implement the get_invoices() method
            
            // Generate the HTML for displaying invoices with DataTables
            $output  = '<div class="invoice-list">';
            $output .= '<h2>';
            $output .= __( 'See invoice insights', 'frontend-form-submission' );
            $output .= '</h2>';
            $output .= '<table id="invoice-table" class="display" cellspacing="0" width="100%">';
            $output .= '<thead>';
            $output .= '<tr>';
            $output .= '<th>Invoice ID</th>';
            $output .= '<th>Amount</th>';
            $output .= '<th>Buyer</th>';
            $output .= '<th>Receipt ID</th>';
            $output .= '<th>Items</th>';
            $output .= '<th>Buyer Email</th>';
            $output .= '<th>City</th>';
            $output .= '<th>Phone</th>';
            $output .= '<th>Entry Date</th>'; // Added Entry Date column
            // Add more fields as needed
            $output .= '</tr>';
            $output .= '</thead>';
            $output .= '<tbody>';

            foreach ($invoices as $invoice) {
                $output .= '<tr>';
                $output .= '<td>' . $invoice['id'] . '</td>';
                $output .= '<td>' . $invoice['amount'] . '</td>';
                $output .= '<td>' . $invoice['buyer'] . '</td>';
                $output .= '<td>' . $invoice['receipt_id'] . '</td>';
                $output .= '<td>' . $invoice['items'] . '</td>';
                $output .= '<td>' . $invoice['buyer_email'] . '</td>';
                $output .= '<td>' . $invoice['city'] . '</td>';
                $output .= '<td>' . $invoice['phone'] . '</td>';
                $output .= '<td>' . $invoice['entry_at'] . '</td>'; // Display Entry Date
                // Add more fields as needed
                $output .= '</tr>';
            }

            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '</div>';

            $output .= '<script>
                jQuery(document).ready(function($) {
                    $("#invoice-table").DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        info: true,
                        columnDefs: [
                            { "orderable": true, "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8] } // Make all columns sortable
                        ]
                    });
                });
            </script>';

            return $output;
        }
    }
}

<?php 
namespace ADS\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
class Invoice_List_Table extends \WP_List_Table {

    public function __construct() {
        parent::__construct( [
            'singular' => 'invoice',
            'plural'   => 'invoices',
            'ajax'     => false,
        ] );
    }

    private function filter_data($data, $filter_buyer, $filter_receipt_id) {
        $filtered_data = [];
    
        foreach ($data as $item) {
            if (
                (empty($filter_buyer) || $this->mb_stripos($item['buyer'], $filter_buyer) !== false) &&
                (empty($filter_receipt_id) || $this->mb_stripos($item['receipt_id'], $filter_receipt_id) !== false)
            ) {
                $filtered_data[] = $item;
            }
        }
    
        return $filtered_data;
    }


    // Helper function for case-insensitive multi-byte string position
    private function mb_stripos($haystack, $needle, $offset = 0) {
        return mb_stripos($haystack, $needle, $offset, 'UTF-8');
    }



    public function prepare_items() {
        // Define your data source and columns here
        $data = $this->get_invoice(); // Implement this method to fetch data
    
        $per_page = 20; // Adjust this to your desired items per page
        
        // Filter criteria from user input
        $filter_buyer = isset( $_POST['filter_by_date'] ) ? sanitize_text_field( $_POST['filter_by_date'] ) : '';
        $filter_receipt_id = isset( $_POST['filter_by_user_id'] ) ? sanitize_text_field( $_POST['filter_by_user_id'] ) : '';

        // Apply filters
        // $filtered_data = $this->filter_data( $data, $filter_buyer, $filter_receipt_id );

    
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
    
        $this->_column_headers = [ $columns, $hidden, $sortable ];

        // Calculate the total number of items
        $total_items = count( $data );

        // Set pagination parameters
        $this->set_pagination_args( [
            'total_items' => $total_items,
            'per_page'    => $per_page,
        ] );

        // Calculate the offset
        $current_page = $this->get_pagenum();
        $offset = ( $current_page - 1 ) * $per_page;

        // Slice the data to display only the items for the current page
        $this->items = array_slice( $data, $offset, $per_page );

        // Display your table as before
        $this->items = $this->data_sort( $this->items );

        // Display filtered data
        // $this->items = $filtered_data;
    }
    

    private function process_sorting( $sortable_columns ) {
        // Check if we have sortable columns
        if ( empty( $sortable_columns ) ) {
            return;
        }

        // Get the current sorting parameters
        $orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : '';
        $order = isset( $_GET['order'] ) ? sanitize_text_field( $_GET['order'] ) : 'asc';

        // Validate the sorting parameters
        if ( ! array_key_exists( $orderby, $sortable_columns ) ) {
            return;
        }

        // Apply sorting
        usort( $this->items, [ $this, 'sort_data' ] );

        // Handle sorting order
        if ( $order === 'desc' ) {
            $this->items = array_reverse( $this->items );
        }
    }

    protected function extra_tablenav($which) {
        if ($which == 'top') {
            global $wpdb;

            // Fetch unique dates from your database
            $date_query = $wpdb->get_results("SELECT DISTINCT entry_at FROM {$wpdb->prefix}ads_frontend_form_submission", ARRAY_A);

            // Fetch user IDs from WordPress users
            $users = get_users();

            // Add your custom filter dropdowns and form here
            echo '<div class="alignleft actions">';

            // Start the form
            echo '<form method="post" action="admin.php?page=wp-invoice">';

            echo '<select name="filter_by_date">';
            echo '<option value="">Filter by Date</option>';

            foreach ($date_query as $date_option) {
                $value = esc_attr($date_option['entry_at']);
                $label = esc_html(date('F j, Y', strtotime($date_option['entry_at'])));
                echo '<option value="' . $value . '">' . $label . '</option>';
            }

            echo '</select>';

            echo '<select name="filter_by_user_id">';
            echo '<option value="">Filter by User ID</option>';

            foreach ($users as $user) {
                $value = esc_attr($user->ID);
                $label = esc_html($user->display_name);
                echo '<option value="' . $value . '">' . $label . '</option>';
            }

            echo '</select>';

            echo '<input type="submit" name="filter_action" class="button" value="Filter">';

            // Close the form
            echo '</form>';

            echo '</div>';
        }
    }

    public function get_bulk_actions() {
        $actions = [
            'edit'   => 'Edit',
            'delete' => 'Delete',
        ];
        return $actions;
    }
    
    
    private function data_sort( $data ) {
        $orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : '';
        $order = isset( $_GET['order'] ) ? sanitize_text_field( $_GET['order'] ) : 'asc';
    
        if ( $orderby === 'amount' ) {
            usort( $data, function( $a, $b ) use ( $order ) {
                return ( $order === 'asc' ) ? ( $a['amount'] - $b['amount'] ) : ( $b['amount'] - $a['amount'] );
            } );
        } elseif ( $orderby === 'buyer' ) {
            usort( $data, function( $a, $b ) use ( $order ) {
                return ( $order === 'asc' ) ? strcasecmp( $a['buyer'], $b['buyer'] ) : strcasecmp( $b['buyer'], $a['buyer'] );
            } );
        }elseif( $orderby == 'receipt_id' ) {
            usort( $data, function( $a, $b ) use ( $order ) {
                return ( $order === 'asc' ) ? strcasecmp( $a['receipt_id'], $b['receipt_id'] ) : strcasecmp( $b['receipt_id'], $a['receipt_id'] );
            } );
        }elseif( $orderby == 'items' ) {
            usort( $data, function( $a, $b ) use ( $order ) {
                return ( $order === 'asc' ) ? strcasecmp( $a['items'], $b['items'] ) : strcasecmp( $b['items'], $a['items'] );
            } );
        }elseif( $orderby == 'entry_at' ) {
            usort( $data, function( $a, $b ) use ( $order ) {
                return ( $order === 'asc' ) ? strcasecmp( $a['entry_at'], $b['entry_at'] ) : strcasecmp( $b['entry_at'], $a['entry_at'] );
            } );
        }
    
        return $data;
    }
    
    
    

    public function get_columns() {
        // Define your table columns here
        return [
            'cb' => '<input type="checkbox" />',
            'buyer' => 'Buyer',
            'items' => 'Items',
            'amount' => 'Amount',
            'receipt_id' => 'Receipt ID',
            'buyer_email' => 'Buyer Email',
            'note' => 'Note',
            'city' => 'City',
            'phone' => 'Phone',
            'buyer_ip' => 'Buyer IP',
            'hash_key' => 'Hash Key',
            'entry_at' => 'Entry Date',
            'entry_by' => 'Entry By',
        ];
    }

    public function get_hidden_columns() {
        return [
            'buyer_ip',
            'hash_key',
            'entry_by',
        ];
    }

    public function get_sortable_columns() {
        return [
            'amount' => ['amount', false],
            'buyer' => ['buyer', true],
            'receipt_id' => ['receipt_id', true],
            'items' => ['items', true],
            'entry_at' => ['entry_at', true],
        ];
    }

    public function get_pagenum() {
        return isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
    }

    protected function column_cb($item) {
        // Assuming your table has a unique ID field named 'id'
        $id = $item['id'];
    
        return sprintf(
            '<input type="checkbox" name="item_id[]" value="%d" />',
            $id
        );
    }
    

    public function column_buyer($item) {
        $actions = [];
    
        // Edit action
        $edit_url = admin_url('admin.php?page=wp-invoice&action=edit&id=' . $item['id']);
        $actions['edit'] = sprintf(
            '<a href="%s" title="%s">%s</a>',
            esc_url($edit_url),
            esc_attr($item['id']),
            __('Edit', 'wp-invoice')
        );
    
        // Delete action
        $delete_nonce = wp_nonce_url( admin_url( 'admin-post.php?action=wp-invoice-delete&id=' . $item['id'] ), 'wp-invoice-delete' );
        $actions['delete'] = sprintf(
             '<a href="%s" onclick="return confirm(\'Are you sure to delete?\')" class="submitdelete" data-id="%s">%s</a>',
            $delete_nonce, 
            $item['id'], 
            __( 'Delete', 'frontend-form-submission' ) );

    
        // Add more custom actions as needed
    
        // Combine the actions into a string
        $row_actions = $this->row_actions($actions);
    
        // Return the formatted column content
        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a> %3$s',
            esc_url(admin_url('admin.php?page=wp-invoice&action=edit&id=' . $item['id'])),
            esc_html($item['buyer']),
            $row_actions
        );
    }

    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'entry_at':
                return date( 'Y-m-d', strtotime( $item[ $column_name ] ) );

            case 'buyer':
                return '<a href="' . admin_url( 'user-edit.php?user_id=' . $item[ 'entry_by' ] ) . '">' . esc_html( $item[ $column_name ] ) . '</a>';

            default:
                return $item[ $column_name ];
        }
    }

    // Implement the get_invoice method to fetch data from your custom table
    public function get_invoice() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ads_frontend_form_submission';

        // Replace this with your custom query to fetch data
        $query = "SELECT * FROM $table_name";

        // Use $wpdb to perform the query
        $results = $wpdb->get_results( $query, ARRAY_A );

        return $results;
    }
}

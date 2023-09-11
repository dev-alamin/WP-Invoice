<?php 
namespace ADS\Admin;

class Database{
    public function create_database() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ads_frontend_form_submission';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            amount INT(10) NOT NULL,
            buyer VARCHAR(255) NOT NULL,
            receipt_id VARCHAR(20) NOT NULL,
            items VARCHAR(255) NOT NULL,
            buyer_email VARCHAR(50) NOT NULL,
            buyer_ip VARCHAR(20),
            note TEXT NOT NULL,
            city VARCHAR(20) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            hash_key VARCHAR(255),
            entry_at DATE,
            entry_by INT(10) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}
<?php
function uah_create_database_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_access_history';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        ip_address varchar(100) NOT NULL,
        user_agent text NOT NULL,
        access_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    if ($wpdb->last_error) {
        error_log('Database error: ' . $wpdb->last_error);
    }
}

function uah_log_user_access() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_access_history';

    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $wpdb->insert(
        $table_name,
        [
            'ip_address' => sanitize_text_field( $ip_address ),
            'user_agent' => sanitize_text_field( $user_agent )
        ]
    );

    if ($wpdb->last_error) {
        error_log('Database error: ' . $wpdb->last_error);
    }
}

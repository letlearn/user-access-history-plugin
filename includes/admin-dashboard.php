<?php
function uah_add_admin_menu() {
    add_menu_page(
        'User Access History',
        'Access History',
        'manage_options',
        'uah_access_history',
        'uah_display_access_history',
        'dashicons-visibility',
        6
    );
}
add_action( 'admin_menu', 'uah_add_admin_menu' );

function uah_display_access_history() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_access_history';
    $results = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY access_time DESC" );

    if ($wpdb->last_error) {
        echo '<div class="error"><p>Database error: ' . $wpdb->last_error . '</p></div>';
        error_log('Database error: ' . $wpdb->last_error);
        return;
    }

    // Enqueue DataTables scripts and styles
    wp_enqueue_script('jquery');
    wp_enqueue_script('datatables', 'https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js', array('jquery'), null, true);
    wp_enqueue_style('datatables-css', 'https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css');

    echo '<div class="wrap"><h1>User Access History</h1>';
    echo '<table id="uah_access_history_table" class="display">
          <thead><tr><th>ID</th><th>IP Address</th><th>User Agent</th><th>Access Time</th></tr></thead><tbody>';

    foreach ( $results as $row ) {
        echo '<tr>';
        echo '<td>' . $row->id . '</td>';
        echo '<td>' . $row->ip_address . '</td>';
        echo '<td>' . $row->user_agent . '</td>';
        echo '<td>' . $row->access_time . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';

    echo '<script>
    jQuery(document).ready(function($) {
        $("#uah_access_history_table").DataTable();
    });
    </script>';
}

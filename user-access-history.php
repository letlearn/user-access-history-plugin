<?php
/*
Plugin Name: User Access History
Description: A plugin to save the history of users who access the website.
Version: 1.0
Author: Let Learn
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include necessary files
include_once plugin_dir_path( __FILE__ ) . 'includes/database.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/admin-dashboard.php';

// Create database table on plugin activation
register_activation_hook( __FILE__, 'uah_create_database_table' );

// Hook to log user access
add_action( 'wp', 'uah_log_user_access' );

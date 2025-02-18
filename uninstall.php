<?php
// Exit if accessed directly
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;
$table_name = $wpdb->prefix . 'pricing_tables';

// Drop the custom table
$wpdb->query("DROP TABLE IF EXISTS $table_name");
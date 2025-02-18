<?php
/*
Plugin Name: Custom Pricing Tables
Description: A simple plugin to display pricing tables using shortcodes with admin interface
Version: 1.0
Author: Ashraful
*/

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'shortcodes/pricing-table-shortcode.php';

// Register activation hook
register_activation_hook(__FILE__, 'create_pricing_table');
register_activation_hook(__FILE__, 'create_pricing_styles');

// Register uninstall hook
register_uninstall_hook(__FILE__, 'custom_pricing_tables_uninstall');

// Enqueue styles for the front-end
function pricing_tables_styles()
{
    wp_enqueue_style('pricing-tables', plugins_url('css/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'pricing_tables_styles');

// Enqueue styles for the admin page
function pricing_tables_admin_styles($hook)
{
    // Load only on the plugin admin page
    if ($hook != 'toplevel_page_pricing-tables') {
        return;
    }
    wp_enqueue_style('pricing-tables-admin', plugins_url('css/style.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'pricing_tables_admin_styles');
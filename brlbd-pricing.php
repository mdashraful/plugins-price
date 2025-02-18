<?php
/**
 * Plugin Name: BRLBD Pricing Table
 * Plugin URI: https://wordpress.org/plugins/brlbd-pricing/
 * Description: A simple pricing table plugin with multiple currency support.setup pricing table with multiple plans and features.using shortcode [brlbd_pricing_tables]
 * Version: 1.0
 * Author: Md Jahrul Islam
 * Author URI: https://brlbd.com/
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('BRLBD_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('BRLBD_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once BRLBD_PLUGIN_PATH . 'includes/functions.php';
require_once BRLBD_PLUGIN_PATH . 'includes/admin-page.php';
require_once BRLBD_PLUGIN_PATH . 'includes/shortcode.php';

// Register assets (CSS & JS)
function brlbd_enqueue_assets($hook)

{
    if ($hook === 'toplevel_page_brlbd_pricing_settings') {
        wp_enqueue_style('brlbd-styles', BRLBD_PLUGIN_URL . 'assets/styles.css', [], '1.0');
        wp_enqueue_script('brlbd-admin-js', BRLBD_PLUGIN_URL . 'assets/admin.js', ['jquery'], '1.0', true);
    }
    
}
add_action('admin_enqueue_scripts', 'brlbd_enqueue_assets');

<?php
/**
 * Plugin Name: Pricing
 * Description: Adds a pricing list
 * Version: 1.1
 * Author: brlbd
 * License: GPL-2.0+
 * Text Domain: package-price
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 **/

if(!defined('ABSPATH')){
	exit;
}


require_once(plugin_dir_path(__FILE__) . '/includes/pricing-admin.php');

function pricing_activation() {
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'pricing_activation');

function pricing_deactivation() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'pricing_deactivation');

function enqueue_pricing_styles() {
    wp_enqueue_style(
        'pricing-css',
        plugin_dir_url(__FILE__) . 'css/pricing.css',
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'css/pricing.css') // Version based on file modification time
    );
}
add_action('admin_enqueue_scripts', 'enqueue_pricing_styles');


function enqueue_color_picker_scripts($hook) {
    if ($hook == 'toplevel_page_pricing_settings') {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }
}
add_action('admin_enqueue_scripts', 'enqueue_color_picker_scripts');
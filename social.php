<?php
/**
* Plugin Name: Social Sites
* Description: Ads a Facebook profile link to the end of posts
* Version: 9.1
* Author: brlbd
*
**/

if(!defined('ABSPATH')){
	exit;
}

require_once(plugin_dir_path(__FILE__).'/includes/social-scripts.php');
require_once(plugin_dir_path(__FILE__).'/includes/social-content.php');
require_once(plugin_dir_path(__FILE__) . '/admin/social-admin.php');
require_once(plugin_dir_path(__FILE__) . '/admin/social-pricing-admin.php');
require_once(plugin_dir_path(__FILE__) . '/includes/custom-post.php');


// Flush rewrite rules on activation
function social_plugin_activation() {
    social_custom_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'social_plugin_activation');

// Flush rewrite rules on deactivation
function social_plugin_deactivation() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'social_plugin_deactivation');

function enqueue_social_pricing_styles() {
    wp_enqueue_style('social-pricing-css', plugin_dir_url(__FILE__) . 'css/pricing.css');
}
add_action('admin_enqueue_scripts', 'enqueue_social_pricing_styles');


function enqueue_color_picker_scripts($hook) {
    // Load only on the specific admin page
    if ($hook == 'toplevel_page_social_pricing_settings') { // Replace with your page hook
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }
}
add_action('admin_enqueue_scripts', 'enqueue_color_picker_scripts');
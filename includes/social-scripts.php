<?php
function social_add_scripts() {
    wp_enqueue_script('social-main-script', plugins_url('/js/main.js', __FILE__));
    wp_enqueue_style('social-main-style', plugins_url('/css/style.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'social_add_scripts');
?>

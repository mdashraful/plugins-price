<?php
if (!defined('ABSPATH')) {
    exit;
}

// Register Custom Post Type
function social_custom_post_type() {
    $labels = array(
        'name'                  => _x('Social Posts', 'Post Type General Name', 'textdomain'),
        'singular_name'         => _x('Social Post', 'Post Type Singular Name', 'textdomain'),
        'menu_name'             => __('Social Posts', 'textdomain'),
        'name_admin_bar'        => __('Social Post', 'textdomain'),
        'archives'              => __('Item Archives', 'textdomain'),
        'attributes'            => __('Item Attributes', 'textdomain'),
        'parent_item_colon'     => __('Parent Item:', 'textdomain'),
        'all_items'             => __('All Social Posts', 'textdomain'),
        'add_new_item'          => __('Add New Social Post', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'new_item'              => __('New Social Post', 'textdomain'),
        'edit_item'             => __('Edit Social Post', 'textdomain'),
        'update_item'           => __('Update Social Post', 'textdomain'),
        'view_item'             => __('View Social Post', 'textdomain'),
        'search_items'          => __('Search Social Post', 'textdomain'),
        'not_found'             => __('Not found', 'textdomain'),
        'not_found_in_trash'    => __('Not found in Trash', 'textdomain'),
    );

    $args = array(
        'label'                 => __('Social Post', 'textdomain'),
        'description'           => __('Custom post type for Social Posts', 'textdomain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'revisions'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array('slug' => 'social-posts'),
    );

    register_post_type('social_post', $args);

    // Debugging: Check if the post type is registered
    if (post_type_exists('social_post')) {
        error_log('Custom post type "social_post" registered successfully.');
    } else {
        error_log('Failed to register custom post type "social_post".');
    }

    // Debugging: Check rewrite rules
    global $wp_rewrite;
    error_log(print_r($wp_rewrite->rules, true));
}

add_action('init', 'social_custom_post_type');

function create_social_category_taxonomy() {
    $labels = array(
        'name'              => _x('Social Categories', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Social Category', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Search Social Categories', 'textdomain'),
        'all_items'         => __('All Social Categories', 'textdomain'),
        'parent_item'       => __('Parent Social Category', 'textdomain'),
        'parent_item_colon' => __('Parent Social Category:', 'textdomain'),
        'edit_item'         => __('Edit Social Category', 'textdomain'),
        'update_item'       => __('Update Social Category', 'textdomain'),
        'add_new_item'      => __('Add New Social Category', 'textdomain'),
        'new_item_name'     => __('New Social Category Name', 'textdomain'),
        'menu_name'         => __('Social Categories', 'textdomain'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'social-category'),
    );

    register_taxonomy('social_category', array('social_post'), $args);
}
add_action('init', 'create_social_category_taxonomy');
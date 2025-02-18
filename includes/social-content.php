<?php
function demo_add_footer($content) {
    // Ensure we are checking for a custom post type
    if (get_post_type() !== 'social_post') {
        return $content;
    }

    $social_links = get_option('social_links_data', []);
    $footer_output = '<hr>';
    $footer_output .= '<div class="footer_content">';

    // Loop through the social links and append them
    foreach ($social_links as $link) {
        $footer_output .= sprintf(
            '<a target="_blank" href="%s" style="display: inline-flex; align-items: center; margin-right: 8px;">
                %s
                <span style="margin-left: 6px;">%s</span>
            </a>',
            esc_url($link['url']),
            !empty($link['icon']) ? '<img src="' . esc_url($link['icon']) . '" alt="Social Icon" style="width: 20px; margin-right: 4px;">' : '',
            esc_html($link['title'])
        );
    }

    $footer_output .= '</div>';

    // Return content with the social footer added
    return '<div class="social-content">' . $content . $footer_output . '</div>';
}

add_filter('the_content', 'demo_add_footer');
?>

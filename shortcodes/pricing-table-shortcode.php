<?php
// Modified shortcode function to work with database
function pricing_table_shortcode($atts)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pricing_tables';

    // Get attributes
    $atts = shortcode_atts(array(
        'id' => 0
    ), $atts);

    // Get pricing table from database
    $pricing = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE id = %d",
        intval($atts['id'])
    ));

    if (!$pricing) {
        return 'Pricing table not found.';
    }

    // Convert features string to array (assuming features are stored with newlines)
    $features_list = explode("\n", $pricing->features);

    // Build features HTML
    $features_html = '';
    foreach ($features_list as $feature) {
        if (trim($feature) !== '') {
            $features_html .= '<li><i class="checkmark">✓</i>' . esc_html(trim($feature)) . '</li>';
        }
    }

    // Build the pricing table HTML
    $html = '
    <div class="pricing-table">
        <div class="pricing-header">
            <h3 class="plan-name">' . esc_html($pricing->plan_name) . '</h3>
            <div class="price">
                <span class="currency">' . esc_html($pricing->currency) . '</span>
                <span class="amount">' . esc_html($pricing->price) . '</span>
                <span class="period">/' . esc_html($pricing->period) . '</span>
            </div>
        </div>
        <div class="pricing-features">
            <ul>
                ' . $features_html . '
            </ul>
        </div>
        <div class="pricing-footer">
            <a href="' . esc_url($pricing->button_url) . '" class="pricing-button">' .
        esc_html($pricing->button_text) . '</a>
        </div>
    </div>';

    return $html;
}
add_shortcode('pricing_table', 'pricing_table_shortcode');
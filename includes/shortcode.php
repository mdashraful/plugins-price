<?php
function brlbd_enqueue_frontend_styles()
{
    wp_enqueue_style('brlbd-frontend-styles', plugin_dir_url(__FILE__) . '../assets/styles.css', [], '1.0');
}
add_action('wp_enqueue_scripts', 'brlbd_enqueue_frontend_styles');

function brlbd_pricing_tables()
{

    $plans = get_option('brlbd_pricing_plans', []);
    $table_title = get_option('brlbd_pricing_table_title', 'BRLBD Pricing');
    ob_start();
    ?>
    <h2 style="text-align:center;"><?php echo esc_html($table_title); ?></h2>
    <div class="pricing-container">
        <div class="pricing-table">
            <?php foreach ($plans as $index => $plan): ?>
                <div class="pricing-box">
                    <div class="plan-title"><?php echo esc_html($plan['title']); ?></div>
                    <p class="price"> <?php echo esc_html($plan['currency_symbol']); ?><?php echo esc_html($plan['price']); ?>
                        <?php echo esc_html($plan['currency_name']); ?></p>
                    <ul>
                        <?php foreach ($plan['features'] as $feature): ?>
                            <li><?php echo esc_html(trim($feature)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo esc_url($plan['button_link']); ?>" class="buybutton">
                        <?php echo esc_html($plan['button_text']); ?>
                    </a>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('brlbd_pricing_tables', 'brlbd_pricing_tables');

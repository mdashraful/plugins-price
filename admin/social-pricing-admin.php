<?php
// social-pricing-admin.php

// Add admin menu for Pricing Settings
function social_add_pricing_menu() {
    add_menu_page(
        'Pricing Settings',
        'Pricing Settings',
        'manage_options',
        'social-pricing-settings',
        'social_pricing_settings_page',
        'dashicons-money',
        26
    );
}
add_action('admin_menu', 'social_add_pricing_menu');

// Enqueue necessary admin scripts
function social_pricing_admin_scripts($hook) {
    if ($hook != 'toplevel_page_social-pricing-settings') return;

    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('social-pricing-admin', plugins_url('js/admin.js', __FILE__), array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'social_pricing_admin_scripts');

// Display the pricing settings page
function social_pricing_settings_page() {
    ?>
    <div class="pricing-wrap social-pricing-settings">
        <h1>Pricing Settings</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
            settings_fields('social_pricing_settings_group');
            do_settings_sections('social-pricing-settings');
            ?>

            <!-- Top Settings Section -->
            <div class="top-settings">
                <div class="form-group">
                    <label for="social_pricing_template">Select Template</label>
                    <select name="social_pricing_template" id="social_pricing_template">
                        <option value="template1" <?php selected(get_option('social_pricing_template'), 'template1'); ?>>Template 1</option>
                        <option value="template2" <?php selected(get_option('social_pricing_template'), 'template2'); ?>>Template 2</option>
                        <option value="template3" <?php selected(get_option('social_pricing_template'), 'template3'); ?>>Template 3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pricing_theme_color">Theme Color</label>
                    <input type="text" name="pricing_theme_color" id="pricing_theme_color" class="color-picker"
                           value="<?php echo esc_attr(get_option('pricing_theme_color')); ?>"
                           data-default-color="#0073e6" />
                </div>

                <div class="form-group">
                    <label for="pricing_currency">Currency</label>
                    <select name="pricing_currency" id="pricing_currency">
                        <option value="$" <?php selected(get_option('pricing_currency'), '$'); ?>>USD ($)</option>
                        <option value="€" <?php selected(get_option('pricing_currency'), '€'); ?>>Euro (€)</option>
                        <option value="£" <?php selected(get_option('pricing_currency'), '£'); ?>>GBP (£)</option>
                        <option value="¥" <?php selected(get_option('pricing_currency'), '¥'); ?>>Yen (¥)</option>
                        <option value="₹" <?php selected(get_option('pricing_currency'), '₹'); ?>>Rupee (₹)</option>
                    </select>
                </div>
            </div>

            <!-- Plans Section -->
            <div class="plans-container">
                <!-- Weekly Plan -->
                <div class="plan-box">
                    <h3>Weekly Plan</h3>
                    <div class="form-group">
                        <label>Plan Logo</label>
                        <div class="logo-upload">
                            <input type="hidden" name="social_weekly_logo" id="social_weekly_logo"
                                   value="<?php echo esc_attr(get_option('social_weekly_logo')); ?>" />
                            <div class="logo-preview">
                                <?php if ($weekly_logo = get_option('social_weekly_logo')) : ?>
                                    <img src="<?php echo esc_url($weekly_logo); ?>" style="max-width: 100px; height: auto;" />
                                <?php endif; ?>
                            </div>
                            <button type="button" class="upload-logo-button button" data-target="social_weekly_logo">
                                <?php _e('Upload Logo'); ?>
                            </button>
                            <button type="button" class="remove-logo-button button" data-target="social_weekly_logo">
                                <?php _e('Remove Logo'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="social_weekly_price">Price</label>
                        <input type="text" name="social_weekly_price" id="social_weekly_price"
                               value="<?php echo esc_attr(get_option('social_weekly_price')); ?>" />
                    </div>
                    <div class="form-group">
                        <label>Features</label>
                        <div id="weekly-features-container">
                            <?php
                            $weekly_features = get_option('social_weekly_features', []);
                            if (!empty($weekly_features)) {
                                foreach ($weekly_features as $feature) {
                                    echo '<div class="pricing-feature-input">
                                        <input type="text" name="social_weekly_features[]" value="' . esc_attr($feature) . '" />
                                        <button type="button" class="remove-feature">Remove</button>
                                    </div>';
                                }
                            } else {
                                echo '<div class="pricing-feature-input">
                                    <input type="text" name="social_weekly_features[]" />
                                </div>';
                            }
                            ?>
                        </div>
                        <button type="button" class="add-feature" data-container="weekly-features-container" data-name="social_weekly_features">Add More</button>
                    </div>
                    <div class="form-group">
                        <label for="social_weekly_link">Link</label>
                        <input type="text" name="social_weekly_link" id="social_weekly_link"
                               value="<?php echo esc_attr(get_option('social_weekly_link')); ?>" />
                    </div>
                </div>

                <!-- Monthly Plan -->
                <div class="plan-box">
                    <h3>Monthly Plan</h3>
                    <div class="form-group">
                        <label>Plan Logo</label>
                        <div class="logo-upload">
                            <input type="hidden" name="social_monthly_logo" id="social_monthly_logo"
                                   value="<?php echo esc_attr(get_option('social_monthly_logo')); ?>" />
                            <div class="logo-preview">
                                <?php if ($monthly_logo = get_option('social_monthly_logo')) : ?>
                                    <img src="<?php echo esc_url($monthly_logo); ?>" style="max-width: 100px; height: auto;" />
                                <?php endif; ?>
                            </div>
                            <button type="button" class="upload-logo-button button" data-target="social_monthly_logo">
                                <?php _e('Upload Logo'); ?>
                            </button>
                            <button type="button" class="remove-logo-button button" data-target="social_monthly_logo">
                                <?php _e('Remove Logo'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="social_monthly_price">Price</label>
                        <input type="text" name="social_monthly_price" id="social_monthly_price"
                               value="<?php echo esc_attr(get_option('social_monthly_price')); ?>" />
                    </div>
                    <div class="form-group">
                        <label>Features</label>
                        <div id="monthly-features-container">
                            <?php
                            $monthly_features = get_option('social_monthly_features', []);
                            if (!empty($monthly_features)) {
                                foreach ($monthly_features as $feature) {
                                    echo '<div class="pricing-feature-input">
                                        <input type="text" name="social_monthly_features[]" value="' . esc_attr($feature) . '" />
                                        <button type="button" class="remove-feature">Remove</button>
                                    </div>';
                                }
                            } else {
                                echo '<div class="pricing-feature-input">
                                    <input type="text" name="social_monthly_features[]" />
                                </div>';
                            }
                            ?>
                        </div>
                        <button type="button" class="add-feature" data-container="monthly-features-container" data-name="social_monthly_features">Add More</button>
                    </div>
                    <div class="form-group">
                        <label for="social_monthly_link">Link</label>
                        <input type="text" name="social_monthly_link" id="social_monthly_link"
                               value="<?php echo esc_attr(get_option('social_monthly_link')); ?>" />
                    </div>
                </div>

                <!-- Yearly Plan -->
                <div class="plan-box">
                    <h3>Yearly Plan</h3>
                    <div class="form-group">
                        <label>Plan Logo</label>
                        <div class="logo-upload">
                            <input type="hidden" name="social_yearly_logo" id="social_yearly_logo"
                                   value="<?php echo esc_attr(get_option('social_yearly_logo')); ?>" />
                            <div class="logo-preview">
                                <?php if ($yearly_logo = get_option('social_yearly_logo')) : ?>
                                    <img src="<?php echo esc_url($yearly_logo); ?>" style="max-width: 100px; height: auto;" />
                                <?php endif; ?>
                            </div>
                            <button type="button" class="upload-logo-button button" data-target="social_yearly_logo">
                                <?php _e('Upload Logo'); ?>
                            </button>
                            <button type="button" class="remove-logo-button button" data-target="social_yearly_logo">
                                <?php _e('Remove Logo'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="social_yearly_price">Price</label>
                        <input type="text" name="social_yearly_price" id="social_yearly_price"
                               value="<?php echo esc_attr(get_option('social_yearly_price')); ?>" />
                    </div>
                    <div class="form-group">
                        <label>Features</label>
                        <div id="yearly-features-container">
                            <?php
                            $yearly_features = get_option('social_yearly_features', []);
                            if (!empty($yearly_features)) {
                                foreach ($yearly_features as $feature) {
                                    echo '<div class="pricing-feature-input">
                                        <input type="text" name="social_yearly_features[]" value="' . esc_attr($feature) . '" />
                                        <button type="button" class="remove-feature">Remove</button>
                                    </div>';
                                }
                            } else {
                                echo '<div class="pricing-feature-input">
                                    <input type="text" name="social_yearly_features[]" />
                                </div>';
                            }
                            ?>
                        </div>
                        <button type="button" class="add-feature" data-container="yearly-features-container" data-name="social_yearly_features">Add More</button>
                    </div>
                    <div class="form-group">
                        <label for="social_yearly_link">Link</label>
                        <input type="text" name="social_yearly_link" id="social_yearly_link"
                               value="<?php echo esc_attr(get_option('social_yearly_link')); ?>" />
                    </div>
                </div>
            </div>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register and sanitize settings
function social_pricing_settings_init() {
    // Template and Color
    register_setting('social_pricing_settings_group', 'social_pricing_template');
    register_setting('social_pricing_settings_group', 'pricing_theme_color');

    // Currency
    register_setting('social_pricing_settings_group', 'pricing_currency');

    // Weekly Plan
    register_setting('social_pricing_settings_group', 'social_weekly_price', 'floatval');
    register_setting('social_pricing_settings_group', 'social_weekly_link', 'esc_url_raw');
    register_setting('social_pricing_settings_group', 'social_weekly_logo', 'esc_url_raw');
    register_setting('social_pricing_settings_group', 'social_weekly_features', 'social_sanitize_features');

    // Monthly Plan
    register_setting('social_pricing_settings_group', 'social_monthly_price', 'floatval');
    register_setting('social_pricing_settings_group', 'social_monthly_link', 'esc_url_raw');
    register_setting('social_pricing_settings_group', 'social_monthly_logo', 'esc_url_raw');
    register_setting('social_pricing_settings_group', 'social_monthly_features', 'social_sanitize_features');

    // Yearly Plan
    register_setting('social_pricing_settings_group', 'social_yearly_price', 'floatval');
    register_setting('social_pricing_settings_group', 'social_yearly_link', 'esc_url_raw');
    register_setting('social_pricing_settings_group', 'social_yearly_logo', 'esc_url_raw');
    register_setting('social_pricing_settings_group', 'social_yearly_features', 'social_sanitize_features');
}
add_action('admin_init', 'social_pricing_settings_init');

// Custom sanitization callback for features
function social_sanitize_features($input) {
    if (!is_array($input)) return [];
    return array_map('sanitize_text_field', array_filter($input));
}

// JavaScript for admin
add_action('admin_footer', 'social_pricing_admin_js');
function social_pricing_admin_js() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            // Color picker
            $('.color-picker').wpColorPicker();

            // Media uploader
            $('.upload-logo-button').click(function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                var custom_uploader = wp.media({
                    title: 'Select Plan Logo',
                    button: { text: 'Use this Image' },
                    multiple: false
                });

                custom_uploader.on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    $('#' + target).val(attachment.url).trigger('change');
                    $('#' + target).siblings('.logo-preview').html('<img src="' + attachment.url + '" style="max-width: 100px; height: auto;" />');
                });

                custom_uploader.open();
            });

            // Remove logo
            $('.remove-logo-button').click(function() {
                var target = $(this).data('target');
                $('#' + target).val('');
                $(this).siblings('.logo-preview').html('');
            });

            // Add/remove features
            $('.add-feature').click(function() {
                var container = $('#' + $(this).data('container'));
                if (container.find('.pricing-feature-input').length < 10) {
                    container.append('<div class="pricing-feature-input"><input type="text" name="' + $(this).data('name') + '[]" /><button type="button" class="remove-feature">Remove</button></div>');
                } else {
                    alert('Maximum 10 features allowed per plan.');
                }
            });

            $(document).on('click', '.remove-feature', function() {
                $(this).closest('.pricing-feature-input').remove();
            });
        });
    </script>
    <?php
}
<?php

function add_pricing_menu() {
    add_menu_page(
        'Pricing Settings',
        'Pricing Settings',
        'manage_options',
        'package-price-settings',
        'pricing_settings_page',
        'dashicons-money',
        26
    );
}
add_action('admin_menu', 'add_pricing_menu');

function pricing_admin_scripts($hook) {
    if ($hook != 'toplevel_page_package-price-settings') return;

    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('package-price-admin', plugins_url('js/admin.js', __FILE__), array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'pricing_admin_scripts');

function pricing_settings_page() {
    ?>
    <div class="pricing-wrap package-price-settings">
        <h1>Pricing Settings</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
            settings_fields('pricing_settings_group');
            do_settings_sections('package-price-settings');
            ?>

            <!-- Top Settings Section -->
            <div class="top-settings">
                <div class="form-group">
                    <label for="pricing_template">Select Template</label>
                    <select name="pricing_template" id="pricing_template">
                        <option value="template1" <?php selected(get_option('pricing_template'), 'template1'); ?>>Translucent White</option>
                        <option value="template2" <?php selected(get_option('pricing_template'), 'template2'); ?>>Peach Orange</option>
                        <option value="template3" <?php selected(get_option('pricing_template'), 'template3'); ?>>Deep Ocean</option>
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
                        <option value="৳" <?php selected(get_option('pricing_currency'), '৳'); ?>>Bangladeshi Taka (৳)</option>
                        <option value="₽" <?php selected(get_option('pricing_currency'), '₽'); ?>>Russian Ruble (₽)</option>
                        <option value="₩" <?php selected(get_option('pricing_currency'), '₩'); ?>>South Korean Won (₩)</option>
                        <option value="₺" <?php selected(get_option('pricing_currency'), '₺'); ?>>Turkish Lira (₺)</option>
                        <option value="₦" <?php selected(get_option('pricing_currency'), '₦'); ?>>Nigerian Naira (₦)</option>
                        <option value="R$" <?php selected(get_option('pricing_currency'), 'R$'); ?>>Brazilian Real (R$)</option>
                        <option value="CHF" <?php selected(get_option('pricing_currency'), 'CHF'); ?>>Swiss Franc (CHF)</option>
                        <option value="CAD" <?php selected(get_option('pricing_currency'), 'CAD'); ?>>Canadian Dollar (CAD)</option>
                        <option value="AUD" <?php selected(get_option('pricing_currency'), 'AUD'); ?>>Australian Dollar (AUD)</option>
                        <option value="SGD" <?php selected(get_option('pricing_currency'), 'SGD'); ?>>Singapore Dollar (SGD)</option>
                        <option value="HKD" <?php selected(get_option('pricing_currency'), 'HKD'); ?>>Hong Kong Dollar (HKD)</option>
                        <option value="MXN" <?php selected(get_option('pricing_currency'), 'MXN'); ?>>Mexican Peso (MXN)</option>
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
                            <input type="hidden" name="weekly_logo" id="weekly_logo"
                                   value="<?php echo esc_attr(get_option('weekly_logo')); ?>" />
                            <div class="logo-preview">
                                <?php if ($weekly_logo = get_option('weekly_logo')) : ?>
                                    <?php echo wp_get_attachment_image(attachment_url_to_postid($weekly_logo), 'thumbnail'); ?>
                                <?php endif; ?>
                            </div>

                            <button type="button" class="upload-logo-button button" data-target="weekly_logo">
                                <?php echo esc_html__('Upload Logo', 'package-price'); ?>
                            </button>
                            <button type="button" class="remove-logo-button button" data-target="weekly_logo">
                                <?php echo esc_html__('Remove Logo', 'package-price'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="weekly_price">Price</label>
                        <input type="text" name="weekly_price" id="weekly_price"
                               value="<?php echo esc_attr(get_option('weekly_price')); ?>" />
                    </div>
                    <div class="form-group">
                        <label>Features</label>
                        <div id="weekly-features-container">
                            <?php
                            $weekly_features = get_option('weekly_features', []);
                            if (!empty($weekly_features)) {
                                foreach ($weekly_features as $feature) {
                                    echo '<div class="pricing-feature-input">
                                        <input type="text" name="weekly_features[]" value="' . esc_attr($feature) . '" />
                                        <button type="button" class="remove-feature">Remove</button>
                                    </div>';
                                }
                            } else {
                                echo '<div class="pricing-feature-input">
                                    <input type="text" name="weekly_features[]" />
                                </div>';
                            }
                            ?>
                        </div>
                        <button type="button" class="add-feature" data-container="weekly-features-container" data-name="weekly_features">Add More</button>
                    </div>
                    <div class="form-group">
                        <label for="weekly_link">Link</label>
                        <input type="text" name="weekly_link" id="weekly_link"
                               value="<?php echo esc_attr(get_option('weekly_link')); ?>" />
                    </div>
                </div>

                <!-- Monthly Plan -->
                <div class="plan-box">
                    <h3>Monthly Plan</h3>
                    <div class="form-group">
                        <label>Plan Logo</label>
                        <div class="logo-upload">
                            <input type="hidden" name="monthly_logo" id="monthly_logo"
                                   value="<?php echo esc_attr(get_option('monthly_logo')); ?>" />
                            <div class="logo-preview">
                                <?php if ($monthly_logo = get_option('monthly_logo')) : ?>
                                    <?php echo wp_get_attachment_image(attachment_url_to_postid($monthly_logo), 'thumbnail'); ?>
                                <?php endif; ?>
                            </div>

                            <button type="button" class="upload-logo-button button" data-target="monthly_logo">
                                <?php echo esc_html__('Upload Logo', 'package-price'); ?>
                            </button>
                            <button type="button" class="remove-logo-button button" data-target="monthly_logo">
                                <?php echo esc_html__('Remove Logo', 'package-price'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="monthly_price">Price</label>
                        <input type="text" name="monthly_price" id="monthly_price"
                               value="<?php echo esc_attr(get_option('monthly_price')); ?>" />
                    </div>
                    <div class="form-group">
                        <label>Features</label>
                        <div id="monthly-features-container">
                            <?php
                            $monthly_features = get_option('monthly_features', []);
                            if (!empty($monthly_features)) {
                                foreach ($monthly_features as $feature) {
                                    echo '<div class="pricing-feature-input">
                                        <input type="text" name="monthly_features[]" value="' . esc_attr($feature) . '" />
                                        <button type="button" class="remove-feature">Remove</button>
                                    </div>';
                                }
                            } else {
                                echo '<div class="pricing-feature-input">
                                    <input type="text" name="monthly_features[]" />
                                </div>';
                            }
                            ?>
                        </div>
                        <button type="button" class="add-feature" data-container="monthly-features-container" data-name="monthly_features">Add More</button>
                    </div>
                    <div class="form-group">
                        <label for="monthly_link">Link</label>
                        <input type="text" name="monthly_link" id="monthly_link"
                               value="<?php echo esc_attr(get_option('monthly_link')); ?>" />
                    </div>
                </div>

                <!-- Yearly Plan -->
                <div class="plan-box">
                    <h3>Yearly Plan</h3>
                    <div class="form-group">
                        <label>Plan Logo</label>
                        <div class="logo-upload">
                            <input type="hidden" name="yearly_logo" id="yearly_logo"
                                   value="<?php echo esc_attr(get_option('yearly_logo')); ?>" />
                            <div class="logo-preview">
                                <?php if ($yearly_logo = get_option('yearly_logo')) : ?>
                                    <?php echo wp_get_attachment_image(attachment_url_to_postid($yearly_logo), 'thumbnail'); ?>
                                <?php endif; ?>
                            </div>

                            <button type="button" class="upload-logo-button button" data-target="yearly_logo">
                                <?php echo esc_html__('Upload Logo', 'package-price'); ?>
                            </button>
                            <button type="button" class="remove-logo-button button" data-target="yearly_logo">
                                <?php echo esc_html__('Remove Logo', 'package-price'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yearly_price">Price</label>
                        <input type="text" name="yearly_price" id="yearly_price"
                               value="<?php echo esc_attr(get_option('yearly_price')); ?>" />
                    </div>
                    <div class="form-group">
                        <label>Features</label>
                        <div id="yearly-features-container">
                            <?php
                            $yearly_features = get_option('yearly_features', []);
                            if (!empty($yearly_features)) {
                                foreach ($yearly_features as $feature) {
                                    echo '<div class="pricing-feature-input">
                                        <input type="text" name="yearly_features[]" value="' . esc_attr($feature) . '" />
                                        <button type="button" class="remove-feature">Remove</button>
                                    </div>';
                                }
                            } else {
                                echo '<div class="pricing-feature-input">
                                    <input type="text" name="yearly_features[]" />
                                </div>';
                            }
                            ?>
                        </div>
                        <button type="button" class="add-feature" data-container="yearly-features-container" data-name="yearly_features">Add More</button>
                    </div>
                    <div class="form-group">
                        <label for="yearly_link">Link</label>
                        <input type="text" name="yearly_link" id="yearly_link"
                               value="<?php echo esc_attr(get_option('yearly_link')); ?>" />
                    </div>
                </div>
            </div>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}



// Register and sanitize settings
function pricing_settings_init() {
    // Template and Color
    register_setting('pricing_settings_group', 'pricing_template', 'sanitize_text_field');
    register_setting('pricing_settings_group', 'pricing_theme_color', 'sanitize_hex_color');

    // Currency
    register_setting('pricing_settings_group', 'pricing_currency', 'sanitize_text_field');

    // Weekly Plan
    register_setting('pricing_settings_group', 'weekly_price', 'floatval');
    register_setting('pricing_settings_group', 'weekly_link', 'esc_url_raw');
    register_setting('pricing_settings_group', 'weekly_logo', 'esc_url_raw');
    register_setting('pricing_settings_group', 'weekly_features', 'pricing_sanitize_features');

    // Monthly Plan
    register_setting('pricing_settings_group', 'monthly_price', 'floatval');
    register_setting('pricing_settings_group', 'monthly_link', 'esc_url_raw');
    register_setting('pricing_settings_group', 'monthly_logo', 'esc_url_raw');
    register_setting('pricing_settings_group', 'monthly_features', 'pricing_sanitize_features');

    // Yearly Plan
    register_setting('pricing_settings_group', 'yearly_price', 'floatval');
    register_setting('pricing_settings_group', 'yearly_link', 'esc_url_raw');
    register_setting('pricing_settings_group', 'yearly_logo', 'esc_url_raw');
    register_setting('pricing_settings_group', 'yearly_features', 'pricing_sanitize_features');
}

add_action('admin_init', 'pricing_settings_init');

// Custom sanitization callback for features
function pricing_sanitize_features($input) {
    if (is_array($input)) {
        // Sanitize each feature as needed, for example, making sure all features are strings
        return array_map('sanitize_text_field', $input);
    }
    return sanitize_text_field($input); // For a non-array input
}

// JavaScript for admin
add_action('admin_footer', 'pricing_admin_js');
function pricing_admin_js() {
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
                    var attachmentId = attachment.id; // Get the attachment ID

                    // Send the attachment ID to PHP via AJAX
                    $.ajax({
                        url: ajaxurl, // WordPress AJAX URL
                        method: 'POST',
                        data: {
                            action: 'fetch_logo_image',
                            attachment_id: attachmentId
                        },
                        success: function(response) {
                            // Update the target input with the image URL
                            $('#' + target).val(attachment.url).trigger('change');
                            // Replace the preview with the image
                            $('#' + target).siblings('.logo-preview').html(response);
                        }
                    });
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

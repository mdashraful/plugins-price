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

// Display the pricing settings page
function social_pricing_settings_page() {
    ?>
    <div class="pricing-wrap">
        <h1>Pricing Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('social_pricing_settings_group');
            do_settings_sections('social-pricing-settings');
            ?>

            <!-- Template and Theme Color Section -->
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
                    <input type="text" name="pricing_theme_color" id="pricing_theme_color" class="color-picker" value="<?php echo esc_attr(get_option('pricing_theme_color')); ?>" data-default-color="#0073e6" />
                </div>
            </div>

            <!-- Plans Section -->
            <div class="plans-container">
                <!-- Weekly Plan -->
                <div class="plan-box">
                    <h3>Weekly Plan</h3>
                    <div class="form-group">
                        <label for="social_weekly_price">Price</label>
                        <input type="text" name="social_weekly_price" id="social_weekly_price" value="<?php echo esc_attr(get_option('social_weekly_price')); ?>" />
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
                        <input type="text" name="social_weekly_link" id="social_weekly_link" value="<?php echo esc_attr(get_option('social_weekly_link')); ?>" />
                    </div>
                </div>

                <!-- Monthly Plan -->
                <div class="plan-box">
                    <h3>Monthly Plan</h3>
                    <div class="form-group">
                        <label for="social_monthly_price">Price</label>
                        <input type="text" name="social_monthly_price" id="social_monthly_price" value="<?php echo esc_attr(get_option('social_monthly_price')); ?>" />
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
                        <input type="text" name="social_monthly_link" id="social_monthly_link" value="<?php echo esc_attr(get_option('social_monthly_link')); ?>" />
                    </div>
                </div>

                <!-- Yearly Plan -->
                <div class="plan-box">
                    <h3>Yearly Plan</h3>
                    <div class="form-group">
                        <label for="social_yearly_price">Price</label>
                        <input type="text" name="social_yearly_price" id="social_yearly_price" value="<?php echo esc_attr(get_option('social_yearly_price')); ?>" />
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
                        <input type="text" name="social_yearly_link" id="social_yearly_link" value="<?php echo esc_attr(get_option('social_yearly_link')); ?>" />
                    </div>
                </div>
            </div>

            <?php submit_button(); ?>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize color picker
            if (typeof wp !== 'undefined' && wp.hasOwnProperty('ColorPicker')) {
                jQuery('.color-picker').wpColorPicker();
            }

            // Add feature inputs
            document.querySelectorAll('.add-feature').forEach(button => {
                button.addEventListener('click', function() {
                    const container = document.getElementById(this.dataset.container);
                    const featureName = this.dataset.name;
                    const inputs = container.querySelectorAll('input');

                    if (inputs.length < 10) {
                        const newInput = document.createElement('div');
                        newInput.className = 'pricing-feature-input';
                        newInput.innerHTML = `
                        <input type="text" name="${featureName}[]" />
                        <button type="button" class="remove-feature">Remove</button>
                    `;
                        container.appendChild(newInput);

                        // Add event listener to new remove button
                        newInput.querySelector('.remove-feature').addEventListener('click', function() {
                            this.closest('.pricing-feature-input').remove();
                        });
                    } else {
                        alert('Maximum 10 features allowed per plan.');
                    }
                });
            });

            // Remove feature inputs
            document.querySelectorAll('.remove-feature').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.pricing-feature-input').remove();
                });
            });
        });
    </script>
    <?php
}

// Register and sanitize settings
function social_pricing_settings_init() {
    register_setting('social_pricing_settings_group', 'social_weekly_price');
    register_setting('social_pricing_settings_group', 'social_monthly_price');
    register_setting('social_pricing_settings_group', 'social_yearly_price');
    register_setting('social_pricing_settings_group', 'social_pricing_template');
    register_setting('social_pricing_settings_group', 'pricing_theme_color');

    register_setting('social_pricing_settings_group', 'social_weekly_link');
    register_setting('social_pricing_settings_group', 'social_monthly_link');
    register_setting('social_pricing_settings_group', 'social_yearly_link');

    // Register features with custom sanitization
    register_setting('social_pricing_settings_group', 'social_weekly_features', 'social_sanitize_features');
    register_setting('social_pricing_settings_group', 'social_monthly_features', 'social_sanitize_features');
    register_setting('social_pricing_settings_group', 'social_yearly_features', 'social_sanitize_features');
}
add_action('admin_init', 'social_pricing_settings_init');

// Custom sanitization callback for features
function social_sanitize_features($input) {
    if (!is_array($input)) {
        $input = [];
    }
    return array_map('sanitize_text_field', array_filter($input)); // Sanitize each feature and remove empty values
}
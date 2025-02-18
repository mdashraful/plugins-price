<?php

function brlbd_add_admin_menu()
{
    add_menu_page(
        'BRLBD Pricing Settings',
        'BRLBD Pricing',
        'manage_options',
        'brlbd_pricing_settings',
        'brlbd_manage_plans_page',
        'dashicons-money',
        90
    );
}
add_action('admin_menu', 'brlbd_add_admin_menu');

/**
 * Manage Pricing Plans Page
 */
function brlbd_manage_plans_page()
{
    $currencies = brlbd_get_currency_list();
    $plans = get_option('brlbd_pricing_plans', []);
    $edit_index = isset($_GET['edit']) ? intval($_GET['edit']) : -1;
    $edit_plan = $edit_index >= 0 && isset($plans[$edit_index]) ? $plans[$edit_index] : ['title' => '', 'price' => '', 'features' => [], 'button_text' => '', 'button_link' => '','currency_symbol' => '',
        'currency_name' => ''];
    $table_title = get_option('brlbd_pricing_table_title', 'BRLBD Pricing');

    if (isset($_GET['delete'])) {
        $index = intval($_GET['delete']);
        if (isset($plans[$index])) {
            unset($plans[$index]);
            update_option('brlbd_pricing_plans', array_values($plans));
            echo '<div class="updated"><p>Pricing plan deleted successfully!</p></div>';
        }
    }

    if (isset($_POST['save_pricing_plan'])) {
        $new_plan = [
            'title' => sanitize_text_field($_POST['title']),
            'price' => sanitize_text_field($_POST['price']),
            'currency_symbol' => sanitize_text_field($_POST['currency_symbol']),
            'currency_name' => sanitize_text_field($_POST['currency_name']),
            'features' => array_map('sanitize_text_field', $_POST['features']),
            'button_text' => sanitize_text_field($_POST['button_text']),
            'button_link' => esc_url_raw($_POST['button_link'])
        ];

        if ($edit_index >= 0) {
            $plans[$edit_index] = $new_plan;
        } else {
            $plans[] = $new_plan;
        }

        update_option('brlbd_pricing_plans', $plans);
        wp_redirect(admin_url('admin.php?page=brlbd_pricing_settings'));
        exit;
    }

    if (isset($_POST['save_pricing_table_title'])) {
        update_option('brlbd_pricing_table_title', sanitize_text_field($_POST['table_title']));
        echo '<div class="updated"><p>Pricing Table Title updated successfully!</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Manage Pricing Plans</h1>
        <h3>Use the shortcode <code>[brlbd_pricing_tables]</code> to display the pricing table on your site.</h3>

        <!-- Table Title Form -->
        <form method="post">
            <h2>Pricing Table Title</h2>
            <table class="form-table">
                <tr>
                    <th><label>Table Title</label></th>
                    <td><input type="text" name="table_title" value="<?php echo esc_attr($table_title); ?>" required /></td>
                </tr>
            </table>
            <p><input type="submit" name="save_pricing_table_title" value="Update Table Title"
                    class="button button-primary" /></p>
        </form>

        <h2><?php echo ($edit_index >= 0 ? 'Edit' : 'Add New'); ?> Pricing Plan</h2>
        <form method="post">
            <input type="hidden" name="edit_index" value="<?php echo $edit_index; ?>">
            <table class="form-table">
                <tr>
                    <th><label>Plan Name</label></th>
                    <td><input type="text" name="title" value="<?php echo esc_attr($edit_plan['title']); ?>" required />
                    </td>
                </tr>
                <tr>
                    <th><label>Currency Symbol</label></th>
                    <td>
                        <select name="currency_symbol" required>
                            <?php foreach ($currencies as $symbol => $name): ?>
                                <option value="<?php echo esc_attr($symbol); ?>" <?php selected($edit_plan['currency_symbol'], $symbol); ?>>
                                    <?php echo esc_html($symbol); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label>Price</label></th>
                    <td><input type="text" name="price" value="<?php echo esc_attr($edit_plan['price']); ?>" required />
                    </td>
                </tr>
                <tr>
                    <th><label>Currency Name</label></th>
                    <td>
                        <select name="currency_name" required>
                            <?php foreach ($currencies as $symbol => $name): ?>
                                <option value="<?php echo esc_attr($name); ?>" <?php selected($edit_plan['currency_name'], $name); ?>>
                                    <?php echo esc_html($name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label>Features</label></th>
                    <td>
                        <div id="feature-fields">
                            <?php foreach ($edit_plan['features'] as $feature): ?>
                                <div><input type="text" name="features[]" value="<?php echo esc_attr($feature); ?>" required />
                                    <button type="button" onclick="this.parentNode.remove()">Remove</button>
                                </div>
                            <?php endforeach; ?>
                            <button type="button" onclick="addFeatureField()">Add More</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><label>Button Text</label></th>
                    <td><input type="text" name="button_text" value="<?php echo esc_attr($edit_plan['button_text']); ?>"
                            required /></td>
                </tr>
                <tr>
                    <th><label>Button Link</label></th>
                    <td><input type="text" name="button_link" value="<?php echo esc_attr($edit_plan['button_link']); ?>"
                            required /></td>
                </tr>
            </table>
            <p><input type="submit" name="save_pricing_plan"
                    value="<?php echo ($edit_index >= 0 ? 'Update Plan' : 'Add New Plan'); ?>"
                    class="button button-primary" /></p>
        </form>

        <h2>Current Plans</h2>
        <table class="widefat">
            <thead>
                <tr>
                    <th>Plan Name</th>
                    <th>Price</th>
                    <th>Features</th>
                    <th>Button Text</th>
                    <th>Button Link</th>
                    <th>currency Name</th>
                    <th>currency Symbol</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plans as $index => $plan): ?>
                    <tr>
                        <td><?php echo esc_html($plan['title']); ?></td>
                        <td>$<?php echo esc_html($plan['price']); ?></td>
                        <td><?php echo esc_html(implode(", ", $plan['features'])); ?></td>
                        <td><?php echo esc_html($plan['button_text']); ?></td>
                        <td><a href="<?php echo esc_url($plan['button_link']); ?>" target="_blank">Visit Link</a></td>
                        <td><?php echo esc_html($plan['currency_name']); ?></td>
                        <td><?php echo esc_html($plan['currency_symbol']); ?></td>
                        <td>
                            <a href="?page=brlbd_pricing_settings&edit=<?php echo $index; ?>" class="button">Edit</a>
                            <a href="?page=brlbd_pricing_settings&delete=<?php echo $index; ?>"
                                class="button button-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
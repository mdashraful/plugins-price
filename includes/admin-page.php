<?php
// Create database table on plugin activation
function create_pricing_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pricing_tables';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        plan_name varchar(255) NOT NULL,
        price decimal(10,2) NOT NULL,
        period varchar(50) NOT NULL,
        currency varchar(10) NOT NULL,
        features text NOT NULL,
        button_text varchar(50) NOT NULL,
        button_url varchar(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Add Admin Menu
function pricing_admin_menu()
{
    add_menu_page(
        'Pricing Tables',
        'Pricing Tables',
        'manage_options',
        'pricing-tables',
        'pricing_admin_page',
        'dashicons-money-alt'
    );
}
add_action('admin_menu', 'pricing_admin_menu');

// Admin Page Content
function pricing_admin_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pricing_tables';

    // Handle form submission for adding new pricing table
    if (isset($_POST['submit_pricing'])) {
        $wpdb->insert(
            $table_name,
            array(
                'plan_name' => sanitize_text_field($_POST['plan_name']),
                'price' => floatval($_POST['price']),
                'period' => sanitize_text_field($_POST['period']),
                'currency' => sanitize_text_field($_POST['currency']),
                'features' => sanitize_textarea_field($_POST['features']),
                'button_text' => sanitize_text_field($_POST['button_text']),
                'button_url' => esc_url_raw($_POST['button_url'])
            )
        );
        echo '<div class="notice notice-success"><p>Pricing table added successfully!</p></div>';
    }

    // Handle form submission for updating pricing table
    if (isset($_POST['update_pricing'])) {
        $wpdb->update(
            $table_name,
            array(
                'plan_name' => sanitize_text_field($_POST['plan_name']),
                'price' => floatval($_POST['price']),
                'period' => sanitize_text_field($_POST['period']),
                'currency' => sanitize_text_field($_POST['currency']),
                'features' => sanitize_textarea_field($_POST['features']),
                'button_text' => sanitize_text_field($_POST['button_text']),
                'button_url' => esc_url_raw($_POST['button_url'])
            ),
            array('id' => intval($_POST['pricing_id']))
        );
        echo '<div class="notice notice-success"><p>Pricing table updated successfully!</p></div>';
    }

    // Delete pricing table
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $wpdb->delete($table_name, array('id' => intval($_GET['id'])));
        echo '<div class="notice notice-success"><p>Pricing table deleted successfully!</p></div>';
    }

    // Pagination Logic
    $per_page = 10; // Number of items per page
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($current_page - 1) * $per_page;

    // Get total number of pricing tables
    $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

    // Get paginated pricing tables
    $pricing_tables = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name LIMIT %d OFFSET %d",
        $per_page,
        $offset
    ));

    // Check if we are editing a pricing table
    $edit_mode = false;
    $edit_data = null;
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        $edit_mode = true;
        $edit_data = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d",
            intval($_GET['id'])
        ));
    }
    ?>
    <div class="wrap">
        <h1>Pricing Tables</h1>

        <div style="display: flex; gap: 20px;">
            <!-- Left Side: Existing Pricing Tables -->
            <div style="flex: 1;">
                <div class="pricing-card">
                    <h2>Existing Pricing Tables</h2>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Plan Name</th>
                                <th>Price</th>
                                <th>Period</th>
                                <th>Shortcode</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pricing_tables as $table): ?>
                                <tr>
                                    <td><?php echo $table->id; ?></td>
                                    <td><?php echo esc_html($table->plan_name); ?></td>
                                    <td><?php echo esc_html($table->currency . $table->price); ?></td>
                                    <td><?php echo esc_html($table->period); ?></td>
                                    <td><code>[pricing_table id="<?php echo $table->id; ?>"]</code></td>
                                    <td>
                                        <a href="?page=pricing-tables&action=edit&id=<?php echo $table->id; ?>" 
                                           class="button button-small">Edit</a>
                                        <a href="?page=pricing-tables&action=delete&id=<?php echo $table->id; ?>" 
                                           onclick="return confirm('Are you sure you want to delete this pricing table?')" 
                                           class="button button-small button-link-delete">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="pagination">
                        <?php
                        $total_pages = ceil($total_items / $per_page);
                        echo paginate_links(array(
                            'base' => add_query_arg('paged', '%#%'),
                            'format' => '',
                            'prev_text' => __('« Previous'),
                            'next_text' => __('Next »'),
                            'total' => $total_pages,
                            'current' => $current_page,
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <!-- Right Side: Add/Edit Form -->
            <div style="flex: 1;">
                <div class="pricing-card">
                    <h2><?php echo $edit_mode ? 'Edit Pricing Table' : 'Add New Pricing Table'; ?></h2>
                    <form method="post">
                        <?php if ($edit_mode): ?>
                            <input type="hidden" name="pricing_id" value="<?php echo $edit_data->id; ?>">
                        <?php endif; ?>
                        <table class="form-table">
                            <tr>
                                <th><label for="plan_name">Plan Name</label></th>
                                <td>
                                    <input type="text" name="plan_name" id="plan_name" class="regular-text" 
                                           value="<?php echo $edit_mode ? esc_attr($edit_data->plan_name) : ''; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="price">Price</label></th>
                                <td>
                                    <input type="number" name="price" id="price" class="regular-text" step="0.01" 
                                           value="<?php echo $edit_mode ? esc_attr($edit_data->price) : ''; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="period">Period</label></th>
                                <td>
                                    <input type="text" name="period" id="period" class="regular-text" placeholder="month/year" 
                                           value="<?php echo $edit_mode ? esc_attr($edit_data->period) : ''; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="currency">Currency</label></th>
                                <td>
                                    <input type="text" name="currency" id="currency" class="regular-text" placeholder="$" 
                                           value="<?php echo $edit_mode ? esc_attr($edit_data->currency) : ''; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="features">Features</label></th>
                                <td>
                                    <textarea name="features" id="features" class="large-text" rows="5" 
                                              placeholder="One feature per line" required><?php echo $edit_mode ? esc_textarea($edit_data->features) : ''; ?></textarea>
                                    <p class="description">Enter each feature on a new line</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="button_text">Button Text</label></th>
                                <td>
                                    <input type="text" name="button_text" id="button_text" class="regular-text" 
                                           value="<?php echo $edit_mode ? esc_attr($edit_data->button_text) : ''; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="button_url">Button URL</label></th>
                                <td>
                                    <input type="url" name="button_url" id="button_url" class="regular-text" 
                                           value="<?php echo $edit_mode ? esc_url($edit_data->button_url) : ''; ?>" required>
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <?php if ($edit_mode): ?>
                                <input type="submit" name="update_pricing" class="button button-primary" value="Update Pricing Table">
                                <a href="?page=pricing-tables" class="button button-secondary">Cancel</a>
                            <?php else: ?>
                                <input type="submit" name="submit_pricing" class="button button-primary" value="Add Pricing Table">
                            <?php endif; ?>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
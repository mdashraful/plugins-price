<?php
// Add menu item
function social_sites_admin_menu() {
    add_menu_page(
        'Social Sites Settings',
        'Social Links',
        'manage_options',
        'social-sites-settings',
        'social_sites_admin_page',
        'dashicons-share',
        25
    );
}

add_action('admin_menu', 'social_sites_admin_menu');

// Admin page content
// Admin page content with category selection
function social_sites_admin_page() {
    if (isset($_POST['social_links_submit'])) {
        // Handle file uploads and category selection
        $social_links = $_POST['social_links'];
        foreach ($_FILES['social_links']['name'] as $index => $name) {
            if (!empty($name['icon'])) {
                $upload = wp_upload_bits(
                    $name['icon'],
                    null,
                    file_get_contents($_FILES['social_links']['tmp_name'][$index]['icon'])
                );
                if (!$upload['error']) {
                    $social_links[$index]['icon'] = $upload['url'];
                }
            } else {
                // Keep the existing icon if no file was uploaded
                $social_links[$index]['icon'] = $_POST['social_links'][$index]['icon_existing'] ?? '';
            }

            // Save the selected category for the social link
            $social_links[$index]['category'] = $_POST['social_links'][$index]['category'] ?? '';
        }

        // Update the social links data
        update_option('social_links_data', $social_links);
        echo '<div class="updated"><p>Social links updated successfully!</p></div>';
    }

    $social_links = get_option('social_links_data', []);
    $categories = get_terms(array(
        'taxonomy' => 'social_category',
        'hide_empty' => false,
    ));
    ?>
    <div class="wrap">
        <h1>Social Links Settings</h1>
        <form method="POST" enctype="multipart/form-data">
            <table class="form-table">
                <thead>
                <tr>
                    <th>Social Icon Title</th>
                    <th>Social Icon URL</th>
                    <th>Social Icon Image</th>
                    <th>Category</th>
                </tr>
                </thead>
                <tbody id="social-links-table">
                <?php if (!empty($social_links)) : ?>
                    <?php foreach ($social_links as $index => $link) : ?>
                        <tr>
                            <td><input type="text" name="social_links[<?php echo $index; ?>][title]" value="<?php echo esc_attr($link['title']); ?>" required /></td>
                            <td><input type="url" name="social_links[<?php echo $index; ?>][url]" value="<?php echo esc_url($link['url']); ?>" required /></td>
                            <td>
                                <input type="file" name="social_links[<?php echo $index; ?>][icon]" accept="image/*" />
                                <input type="hidden" name="social_links[<?php echo $index; ?>][icon_existing]" value="<?php echo esc_url($link['icon'] ?? ''); ?>" />
                                <?php if (!empty($link['icon'])) : ?>
                                    <img src="<?php echo esc_url($link['icon']); ?>" alt="Social Icon" style="max-width: 50px; max-height: 50px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <select name="social_links[<?php echo $index; ?>][category]">
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?php echo esc_attr($category->term_id); ?>" <?php selected($link['category'], $category->term_id); ?>>
                                            <?php echo esc_html($category->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><button type="button" class="remove-row">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>

            <button type="button" id="add-social-link">Add Social Link</button>
            <br><br>
            <input type="submit" name="social_links_submit" class="button button-primary" value="Save Links">
        </form>
    </div>

    <script>
        document.getElementById('add-social-link').addEventListener('click', function () {
            const table = document.getElementById('social-links-table');
            const rowCount = table.rows.length;
            const row = table.insertRow();
            row.innerHTML = `
                <td><input type="text" name="social_links[${rowCount}][title]" required /></td>
                <td><input type="url" name="social_links[${rowCount}][url]" required /></td>
                <td>
                    <input type="file" name="social_links[${rowCount}][icon]" accept="image/*" />
                </td>
                <td>
                    <select name="social_links[${rowCount}][category]">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo esc_attr($category->term_id); ?>">
                                <?php echo esc_html($category->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><button type="button" class="remove-row">Remove</button></td>
            `;
            row.querySelector('.remove-row').addEventListener('click', function () {
                row.remove();
            });
        });

        document.querySelectorAll('.remove-row').forEach(button => {
            button.addEventListener('click', function () {
                this.closest('tr').remove();
            });
        });
    </script>
    <?php
}

?>



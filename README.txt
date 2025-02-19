=== BRLBD Pricing ===
Contributors: [jahirul555]
Tags: pricing table, pricing, subscription, plans
Requires at least: 5.0
Tested up to: 6.1
Requires PHP: 7.0
Stable tag: trunk
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==
BRLBD Pricing is a simple and customizable WordPress plugin for creating and displaying pricing tables on your website. You can add plans, define their pricing, and display them in a beautiful, responsive layout.

== Installation ==
1. Upload the `brlbd-pricing` plugin folder to the `/wp-content/plugins/` directory, or install the plugin via the WordPress plugin repository.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the 'BRLBD Pricing' settings menu to customize your pricing table.

== How to Use ==

1. **Create Plans**  
   After activating the plugin, you can create pricing plans in the WordPress dashboard. Navigate to **BRLBD Pricing → Pricing Plans** and add new plans by filling out the necessary information.

2. **Add Plans to Your Page**  
   Once you have created your plans, use the following shortcode to display them:
   

[brlbd_pricing_tables]


You can place this shortcode on any page, post, or widget where you want to display your pricing table.

3. **Customization**  
The plugin offers basic customization options such as:
- Pricing plan title
- Description
- Price value
- Plan features
- Button text (e.g., "Get Started")
- Customize the look and feel of the pricing tables through the settings page.

4. **Admin Panel Options**  
- **Custom Plan Settings**: Navigate to **BRLBD Pricing → Pricing Plans** to edit your plans.  
- **Admin Page**: The admin interface is located under **BRLBD Pricing → Settings**.

5. **Frontend Appearance**  
The pricing tables will be displayed in a clean, responsive grid layout that looks good on all devices. You can hover over each plan to highlight them and encourage users to interact with the pricing options.

== Frequently Asked Questions ==

= How can I change the appearance of the pricing table? =
You can customize the look and feel by adding custom CSS in the **Custom CSS** section under **BRLBD Pricing → Settings**.

= Can I add more than one pricing table? =
Yes, you can create multiple pricing plans and display them wherever you need them using the `[brlbd_pricing_table]` shortcode.

= The plugin is not displaying the pricing table correctly, what should I do? =
1. Ensure that your theme supports shortcodes properly.
2. If you are using a caching plugin, clear the cache and reload the page.

= How do I remove the plugin? =
1. Deactivate the plugin from the WordPress dashboard under **Plugins → Installed Plugins**.
2. After deactivating, you can safely delete it.

== Changelog ==

= 1.0.0 =
* Initial release.
* Basic pricing table functionality.
* Admin panel for creating and editing pricing plans.

== Upgrade Notice ==

= 1.0.0 =
Initial release of the plugin. Upgrade from older versions is not applicable.

== Screenshots ==
1. Screenshot of the plugin's frontend pricing table layout.
2. Screenshot of the admin interface to create pricing plans.
3. Screenshot of the plugin settings page.

== License ==
This plugin is licensed under the GPL-2.0+ License.

== Acknowledgements ==
Special thanks to the WordPress community for their amazing support and documentation.
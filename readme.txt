=== Simple Reset ===
Contributors: jahid-we
Tags: reset, cleanup, delete, tools, maintenance, database, woocommerce
Requires at least: 5.8
Tested up to: 6.9
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A modern, lightweight, and secure WordPress cleanup plugin to safely remove posts, pages, media, WooCommerce data, comments, users, custom post types, and more.

== Description ==

Simple Reset is a powerful WordPress cleanup plugin designed for developers, designers, QA testers, and site administrators who need to quickly clean staging, development, or demo websites.

The plugin provides safe, one-click cleanup tools with built-in security features including nonce verification, administrator protection, backup confirmation, activity logging, and confirmation dialogs.

= Features =

* Delete all posts
* Delete all pages
* Delete all media
* Delete all comments
* Delete all categories (default category protected)
* Delete all tags
* Delete all users (administrators protected)
* Empty trash
* Delete post revisions
* Delete auto drafts
* Reset Theme Customizer
* Delete custom post types
* Protect active Elementor Site Kit
* Delete WooCommerce products
* Delete WooCommerce coupons
* Live dashboard statistics
* Activity logging
* Export plugin settings
* Import plugin settings
* User ID restriction
* Backup confirmation
* Email notifications
* Secure nonce verification
* Modern WordPress admin interface

Perfect for:

* Developers
* Agencies
* QA Testers
* Designers
* Staging Websites
* Demo Websites
* Local Development

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Navigate to **Reset → Dashboard**.
4. Configure the plugin under **Reset → Settings**.
5. Open **Reset Tools** and choose the content you want to remove.

== Frequently Asked Questions ==

= Will this plugin delete my administrator account? =

No. Administrator accounts and the currently logged-in user are always protected.

= Will the default WordPress category be deleted? =

No. The default category is automatically preserved.

= Does it support WooCommerce? =

Yes. Version 1.0.0 supports deleting WooCommerce products and coupons.

= Does it support Elementor? =

Yes. The active Elementor Site Kit is automatically protected during custom post type cleanup.

= Can I export my plugin settings? =

Yes. Settings can be exported to a JSON file and imported into another website.

= Can deleted content be recovered? =

No. Cleanup actions permanently delete content. Always create a complete backup before performing any reset.

== Screenshots ==

1. Dashboard
2. Reset Tools
3. Custom Post Types
4. Activity Logs
5. Settings
6. Export & Import Settings
7. Confirmation Modal

== Changelog ==

= 1.0.0 =

* Initial public release.
* Delete Posts.
* Delete Pages.
* Delete Media.
* Delete Comments.
* Delete Categories.
* Delete Tags.
* Delete Users.
* Delete Revisions.
* Delete Auto Drafts.
* Empty Trash.
* Reset Theme Customizer.
* Delete Custom Post Types.
* Protect active Elementor Site Kit.
* Delete WooCommerce Products.
* Delete WooCommerce Coupons.
* Activity Logging.
* Export & Import Settings.
* Dashboard Statistics.
* Email Notifications.
* Backup Confirmation.
* User ID Restriction.
* Modern WordPress admin interface.

== Upgrade Notice ==

= 1.0.0 =

Initial release of Simple Reset featuring secure WordPress cleanup tools, activity logging, WooCommerce support, and settings export/import.
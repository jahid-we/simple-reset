<?php
/**
 * Plugin Name: Simple Reset
 * Plugin URI: https://wordpress.org/plugins/simple-reset/
 * Description: Safely reset and clean your WordPress website by deleting posts, pages, media, comments, categories, tags, users, and more with built-in protection and confirmation.
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 8.0
 * Author: Jahid Hasan
 * Author URI: https://github.com/jahid-we
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: simple-reset
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Plugin Constants
 */
define( 'SR_NAME', 'Simple Reset' );
define( 'SR_VERSION', '1.0.0' );
define( 'SR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SR_URL', plugin_dir_url( __FILE__ ) );

/**
 * Composer Autoloader
 */
require_once SR_PATH . 'vendor/autoload.php';

/**
 * Plugin Activation
 */
register_activation_hook( __FILE__, 'sr_activate_plugin' );

function sr_activate_plugin() {
    add_option( 'sr_plugin_version', SR_VERSION );
    SimpleReset\Log::create_table();
}

/**
 * Plugin Deactivation
 */
register_deactivation_hook( __FILE__, 'sr_deactivate_plugin' );

function sr_deactivate_plugin() {
    //
}

/**
 * Start Plugin
 */
SimpleReset\Plugin::get_instance();
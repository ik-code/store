<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link  tatvic.com
 * @since 1.0.0
 * @package   Actionable Google Analytics
 *
 * @wordpress-plugin
 * Plugin Name:   Actionable Google Analytics
 * Plugin URI:https://www.tatvic.com/tatvic-labs/woocommerce-extension/
 * Description:   Actionable Google Analytics is a WooCommerce Plugin which allows you to use some of the most important features of Universal Analytics including Enhanced Ecommerce & User ID Tracking. Additionally, the plugin supports Product Refund, Content Grouping, Adwords & Facebook pixel conversion Tracking & 15+ Custom Dimensions & Metrics.
 * Version:   CC-V3-3.6
 * Author: Tatvic
 * Author URI: tatvic.com
 * License:   GPL-2.0+
 * License URI:   http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:   tatvic.com
 * Domain Path:   /languages
 * WC requires at least: 1.4.1
 * WC tested up to: 3.6
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', 'CC-V3-3.6' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-actionable-google-analytics-activator.php
 */
function activate_actionable_google_analytics() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-actionable-google-analytics-activator.php';
	Actionable_Google_Analytics_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-actionable-google-analytics-deactivator.php
 */
function deactivate_actionable_google_analytics() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-actionable-google-analytics-deactivator.php';
	Actionable_Google_Analytics_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_actionable_google_analytics' );
register_deactivation_hook( __FILE__, 'deactivate_actionable_google_analytics' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-actionable-google-analytics.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since1.0.0
 */
function run_actionable_google_analytics() {

	$plugin = new Actionable_Google_Analytics();
	$plugin->run();

}
run_actionable_google_analytics();

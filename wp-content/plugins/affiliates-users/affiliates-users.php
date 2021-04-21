<?php
/**
 * affiliates-users.php
 *
 * Copyright (c) www.itthinx.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 *
 * @author kento
 * @package affiliates-users
 * @since affiliates-users 1.0.0
 *
 * Plugin Name: Affiliates Users
 * Plugin URI: http://www.itthinx.com/plugins/affiliates-users
 * Description: New users become affiliates automatically. Also allows to import affiliate accounts from existing users.
 * Version: 1.5.0
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AFFILIATES_USERS_PLUGIN_VERSION', '1.5.0' );
if ( !function_exists( 'itthinx_plugins' ) ) {
	require_once 'itthinx/itthinx.php';
}
itthinx_plugins( __FILE__ );
define( 'AFFILIATES_USERS_PLUGIN_DOMAIN', 'affiliates-users' );
define( 'AFFILIATES_USERS_PLUGIN_FILE', __FILE__ );
define( 'AFFILIATES_USERS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'AFFILIATES_USERS_PLUGIN_DIR', WP_PLUGIN_DIR . '/affiliates-users' );
define( 'AFFILIATES_USERS_ADMIN_LIB', AFFILIATES_USERS_PLUGIN_DIR . '/admin' );

/**
 * Plugin boot.
 */
class Affiliates_Users_Plugin {

	/**
	 * Starting it up after plugins_loaded fires.
	 */
	public static function init() {
		add_action( 'plugins_loaded', array( __CLASS__, 'plugins_loaded' ) );
	}

	/**
	 * Loading ...
	 */
	public static function plugins_loaded() {
		if ( class_exists( 'Affiliates' ) ) {
			require_once 'includes/class-affiliates-users.php';
			if ( is_admin() ) {
				require_once 'admin/class-affiliates-users-admin.php';
			}
		}
	}
}
Affiliates_Users_Plugin::init();

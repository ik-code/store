<?php
/**
 * class-affiliates-users-admin.php
 *
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
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
 * @author Karim Rahimpur
 * @package affiliates-users
 * @since affiliates-users 1.2.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin section.
 */
class Affiliates_Users_Admin {

	/**
	 * Admin options setup.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_filter( 'plugin_action_links_'. plugin_basename( AFFILIATES_USERS_PLUGIN_FILE ), array( __CLASS__, 'admin_settings_link' ) );
	}

	/**
	 * Admin options admin setup.
	 */
	public static function admin_init() {
		wp_register_style( 'affiliates_users_admin', AFFILIATES_USERS_PLUGIN_URL . 'css/admin.css', array(), AFFILIATES_USERS_PLUGIN_VERSION );
	}

	/**
	 * Loads styles for the admin section.
	 */
	public static function admin_print_styles() {
		wp_enqueue_style( 'affiliates_users_admin' );
	}

	/**
	 * Add a menu item to the Appearance menu.
	 */
	public static function admin_menu() {
		$page = add_management_page(
			__( 'Import Affiliates', AFFILIATES_USERS_PLUGIN_DOMAIN ),
			__( 'Import Affiliates', AFFILIATES_USERS_PLUGIN_DOMAIN ),
			AFFILIATES_ADMINISTER_AFFILIATES,
			'affiliates-users-import',
			array( __CLASS__, 'import' )
		);
		add_action( 'admin_print_styles-' . $page, array( __CLASS__, 'admin_print_styles' ) );
	}

	/**
	 * Import admin screen.
	 */
	public static function import() {
		if ( !current_user_can( AFFILIATES_ADMINISTER_AFFILIATES ) ) {
			wp_die( __( 'Access denied.', AFFILIATES_USERS_PLUGIN_DOMAIN ) );
		}
		echo
			'<h2>' .
			__( 'Affiliates Users - Import', AFFILIATES_USERS_PLUGIN_DOMAIN ) .
			'</h2>';
		echo '<div class="affiliates-users-import">';
		include_once ( AFFILIATES_USERS_ADMIN_LIB . '/import.php' );
		echo '</div>';
	}

	/**
	 * Adds plugin links.
	 *
	 * @param array $links
	 * @param array $links with additional links
	 */
	public static function admin_settings_link( $links ) {
		if ( current_user_can( AFFILIATES_ADMINISTER_AFFILIATES ) ) {
			$links[] = '<a href="' . get_admin_url( null, 'admin.php?page=affiliates-users-import' ) . '">' . __( 'Import', AFFILIATES_USERS_PLUGIN_DOMAIN ) . '</a>';
		}
		return $links;
	}

}
add_action( 'init', array( 'Affiliates_Users_Admin', 'init' ) );

<?php
/**
 * class-affiliates-users-registered.php
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
 * @since affiliates-users 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Auto-add affiliates for new users.
 */
class Affiliates_Users {

	/**
	 * Initialize hooks that handle addition and removal of users and blogs.
	 */
	public static function init() {
		add_action( 'affiliates_before_register_affiliate', array( __CLASS__, 'affiliates_before_register_affiliate' ) );
		add_action( 'user_register', array( __CLASS__, 'user_register' ) );
		add_action( 'add_user_to_blog', array( __CLASS__, 'add_user_to_blog' ), 10, 3 );
	}

	/**
	 * Set flag.
	 *
	 * @param array $userdata
	 */
	public static function affiliates_before_register_affiliate( $userdata ) {
		global $affiliates_users_skip;
		$affiliates_users_skip = true;
	}

	/**
	 * Create an affiliate account for the user if it doesn't have one.
	 *
	 * @deprecated Use Affiliates_Users::maybe_create_affiliate_for_user( $user_id ) instead
	 *
	 * @param WP_User $user
	 *
	 * @return int|boolean new affiliate's ID or false
	 */
	public static function maybe_create_affiliate( $user ) {
		$result = false;
		if ( $user instanceof WP_User ) {
			$result = self::maybe_create_affiliate_for_user( $user->ID );
		}
		return $result;
	}

	/**
	 * Create an affiliate account for the user ID if it doesn't have one.
	 *
	 * @param int $user_id
	 *
	 * @return int|boolean|void new affiliate's ID or false if not added, void if skipped
	 */
	public static function maybe_create_affiliate_for_user( $user_id ) {
		global $affiliates_users_skip;
		if ( isset( $affiliates_users_skip ) && $affiliates_users_skip ) {
			return;
		}
		if ( function_exists( 'affiliates_get_user_affiliate' ) ) {
			$affiliates = affiliates_get_user_affiliate( $user_id );
			if ( empty( $affiliates ) ) {
				if ( $user = get_user_by( 'id', $user_id ) ) {
					$first_name = get_user_meta( $user_id, 'first_name', true );
					$last_name  = get_user_meta( $user_id, 'last_name', true );
					if ( empty( $first_name ) && empty( $last_name ) ) {
						if ( !empty( $user->display_name ) ) {
							$first_name = $user->display_name;
						} else {
							$first_name = $user->user_login;
						}
					}
					$userdata = array(
						'first_name' => $first_name,
						'last_name'  => $last_name,
						'user_email' => $user->user_email,
					);
					return Affiliates_Registration::store_affiliate( $user_id, $userdata );
				}
			}
		}
		return false;
	}

	/**
	 * Avoid sending admin notifications for each new user created while iterating over users during import.
	 *
	 * @param boolean $notify
	 *
	 * @return boolean always false
	 */
	public static function option_aff_notify_admin( $notify, $option ) {
		return false;
	}

	public static function default_option_aff_notify_admin( $default, $option, $passed_default ) {
		return false;
	}

	/**
	 * Creates affiliate accounts for users who don't have one.
	 *
	 * @param int $maximum allows to limit the number of users imported per call, null is unlimited (default)
	 *
	 * @return array of affiliate IDs for newly created affiliate accounts
	 */
	public static function all( $maximum = null ) {

		if ( $maximum !== null ) {
			$maximum = max( 1, intval( $maximum ) );
		}

		// don't iterate over existing affiliates (any, also inactive and invalid to avoid recreating deleted accounts)
		$exclude_user_ids = array();
		$affiliates = affiliates_get_affiliates( false, false );
		foreach ( $affiliates as $affiliate ) {
			$exclude_user_ids[] = affiliates_get_affiliate_user( $affiliate['affiliate_id'] );
		}

		// disable admin notifications during import by returning false for the aff_notify_admin option value
		add_filter( 'option_aff_notify_admin', array( __CLASS__, 'option_aff_notify_admin' ), 10, 2 );
		// this must also be passed if the option doesn't exist, as the default is taken to notify
		add_filter( 'default_option_aff_notify_admin', array( __CLASS__, 'default_option_aff_notify_admin' ), 10, 3 );

		$i = 0;
		$affiliate_ids = array();
		$user_ids = get_users( array( 'fields' => 'ID', 'exclude' => $exclude_user_ids ) );
		foreach( $user_ids as $user_id ) {
			$affiliate_id = self::maybe_create_affiliate_for_user( $user_id );
			if ( $affiliate_id ) {
				$affiliate_ids[] = $affiliate_id;
				$i++;
			}
			if ( ( $maximum !== null ) && ( $i >= $maximum ) ) {
				break;
			}
		}
		return $affiliate_ids;
	}

	/**
	 * Add affiliate account for new user.
	 *
	 * @param int $user_id
	 */
	public static function user_register( $user_id ) {
		// normal site or if multisite must belong to blog
		if ( !is_multisite() || is_user_member_of_blog( $user_id ) ) {
			if ( $user = get_user_by( 'id', $user_id ) ) {
				self::maybe_create_affiliate( $user );
			}
		}
		
	}

	/**
	 * Add affiliate account for user on blog.
	 *
	 * @param int $user_id
	 * @param string $role
	 * @param int $blog_id
	 */
	function add_user_to_blog( $user_id, $role, $blog_id ) {
		if ( is_multisite() ) {
			if ( function_exists( 'wp_cache_switch_to_blog' ) ) {
				wp_cache_switch_to_blog( $blog_id );
			} else {
				switch_to_blog( $blog_id );
				wp_cache_reset();
			}
		}
		if ( $user = get_user_by( 'id', $user_id ) ) {
			self::maybe_create_affiliate( $user );
		}
		if ( is_multisite() ) {
			restore_current_blog();
		}
	}

}
Affiliates_Users::init();

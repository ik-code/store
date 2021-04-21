<?php

/**
 * Fired during plugin deactivation
 *
 * @link       test.com
 * @since      1.0.0
 *
 * @package    Actionable_Goolge_Analytics
 * @subpackage Actionable_Goolge_Analytics/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Actionable_Goolge_Analytics
 * @subpackage Actionable_Goolge_Analytics/includes
 * @author     Chiranjiv Pathak <chiranjiv@tatvic.com>
 */
class Actionable_Google_Analytics_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		if (!current_user_can('activate_plugins'))
			return;
		
			$plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
			$chk_nonce = check_admin_referer("deactivate-plugin_{$plugin}");
			$chk_Settings = unserialize(get_option('aga_options'));
			$purchase_code = unserialize(get_option('aga_purchase_code'));
			if ($chk_nonce && $chk_Settings) {
				if (array_key_exists("ga_email", $chk_Settings)) {
					self::send_email_to_tatvic($chk_Settings['ga_email'], 'inactive',$chk_Settings['ga_auth_token'], $purchase_code['purchase_code']);
				}
			}         
	}
	public static function send_email_to_tatvic($email, $status,$t_tkn, $purchase_code) {
		$url = "http://dev.tatvic.com/leadgen/woocommerce-plugin/store_email/actionable_ga/";
		//set POST variables
		$fields = array(
			"email" => urlencode($email),
			"domain_name" => urlencode(get_site_url()),
			"status" => urlencode($status),
			"tvc_tkn" =>$t_tkn,
			"purchase_code" => $purchase_code
		);
		wp_remote_post($url, array(
			"method" => "POST",
			"timeout" => 1,
			"httpversion" => "1.0",
			"blocking" => false,
			"headers" => array(),
			"body" => $fields
				)
		);
	}

}

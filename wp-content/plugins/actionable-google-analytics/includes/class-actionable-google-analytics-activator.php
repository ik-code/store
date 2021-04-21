<?php

/**
 * Fired during plugin activation
 *
 * @link       tatvic.com
 * @since      1.0.0
 *
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/includes
 * @author     Chiranjiv Pathak <chiranjiv@tatvic.com>
 */
class Actionable_Google_Analytics_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		    set_transient( 'aga-admin-notice-activation', true, 5 );
		    $tvc_free_ee = 'enhanced-e-commerce-for-woocommerce-store/woocommerce-enhanced-ecommerce-google-analytics-integration.php';
			$chk_Settings = unserialize(get_option('aga_options'));
			$purchase_code = unserialize(get_option('aga_purchase_code'));
			if ($chk_Settings)
			{
				if( class_exists('WC_Enhanced_Ecommerce_Google_Analytics') ) {
					deactivate_plugins($tvc_free_ee);
				}
				if (array_key_exists("ga_email", $chk_Settings)) {
					self::send_email_to_tatvic($chk_Settings['ga_email'], 'active', $chk_Settings['ga_auth_token'], $purchase_code['purchase_code']);
				}
				 
			}
			
	}
	
	public static function send_email_to_tatvic($email, $status,$t_tkn, $purchase_code) {
		ob_start();
		$url = "http://dev.tatvic.com/leadgen/woocommerce-plugin/store_email/actionable_ga/";
		//set POST variables
		$fields = array(
			"email" => urlencode($email),
			"domain_name" => urlencode(get_site_url()),
			"status" => urlencode($status),
			"tvc_tkn" =>$t_tkn,
			"purchase_code" => $purchase_code,
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
		ob_flush();
	}

}

<?php
/**
 * The admin-setting functionality of the plugin.
 *
 * @link       tatvic.com
 * @since      1.0.0
 *
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/admin
 */

/**
 * The admin-setting functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/admin
 * @author     Chiranjiv Pathak <chiranjiv@tatvic.com>
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class Actionable_Google_Analytics_Settings {
	
	public static function add_update_settings($settings) {
		if ( !get_option($settings)) {
			$aga_options = array();
			foreach ($_POST as $key => $value) {
				if(!isset($_POST[$key])){
					$_POST[$key] = '';
				}
				if(isset($_POST[$key])) {
					$aga_options[$key] = $_POST[$key];
				}
			}
				add_option( $settings, serialize( $aga_options ) );
		}
		else {
			$flag = self::check_email_exists('aga_options');
			if ($flag == 1) {
				$get_aga_settings = unserialize(get_option($settings));
				foreach ($get_aga_settings as $key => $value) {
					if(!isset($_POST[$key])){
						$_POST[$key] = '';
					}
					if( $_POST[$key] != $value ) {
						$get_aga_settings[$key] =  $_POST[$key];
					}
					
				}
				foreach($_POST as $key=>$value){
					if(!array_key_exists($key,$get_aga_settings)){
						$get_aga_settings[$key] =  $value;
					}
				}
					update_option($settings, serialize( $get_aga_settings ));
			}
		}
		if($settings != 'aga_purchase_code'){
			self::admin_notice__success();
		}
		
	}
	
	private static function check_email_exists($settings) {
		$get_aga_settings = unserialize(get_option($settings))['ga_email'];
		if($get_aga_settings || isset($_POST['ga_email'])) {
			return true;
		}
		else {
			self::admin_notice__error();
		}
		
	}
	
	private static function admin_notice__error() {
		$class = 'notice notice-error';
		$message = __( 'Please Enter you Email ID.', 'sample-text-domain' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
		
	}
	
	private static function admin_notice__success() {
		$class = 'notice notice-success';
		$message = __( 'Your settings have been saved.', 'sample-text-domain' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
		
	}
	
}

?>
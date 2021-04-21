<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       tatvic.com
 * @since      1.0.0
 *
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/admin
 * @author     Chiranjiv Pathak <chiranjiv@tatvic.com>
 */

 class Actionable_Google_Analytics_Envato_Api {
	
	private $plugin_name;
	
	private $plugin_version;

	private $api_key;
	
	private $curl_url;
	
	protected $code;
	
	public function __construct() {
		$this->plugin_name = 'actionable-google-analytics';
		$this->plugin_version = '3.1';
		$this->api_key = "OlHhRm7IGTsQDMX8eootrfiqUGFHKapV";
		$this->curl_url= "https://api.envato.com/v3/market/author/sale?code=";
	}
	
	public function api_validation($code){
		$code = trim($code);
		$response = '';
		try{
			if (!preg_match("/^([a-z0-9]{8})[-](([a-z0-9]{4})[-]){3}([a-z0-9]{12})$/im", $code)){
				throw new Exception("Invalid code");
			}
			else{
				$response = $this->call_cURL($code);
				if($response == true){
					require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/swalmessage.php';
				}
			}
		}
		catch (Exception $e) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/swalmessage.php';
		}
	}
	
	public function call_cURL($code){
		$ch = curl_init();
		curl_setopt_array($ch, array(
		CURLOPT_URL => $this->curl_url."{$code}",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 20,
		CURLOPT_HTTPHEADER => array(
			"Authorization: Bearer ".$this->api_key,
			"content-type: application/json",
			)
		));
	
		$response = curl_exec($ch);
		
		if (curl_errno($ch) > 0){
			throw new Exception("Failed to query Envato API: " . curl_error($ch));
		}
		
		$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if ($responseCode === 404) {
			throw new Exception("The purchase code was invalid");
		}
		if ($responseCode !== 200) {
			throw new Exception("Failed to validate code due to an error: HTTP {$responseCode}");
		}
		$body = json_decode($response);
		
		if ($body->item->id == 9899552) {
			Actionable_Google_Analytics_Settings::add_update_settings('aga_purchase_code');
			return true;
		}
		else{
			return false;
		}
	}
}
?>
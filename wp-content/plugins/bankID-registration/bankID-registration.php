<?php
/*
  Plugin Name: Registration Bank Id
  Version: 1.0
  Author: Halo-lab
  Author URI: https://halo-lab.com/
  Description: Registration and authorization in WordPress using the API https://zignsec.com/
 */

// don't load directly
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
if ( is_admin() ) {
	require_once plugin_dir_path(__FILE__) . 'admin/class-bankid-registration-admin.php';
}

$enable_test_api = get_option('bankid-registration_test_api');
$authorization_key = get_option('bankid-registration_key');
$api_version = 'v2';

if($enable_test_api){
	$bankID_api_url = 'https://test.zignsec.com';
}else{
	$bankID_api_url = 'https://api.zignsec.com';
}

function is_user_role($role, $user_id = null) {
	$user = is_numeric($user_id) ? get_userdata($user_id) : wp_get_current_user();
	if (!$user)
		return false;
	return in_array($role, (array) $user->roles);
}
function custom_login_function() {
	if (isset($_POST['submit'])) {
		$personal_number = $_POST['personal_number'];
		if(!empty($personal_number) ){
			$personal_info = get_user_data($personal_number);
		}
	}
	if(!$_POST['personal_number']){
		get_login_form(
			$_POST['personal_number'] ? $_POST['personal_number'] : ''
		);
	}
}
function custom_registration_function() {

	if (isset($_POST['submit'])) {
		$personal_number = $_POST['personal_number'];
		$phone_number = $_POST['phone_number'];
		$personal_email = $_POST['personal_email'];
		$company_name = $_POST['company_name'] ? $_POST['company_name'] : '';
		$copnamy_number = $_POST['copnamy_number'] ? $_POST['copnamy_number'] : '';

		if(!checkUserInDb($personal_number, $personal_email, $phone_number)){
			get_registration_page( $personal_number, true );
		}else{
			if(!empty($personal_number) ){
				$personal_info = get_user_data($personal_number, $personal_email, $phone_number,$company_name,$copnamy_number);
			}
		}
	}
	if(!$_POST['personal_number']){
		get_registration_page(
			$_POST['personal_number'] ? $_POST['personal_number'] : ''
		);
	}
}
function custom_login_page_function() {
	set_query_var( 'get_page', 'login_page' );
//    if (isset($_POST['submit'])) {
//        $personal_number = $_POST['personal_number'];
//        $phone_number = $_POST['phone_number'];
//        $personal_email = $_POST['personal_email'];
//        if(!empty($personal_number) ){
//            $personal_info = get_user_data($personal_number, $personal_email, $phone_number);
//        }
//    }
//    if(!$_POST['personal_number']){
//        get_login_page(
//            $_POST['personal_number'] ? $_POST['personal_number'] : ''
//        );
//    }
	$personal_number = $_COOKIE['BankID'];
	if (!$personal_number) {
		wp_safe_redirect( '/' );
	} else {
		setcookie('BankID', '', (time()-60), COOKIEPATH, COOKIE_DOMAIN);
		get_user_data($personal_number);
	}
}

function get_login_form( $personal_number ) {
	set_query_var( 'personal_number', $personal_number );
	if ( file_exists( get_theme_file_path('bankID/login.php')) ) {
		load_template(get_theme_file_path('bankID/login.php'));
	}else{
		load_template(dirname( __FILE__ ).'/templates/bankID/login.php');
	}
}

function get_registration_page( $personal_number, $error = false ) {
	if ( is_user_logged_in() && !is_admin() ) {
		wp_safe_redirect( get_permalink( wc_get_page_id( 'shop' ) ) );
		exit;
	}

	set_query_var( 'personal_number', $personal_number );
	set_query_var( 'error', $error );

	if ( file_exists( get_theme_file_path('bankID/registration-page.php')) ) {
		load_template(get_theme_file_path('bankID/registration-page.php'));
	}else{
		load_template(dirname( __FILE__ ).'/templates/bankID/registration-page.php');
	}
}

function get_login_page( $personal_number ) {
	if ( is_user_logged_in() && !is_admin() ) {
		wp_safe_redirect( get_permalink( wc_get_page_id( 'shop' ) ) );
		exit;
	}

	set_query_var( 'personal_number', $personal_number );

	if ( file_exists( get_theme_file_path('bankID/login-page.php')) ) {
		load_template(get_theme_file_path('bankID/login-page.php'));
	}else{
		load_template(dirname( __FILE__ ).'/templates/bankID/login-page.php');
	}
}

// Work if user is login
add_action( 'wp_ajax_get_user_data', 'get_user_data' );
// Work if user is not login
add_action("wp_ajax_nopriv_get_user_data", "get_user_data");

function get_user_data($personal_number, $personal_email="", $phone_number="",$company_name="",$copnamy_number=""){
	global $authorization_key, $api_version, $bankID_api_url;
	$url = $bankID_api_url.'/'.$api_version.'/eid/sbid-another';
	$args = array(
		'headers' => array('Authorization' => $authorization_key),
		'body'    => array( 'CountryCode' => 'SE', 'IdentityNumber' => $personal_number , 'lookupPersonAddress' => 'true','layout' => 'Layout4')
	);

	$response = wp_remote_post( $url, $args );

	if ( is_wp_error( $response ) ) {
		$error_message = $response->get_error_message();
		echo $error_message;
	} else {
		$person = json_decode($response['body']);
		authorization_method($person, $personal_number, $personal_email, $phone_number,$company_name,$copnamy_number);
	}
}

function authorization_method($url_redirect, $personal_number, $personal_email, $phone_number,$company_name,$copnamy_number){
	$tocen = autostart_tocen($personal_number);

	set_query_var( 'tocen', $tocen );
	set_query_var( 'personal_number', $personal_number );
	set_query_var( 'personal_email', $personal_email );
	set_query_var( 'phone_number', $phone_number );
	set_query_var( 'url_redirect', $url_redirect->redirect_url );
	set_query_var( 'redirect_id', $url_redirect->id );
	set_query_var( 'company_name', $company_name );
	set_query_var( 'copnamy_number', $copnamy_number );

	if ( file_exists( get_theme_file_path('bankID/bankID-button.php')) ) {
		load_template(get_theme_file_path('bankID/bankID-button.php'));
	}else{
		load_template(dirname( __FILE__ ).'/templates/bankID/bankID-button.php');
	}
}

function autostart_tocen($personal_number){
	global $authorization_key, $api_version, $bankID_api_url;
	$url = $bankID_api_url.'/'.$api_version.'/BankIDSE/Authenticate';
	$args = array(
		'headers' => array('Content-Type' => 'application/json; charset=UTF-8','Authorization' => $authorization_key,'PersonalNumber' => $personal_number),
		'body' => "{'lookupPersonAddress':true}"
	);
	$response = wp_remote_post( $url, $args );


	$response_decode = json_decode($response['body']);
	return  $response_decode;
}

add_action( 'wp_ajax_getAuthorization', 'getAuthorization' );
add_action("wp_ajax_nopriv_getAuthorization", "getAuthorization");

function getAuthorization() {
	global $authorization_key, $api_version, $bankID_api_url;
	$personal_number = $_POST['personal_number'] ? $_POST['personal_number'] : "";
	$url = $bankID_api_url.'/'.$api_version.'/BankIDSE/Authenticate';

	$args = array(
		'headers' => array('Content-Type' => 'application/json; charset=UTF-8','Authorization' => $authorization_key),
		'body' => "{'PersonalNumber': $personal_number,'lookupPersonAddress':true, 'layout' : 'Layout4'}"
	);
	$response = wp_remote_post( $url, $args);
	wp_send_json($response['body']);
}

// Work if user is login
add_action( 'wp_ajax_getProgressStatus', 'getProgressStatus' );
// Work if user is not login
add_action("wp_ajax_nopriv_getProgressStatus", "getProgressStatus");

function getProgressStatus(){
	global $authorization_key, $api_version, $bankID_api_url;
	$orderRef = $_POST['orderRef'] ? $_POST['orderRef'] : "";

	$url = $bankID_api_url.'/'.$api_version.'/BankIDSE/Collect';

	$args = array(
		'headers' => array('Content-Type' => 'application/json; charset=UTF-8','Authorization' => $authorization_key),
		'body' => array('orderRef' => $orderRef, 'layout' => 'Layout4')
	);

	$response = wp_remote_get( $url, $args);

	$response_decode = json_decode($response['body']);

	wp_send_json($response['body']);
}

// Work if user is login
add_action( 'wp_ajax_getProgressStatusAnother', 'getProgressStatusAnother' );
// Work if user is not login
add_action("wp_ajax_nopriv_getProgressStatusAnother", "getProgressStatusAnother");

function getProgressStatusAnother(){
	global $authorization_key, $api_version, $bankID_api_url;
	$redirect_id = $_POST['redirect_id'] ? $_POST['redirect_id'] : "";

	$url = $bankID_api_url.'/'.$api_version.'/eid/'.$redirect_id;

	$args = array(
		'headers' => array('Content-Type' => 'application/json; charset=UTF-8', 'Authorization' => $authorization_key),
		'body' => array('layout' => 'Layout4')
	);
	$response = wp_remote_get( $url, $args);

	$response_decode = json_decode($response['body']);

	wp_send_json($response['body']);
}

// Work if user is login
add_action( 'wp_ajax_checkUserInDb', 'checkUserInDb' );
// Work if user is not login
add_action("wp_ajax_nopriv_checkUserInDb", "checkUserInDb");
function checkUserInDb($personal_number, $personal_email, $phone_number){
	global $wpdb;
	$customer_id = $wpdb->get_var($wpdb->prepare("
        SELECT user_id 
        FROM $wpdb->usermeta 
        WHERE (meta_key = 'bankID'
        AND meta_value = '%s')
        OR (meta_key = 'billing_phone'
        AND meta_value = '%s')
        ", array($personal_number,$phone_number)));
	if(email_exists($personal_email) || $customer_id){
		return false;
	}
	return true;
}

// Work if user is login
add_action( 'wp_ajax_registerBankIdUser', 'registerBankIdUser' );
// Work if user is not login
add_action("wp_ajax_nopriv_registerBankIdUser", "registerBankIdUser");
function registerBankIdUser(){
	$user_info = $_POST['user_info'];
	$personal_email = $_POST['personal_email'];
	$phone_number = $_POST['phone_number'];
	$company_name = $_POST['company_name'];
	$copnamy_number = $_POST['copnamy_number'];
	$user_role = $_POST['company_name'] != '' ? 'business' : 'subscriber';

	$result_validation = validation_bank_id($_POST['personal_number'], $user_info['PersonalNumber']);
	if($result_validation === false){
		wp_send_json(array('error_number' => 'An error has occurred, try again.'));
	}

	$fullname = $user_info['FullName'] ? $user_info['FullName'] : $user_info['FirstName'].' '.$user_info['LastName'];
	$userdata = array(
		'user_login'    =>  str_replace(' ', '', $fullname),
		'user_email'    =>  $personal_email,
		'user_pass'     =>  preg_replace('/[^0-9]/', '', $user_info['PersonalNumber']),
		'first_name'    =>  $user_info['FirstName'],
		'last_name'     =>  $user_info['LastName'],
		'role'          =>  $user_role
	);

	$user_id = wp_insert_user( $userdata );

	if(!empty($user_id)){
		update_user_meta( $user_id, 'billing_first_name', $user_info['FirstName'] );
		update_user_meta( $user_id, 'billing_last_name', $user_info['LastName'] );

		update_user_meta( $user_id, 'billing_phone', $phone_number );
		update_user_meta( $user_id, 'billing_address_1', $user_info['Address'] );
		update_user_meta( $user_id, 'billing_address_2', $user_info['Address2'] );
		update_user_meta( $user_id, 'billing_city', $user_info['City'] );
		update_user_meta( $user_id, 'billing_country', 'SE' );
		update_user_meta( $user_id, 'billing_state', $user_info['CountryCode'] );
		update_user_meta( $user_id, 'billing_postcode', $user_info['PostalCode'] );
		update_user_meta( $user_id, 'billing_email', $personal_email );

		update_user_meta( $user_id, 'billing_company', $company_name );
		update_user_meta( $user_id, 'company_number',  $user_info['PersonalNumber']  );


		update_user_meta( $user_id, 'shipping_phone', $phone_number );
		update_user_meta( $user_id, 'shipping_address_1', $user_info['Address'] );
		update_user_meta( $user_id, 'shipping_address_2', $user_info['Address2'] );
		update_user_meta( $user_id, 'shipping_city', $user_info['City'] );
		update_user_meta( $user_id, 'shipping_country', 'SE' );
		update_user_meta( $user_id, 'shipping_state', $user_info['CountryCode'] );
		update_user_meta( $user_id, 'shipping_postcode', $user_info['PostalCode'] );
		update_user_meta( $user_id, 'shipping_email', $personal_email );
		update_user_meta( $user_id, 'shipping_first_name', $user_info['FirstName'] );
		update_user_meta( $user_id, 'shipping_last_name', $user_info['LastName'] );
		update_user_meta( $user_id, 'shipping_company', $company_name );

		update_user_meta( $user_id, 'bankID',  $user_info['PersonalNumber'] );
	}

	// send_email_user_register($personal_email, $user_id);

	autorizationBankIdUser(str_replace(' ', '', $fullname), $user_info['PersonalNumber']);
	wp_die('success');
}
function send_email_user_register($email, $user_id){
	require( '/var/www/sites/dev.clicknstore.se/wp-load.php' );

	add_filter( 'wp_mail_content_type', function($content_type){
		return "text/html";
	});

	$subject = "[Click N Store] Referral";
	$pname = get_option( 'aff_pname', AFFILIATES_PNAME );
	$email_content = "<p>Your referral link: " . home_url() .'?'. $pname . '=' . affiliates_get_user_affiliate($user_id)[0] . "</p>";

	$send_status = wp_mail( $email, $subject, $email_content);
}


function validation_bank_id($personal_number, $personal_number_bank_id) {
	$personal_number_from_form = preg_replace('/[^0-9]/', '', $personal_number);
	$personal_number_from_bank_id = preg_replace('/[^0-9]/', '', $personal_number_bank_id);
	$result_compare = strpos($personal_number_from_bank_id, $personal_number_from_form);

	if($result_compare === false){
		return false;
	}
	return true;
}

// Work if user is login
add_action( 'wp_ajax_loginBankIdUser', 'loginBankIdUser' );
// Work if user is not login
add_action("wp_ajax_nopriv_loginBankIdUser", "loginBankIdUser");
function loginBankIdUser(){
	$user_info = $_POST['user_info'];
	$fullname = $user_info['FullName'] ? $user_info['FullName'] : $user_info['FirstName'].' '.$user_info['LastName'];
	$personal_number_bank_id = preg_replace('/[^0-9]/', '', $user_info['PersonalNumber']);

	autorizationBankIdUser(str_replace(' ', '', $fullname), $personal_number_bank_id);
	wp_die('success');
}

function autorizationBankIdUser($username, $password){
	$auth = wp_authenticate($username, $password);

	if ( is_wp_error( $auth ) ) {
		$error_string = $auth->get_error_message();
		echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
	} else {
		wp_set_auth_cookie( $auth->ID );
		wp_die('authenticate');
	}
}

function complete_registration($username, $password, $email, $first_name, $last_name) {
	global $reg_errors, $username, $password, $email, $first_name, $last_name;

	if ( count($reg_errors->get_error_messages()) < 1 ) {

		$userdata = array(
			'user_login'	=> 	str_replace(' ', '', $username),
			'user_email' 	=> 	$email,
			'user_pass' 	=> 	$password,
			'first_name' 	=> 	$first_name,
			'last_name' 	=> 	$last_name,
		);

		$user = wp_insert_user( $userdata );
		echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';
	}
}

add_shortcode('bank_id_login', 'custom_login_shortcode');

function custom_login_shortcode() {
	ob_start();
	custom_login_function();
	return ob_get_clean();
}

add_shortcode('bank_id_registration', 'custom_registration_shortcode');

function custom_registration_shortcode() {
	ob_start();
	custom_registration_function();
	return ob_get_clean();
}
add_shortcode('bank_id_login_page', 'custom_login_page_shortcode');

function custom_login_page_shortcode() {
	ob_start();
	custom_login_page_function();
	return ob_get_clean();
}


// Work if user is login
add_action( 'wp_ajax_check_user', 'check_user' );
// Work if user is not login
add_action("wp_ajax_nopriv_check_user", "check_user");
function check_user(){
	$personalNumber = $_POST['personalNumber'];
	$user = get_users(array('meta_key' => 'bankID', 'meta_value' => $personalNumber));

	setcookie('BankID', $personalNumber, (time()+60), COOKIEPATH, COOKIE_DOMAIN);
	return wp_send_json($user[0]);
}

// Add field bankid to user  
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
function extra_user_profile_fields( $user ) {
	if (is_user_role('customer', $user->ID)) {?>
        <h3><?php _e("Extra profile information", "blank"); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="bankID"><?php _e("BankID"); ?></label></th>
                <td>
                    <input type="text" name="bankID" id="bankID" value="<?php echo esc_attr( get_the_author_meta( 'bankID', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your BankID."); ?></span>
                </td>
            </tr>
        </table>
		<?php
	} elseif(is_user_role('business', $user->ID)) {?>
        <h3><?php _e("Extra profile information", "blank"); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="company_number"><?php _e("Company number"); ?></label></th>
                <td>
                    <input type="text" name="company_number" id="company_number" value="<?php echo esc_attr( get_the_author_meta( 'bankID', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your Company number."); ?></span>
                </td>
            </tr>
        </table>
	<?php }
}

add_action( 'personal_options_update', 'save_customer_meta_fields' );
add_action( 'edit_user_profile_update', 'save_customer_meta_fields' );
function save_customer_meta_fields( $user_id ) {

	if ($bank_id = filter_var($_POST['bankID'], FILTER_SANITIZE_STRIPPED)) {
		update_user_meta( $user_id, 'bankID',  $bank_id );
	} else {
		update_user_meta( $user_id, 'bankID',  '' );
	}
	if ($company_number = filter_var($_POST['company_number'], FILTER_SANITIZE_STRIPPED)) {
		update_user_meta( $user_id, 'company_number',  $company_number );
	} else {
		update_user_meta( $user_id, 'company_number',  '' );
	}
}
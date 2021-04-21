<?php
define( 'THEME_URI', get_stylesheet_directory_uri() );
define( 'THEME_PATH', get_stylesheet_directory() );

require_once dirname( __FILE__ ) . '/functions-noke.php';
show_admin_bar( false );

// Add optein page
if( function_exists('acf_add_options_page') ) {
	$parent = acf_add_options_page(array(
		'page_title' 	=> __('Theme General Settings', 'my_text_domain'),
		'menu_title' 	=> __('Theme Settings', 'my_text_domain'),
	));

	// add sub page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Social Settings',
		'menu_title' 	=> 'Social',
		'parent_slug' 	=> $parent['menu_slug'],
	));
	// add sub page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Featured Settings',
		'menu_title' 	=> 'Featured',
		'parent_slug' 	=> $parent['menu_slug'],
	));
	// add sub page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Popup',
		'menu_title' 	=> 'Popup',
		'parent_slug' 	=> $parent['menu_slug'],
	));
	// add sub page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Insurance',
		'menu_title' 	=> 'Insurance',
		'parent_slug' 	=> $parent['menu_slug'],
	));
}


// Add mime type
add_filter( 'upload_mimes', 'upload_allow_types' );
function upload_allow_types( $mimes ) {

	$mimes['svg']  = 'text/plain';
	$mimes['svg']  = 'image/svg+xml';
	$mimes['webp']  = 'image/webp';

	return $mimes;
}

/* --------------------------------------------------------------------------
 * Отключаем Emoji
 * -------------------------------------------------------------------------- */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2.2.1/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}

	return $urls;
}
//dns-prefetch
add_filter( 'emoji_svg_url', '__return_false' );
/* --------------------------------------------------------------------------
 * Отключаем Emoji
 * -------------------------------------------------------------------------- */

/* --------------------------------------------------------------------------
*  Удаляем опасные методы работы XML-RPC Pingback
* -------------------------------------------------------------------------- */
add_filter( 'xmlrpc_methods', 'sheensay_block_xmlrpc_attacks' );

function sheensay_block_xmlrpc_attacks( $methods ) {
	unset( $methods['pingback.ping'] );
	unset( $methods['pingback.extensions.getPingbacks'] );
	return $methods;
}

add_filter( 'wp_headers', 'sheensay_remove_x_pingback_header' );

function sheensay_remove_x_pingback_header( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}

// Disable Styles
function custom_dequeue() {
	wp_dequeue_style('storefront-woocommerce-style');
	wp_dequeue_style('kco');
}
add_action( 'wp_enqueue_scripts', 'custom_dequeue', 9999 );
add_action( 'wp_head', 'custom_dequeue', 9999 );

// Удаляем код meta name="generator"
remove_action( 'wp_head', 'wp_generator' );

// Удаляем link rel="canonical" // Этот тег лучше выводить с помощью плагина Yoast SEO или All In One SEO Pack
remove_action( 'wp_head', 'rel_canonical' );

// Удаляем link rel="shortlink" - короткую ссылку на текущую страницу
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Удаляем link rel="EditURI" type="application/rsd+xml" title="RSD"
// Используется для сервиса Really Simple Discovery
remove_action( 'wp_head', 'rsd_link' );

// Удаляем link rel="wlwmanifest" type="application/wlwmanifest+xml"
// Используется Windows Live Writer
remove_action( 'wp_head', 'wlwmanifest_link' );

// Удаляем различные ссылки link rel
// на главную страницу
remove_action( 'wp_head', 'index_rel_link' );
// на первую запись
remove_action( 'wp_head', 'start_post_rel_link', 10 );
// на предыдущую запись
remove_action( 'wp_head', 'parent_post_rel_link', 10 );
// на следующую запись
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10 );

// Удаляем связь с родительской записью
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

// Удаляем вывод /feed/
remove_action( 'wp_head', 'feed_links', 2 );
// Удаляем вывод /feed/ для записей, категорий, тегов и подобного
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Удаляем ненужный css плагина WP-PageNavi
remove_action( 'wp_head', 'pagenavi_css' );

/* --------------------------------------------------------------------------
*  pingback, canonical, meta generator, wlwmanifest, EditURI, shortlink, prev,
*  next, RSS, feed, profile из заголовков head
* -------------------------------------------------------------------------- */

function wpse_enqueue_datepicker() {
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
	wp_enqueue_style( 'jquery-ui' );
}

add_action( 'wp_enqueue_scripts', 'wpse_enqueue_datepicker' );

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

function theme_name_scripts() {

	wp_enqueue_style( 'fonts-style', 'https://fonts.googleapis.com/css?family=Saira+Semi+Condensed:300,400,500,700|Rubik:400,500' );
	wp_enqueue_style( 'select2-style', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css' );
	wp_enqueue_style( 'swiper-style', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css' );
	wp_enqueue_style( 'jquery-ui-style', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css' );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );

	wp_enqueue_script( 'select2-clicknstore', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'swiper-clicknstore', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'jquery-ui-clicknstore', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'touch-punch-clicknstore', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js', array('jquery'), '1.0.0', true );


	wp_enqueue_script( 'mask-clicknstore', get_stylesheet_directory_uri() . '/javascript/mask.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'index-clicknstore', get_stylesheet_directory_uri() . '/javascript/index.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'index-googleMapInitialize', get_stylesheet_directory_uri() . '/javascript/googleMapInitialize.js', array('jquery'), '1.0.0', true );

	if ( ! is_checkout() ) {
		wp_enqueue_script( 'maps-clicknstore', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDhAotapdCm0RtfVmHLL5bTnG4E56p0F8A&amp;callback=initMap', array( 'jquery' ), '1.0.0', true );
	}

	if ( is_checkout() ) {
		wp_enqueue_script( 'snn-clicknstore', get_stylesheet_directory_uri() . '/javascript/validate_snn.js' , array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script('kco-trigger-clicknstore', get_stylesheet_directory_uri() . '/javascript/kco-trigger.js' , array( 'jquery' ), '1.0.0', true );
	}
}

function add_menu_link_class( $atts, $item, $args ) {
	if ( property_exists( $args, 'link_class' ) ) {
		$atts['class'] = $args->link_class;
	}

	return $atts;
}

add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );

function cf7_add_custom_class( $error ) {
	$error = str_replace( "class=\"", "class=\"MyClass1 MyClass2 ", $error );

	return $error;
}

add_filter( 'wpcf7_validation_error', 'cf7_add_custom_class' );

// Woocommerce
/**
 * @snippet       Hide Edit Address Tab @ My Account
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=21253
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.5.1
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_filter( 'woocommerce_account_menu_items', 'bbloomer_remove_address_my_account', 999 );

function bbloomer_remove_address_my_account( $items ) {
	unset( $items['dashboard'] );
	unset( $items['downloads'] );
	unset( $items['edit-address'] );
	unset( $items['orders'] );
	unset( $items['customer-logout'] );

	return $items;
}

function app_output_buffer() {
	ob_start();
}

add_action( 'init', 'app_output_buffer' );

/**
 * @snippet       Hide Homepage Title - Storefront Default Page Template
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=79966
 * @author        Rodolfo Melogli
 * @compatible    Woo 3.5.3
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_action( 'wp', 'bbloomer_storefront_remove_title_from_home_default_template' );

function bbloomer_storefront_remove_title_from_home_default_template() {
	if ( is_account_page() ) {
		remove_action( 'storefront_page', 'storefront_page_header', 10 );
	}
}

add_action( 'woocommerce_save_account_details', 'woocommerce_save_billing_address' );
function woocommerce_save_billing_address( $user_id ) {
	$user_info = $_POST;
	if ( ! empty( $user_id ) ) {

		update_user_meta( $user_id, 'billing_first_name', $user_info['account_first_name'] );
		update_user_meta( $user_id, 'billing_last_name', $user_info['account_last_name'] );
		update_user_meta( $user_id, 'billing_company', $user_info['company_name'] );
		update_user_meta( $user_id, 'company_number', $user_info['company_number'] );
		update_user_meta( $user_id, 'billing_city', $user_info['account_city'] );
		update_user_meta( $user_id, 'billing_postcode', $user_info['account_postcode'] );
		update_user_meta( $user_id, 'billing_address_1', $user_info['account_address'] );
		update_user_meta( $user_id, 'billing_phone', $user_info['account_phone'] );
		update_user_meta( $user_id, 'billing_email', $user_info['account_email'] );


		update_user_meta( $user_id, 'shipping_first_name', $user_info['account_first_name'] );
		update_user_meta( $user_id, 'shipping_last_name', $user_info['account_last_name'] );
		update_user_meta( $user_id, 'shipping_company', $user_info['company_name'] );
		update_user_meta( $user_id, 'shipping_city', $user_info['account_city'] );
		update_user_meta( $user_id, 'shipping_postcode', $user_info['account_postcode'] );
		update_user_meta( $user_id, 'shipping_address_1', $user_info['account_address'] );
		update_user_meta( $user_id, 'shipping_phone', $user_info['account_phone'] );
		update_user_meta( $user_id, 'shipping_email', $user_info['account_email'] );
	}
}

/**
 * Apply a different tax rate based on the user role.
 */
function wc_diff_rate_for_user( $tax_class, $product ) {
	$zero_tax = true;
	if ( is_user_logged_in() ){
		$user_id = get_current_user_id();
		$user_data = get_userdata($user_id);
		$zero_tax = !in_array( 'business', $user_data->roles );
	} elseif (isset($_POST['post_data']) && !empty($_POST['post_data'])){
		parse_str($_POST['post_data'], $data);
		if ( !empty($data['user_role']) && ($data['user_role'] == 'business')){
			$zero_tax = false;
		}
	} elseif (!empty($_POST['user_role']) && ($_POST['user_role'] == 'business')){
		$zero_tax = false;
	}

	if ( $zero_tax ) {
		$tax_class = 'Zero Rate';
	}

	$_COOKIE['zero_tax_rate'] = $zero_tax ? 1 : 0;

	return $tax_class;
}
add_filter( 'woocommerce_product_tax_class', 'wc_diff_rate_for_user', 1, 2 );
add_filter( 'woocommerce_product_get_tax_class', 'wc_diff_rate_for_user', 10, 2 );
add_filter( 'woocommerce_product_variation_get_tax_class', 'wc_diff_rate_for_user', 10, 2 );


function filter_woocommerce_calc_tax( $taxes, $price, $rates, $price_includes_tax, $suppress_rounding ) {
	if ( is_user_logged_in() ) {
		$user_id = get_current_user_id();
		$user_data = get_userdata($user_id);
		if ( !in_array( 'business', $user_data->roles ) ) {
			$taxes = array();
		}
	} elseif ( isset( $_COOKIE['zero_tax_rate'] ) && $_COOKIE['zero_tax_rate'] ) {
		$taxes = array();
	}

	return $taxes;
}
// add the filter
add_filter( 'woocommerce_calc_tax', 'filter_woocommerce_calc_tax', 10, 5 );

//add_action('template_redirect', 'woo_redirect_checkout');
function woo_redirect_checkout() {
	global $woocommerce;
	if(!is_user_logged_in() && (is_cart() || is_checkout() || is_account_page())){
		$registration_page = get_permalink( 38 );
		wp_safe_redirect($registration_page);
		exit;
	}else if(is_cart() && WC()->cart->cart_contents_count > 0){
		$checkout_url = $woocommerce->cart->get_checkout_url();
		wp_safe_redirect($checkout_url);
		exit;
	}else if(is_cart() && WC()->cart->cart_contents_count == 0){
		wp_safe_redirect(get_permalink( wc_get_page_id( 'shop' ) ));
		exit;
	}
	else if($_SERVER['REQUEST_URI'] == "/my-account/" || strpos($_SERVER['REQUEST_URI'], "view-subscription")){
		wp_safe_redirect('/my-account/subscriptions/');
		exit;
	}
}

add_action( 'woocommerce_add_to_cart', 'woocommerce_add_to_cart_time', 1, 1 );
function woocommerce_add_to_cart_time( ){
	$add_to_catr_time = microtime(true)*1000;
	setcookie('add_to_catr_time', $add_to_catr_time, time()+1800, "/");
}

add_role(
	'business',
	__( 'Business' ),
	array(
		'read' => true,
	)
);


add_action( 'woocommerce_after_checkout_billing_form', 'bbloomer_checkout_insurance', 20 );

function bbloomer_checkout_insurance() {
	$radio = WC()->session->get( 'insurance' );

	if(!$radio){
		WC()->session->set('insurance', 'radio_size_0' );
	}

	echo '<div id="checkout-radio" class="validate-required">';
	echo '<h3 class="booking-final__insurance-title">Försäkring</h3>';

	echo '<select class="booking-final__select-insurance select-required" name="insurance" required>';
	foreach (get_field('insurance', 'option') as $key => $insurance) {
		$selected = $radio === "radio_size_".$key ? "selected" : "";
		echo '<option value="radio_size_'.$key.'" data-value="'.$insurance["value"].'" data-price="'.$insurance["price"].' KR/MÅN" ' . $selected . '> </option>';
	}
	echo '</select>';
	// echo '<div class="booking-final__tooltip-popup">Försäkringsskydd av förvarad egendom är obligatorisk för alla kunder. Detta medför en trygghet för er som kund och ger ett skydd som en normal hemförsäkring oftast inte täcker.Beräkna värdet på det du skall förvara utifrån nyvärde. Vad är värdet om du skulle införskaffa allting nytt idag?</div>';
	echo '</div>';

}

add_action( 'woocommerce_cart_calculate_fees', 'bbloomer_checkout_insurance_fee', 20, 1 );

function bbloomer_checkout_insurance_fee( $cart ) {

	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

	$radio = str_replace('radio_size_', '', WC()->session->get( 'insurance' ));
	$insurance = get_field('insurance', 'option');

	$cart->add_fee( __('Försäkring', 'woocommerce'), $insurance[$radio]['price'], false, 'zero-rate' );
}

add_action( 'wp_footer', 'bbloomer_checkout_insurance_refresh' );

function bbloomer_checkout_insurance_refresh() {
	if ( ! is_checkout() ) return;
	?>
    <script type="text/javascript">
        jQuery( function($){
            $('form.checkout').on('change', '[name=insurance]', function(e){
                e.preventDefault();
                var p = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: wc_checkout_params.ajax_url,
                    data: {
                        'action': 'woo_get_ajax_data',
                        'radio': p,
                    },
                    success: function (result) {
                        $('body').trigger('update_checkout');
                    }
                });
            });
        });
    </script>
	<?php
}

add_action( 'wp_ajax_woo_get_ajax_data', 'bbloomer_checkout_insurance_set_session' );
add_action( 'wp_ajax_nopriv_woo_get_ajax_data', 'bbloomer_checkout_insurance_set_session' );

function bbloomer_checkout_insurance_set_session() {
	if ( isset($_POST['radio']) ){
		$radio = sanitize_key( $_POST['radio'] );
		WC()->session->set('insurance', $radio );
		echo json_encode( $radio );
	}
	die();
}

// Clear Cart
// Work if user is login
add_action( 'wp_ajax_ajax_clear_cart', 'ajax_clear_cart' );
// Work if user is not login
add_action("wp_ajax_nopriv_ajax_clear_cart", "ajax_clear_cart");
function ajax_clear_cart(){
	global $woocommerce;
	$woocommerce->cart->empty_cart();
	setcookie('add_to_catr_time', null, -1, '/');
}


function noke_account_menu_items( $items ) {
	$items['noke'] = __( 'How to start with NOKE', 'woocommerce' );
	return $items;
}
add_filter( 'woocommerce_account_menu_items', 'noke_account_menu_items', 10, 1 );

function noke_add_my_account_endpoint() {
	add_rewrite_endpoint( 'noke', EP_PAGES );
}

add_action( 'init', 'noke_add_my_account_endpoint' );

function noke_endpoint_content() {
	load_template(get_theme_file_path('inc/content-noke.php'));
}
add_action( 'woocommerce_account_noke_endpoint', 'noke_endpoint_content' );


function iconic_is_endpoint( $endpoint = false ) {
	global $wp_query;
	if( !$wp_query )
		return false;
	return isset( $wp_query->query[ $endpoint ] );
}

add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_hours' );
function keep_me_logged_in_for_1_hours( $expirein ) {
	return 3600;
}

function my_save_account_details_redirect($user_id){
	wp_safe_redirect( wc_get_endpoint_url( 'edit-account') );
	exit;
}
add_action( 'woocommerce_save_account_details', 'my_save_account_details_redirect', 10, 1 );

function my_save_address_redirect($user_id, $load_address){
	// $load_address is either 'billing' or 'shipping'
	wp_safe_redirect( wc_get_endpoint_url( 'edit-address', $load_address) );
	exit;
}
add_action( 'woocommerce_customer_save_address', 'my_save_address_redirect', 10, 2 );

function wpb_woo_endpoint_title( $title, $id ) {

	global $wp;
	if ( is_wc_endpoint_url( 'subscriptions' ) && in_the_loop() ) {
		$title = "Mina sidor";
	}
	else if ( is_wc_endpoint_url( 'edit-account' ) && in_the_loop() ) {
		$title = "Mina uppgifter";
	}
	else if ( is_wc_endpoint_url( 'my-account/noke/' ) && in_the_loop() ) {
		$title = "Så fungerar vår App";
	}

	return $title;
}
add_filter( 'the_title', 'wpb_woo_endpoint_title', 10, 2 );

function get_allmanna_villkor_url(){
	return get_permalink( get_page_by_title( 'Allmänna villkor avseende hyra av förvaringsutrymme' ) );
}


add_filter( 'woocommerce_email_attachments', 'attach_terms_conditions_pdf_to_email', 10, 3);
function attach_terms_conditions_pdf_to_email ( $attachments , $status, $object ) {
	$allowed_statuses = array('customer_completed_order', 'customer_invoice', 'customer_processing_order' );
	if( isset( $status ) && in_array ( $status, $allowed_statuses ) ) {
		// $your_pdf_path = get_stylesheet_directory() . '/pdf/ClickNStore-TermsAndConditions.pdf';
		// $attachments[] = $your_pdf_path;
		$your_pdf_path1 = get_stylesheet_directory() . '/pdf/ClickNStore-Allmanna_Villkor.pdf';
		$attachments[] = $your_pdf_path1;
	}
	return $attachments;
}
add_filter( 'send_email_change_email', '__return_false' );

add_action( 'save_post', 'save_woocommerce_attr_to_meta' );
function save_woocommerce_attr_to_meta( $post_id ) {
	if(isset($_REQUEST['attribute_names'])){
		foreach( $_REQUEST['attribute_names'] as $index => $value ) {
			update_post_meta( $post_id, $value, $_REQUEST['attribute_values'][$index] );
		}
	}
}

add_filter( 'kco_checkout_timeout_duration', 'kco_set_custom_timeout' );
function kco_set_custom_timeout( $time ) {
	return 30;
}

//Personal Number Field on Checkout Page
require_once THEME_PATH . '/inc/personal-number.php';
//Datepicker Field on Checkout Page
require_once THEME_PATH . '/inc/datepicker.php';

//Manage WordPress Cron Jobs with WP control plugin to change noke status. File wp-config.php define('DISABLE_WP_CRON', true);
//Manage Cron depends on Server OS(Linux or others)
require_once THEME_PATH . '/inc/cron-tasks.php';

//Changes default user role 'customer' to 'business' after creating new user
require_once THEME_PATH . '/inc/change-user-role.php';
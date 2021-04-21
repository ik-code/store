<?php
/**
* Plugin Name: WooCommerce Subscriptions - Delete Cancel Subscription Confirmation
* Plugin URI: https://github.com/Prospress/woocommerce-subscriptions-cancel-subscription-confirmation
* Description: Adds a confirmation dialog when deleting a payment method.
* Author: Prospress Inc.
* Author URI: http://prospress.com/
* Version: 1.0
* License: GPLv3
* Tested up to: 5.0.0
* WC tested up to: 3.5.1
*
* GitHub Plugin URI: Prospress/woocommerce-subscriptions-cancel-subscription-confirmation
* GitHub Branch: master
*
* Copyright 2017 Prospress, Inc.  (email : freedoms@prospress.com)
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package		WooCommerce Subscriptions
* @author		Prospress Inc.
* @since		1.0
*/

function wcs_cancel_subscription_confirmation() {
	if ( ! function_exists( 'is_account_page' ) ) {
		return;
	}
	
	$cancel_confirmation_required = apply_filters( 'wcs_cancel_confirmation_promt_enabled', ( 'yes' == get_option( "wcs-cancel-confirmation", 'no' ) ) ? true : false );
	
	if ( is_account_page() && 'yes' == $cancel_confirmation_required ) {
		wp_register_script( 'wcs-cancel-subscription-confirmation-script', plugin_dir_url( __FILE__ ) . 'wcs-cancel-subscription-confirmation.js', array( 'jquery' ), '1.0.0', true );
		$script_atts = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'promt_msg' => apply_filters( "wcs_cancel_confirmation_promt_msg", __("Are you sure you want to cancel your subscription?\nIf so, please type the reason why you want to cancel it here:","wcs-cancel-confirmation" ) ) ,
			'error_msg' => apply_filters( "wcs_cancel_confirmation_error_msg", __("There has been an error when saving the cancellation reason. Please try again.","wcs-cancel-confirmation" ) )
		);
		wp_localize_script( 'wcs-cancel-subscription-confirmation-script', 'ajax_object', $script_atts );
		wp_enqueue_script( 'wcs-cancel-subscription-confirmation-script' );
	}
}
add_action( 'wp_enqueue_scripts', 'wcs_cancel_subscription_confirmation' );


function wcs_cancel_confirmation() {
	$subscription_id = intval( $_POST['subscription_id'] );
	$act_button = $_POST['act_button'];
	$reason_to_cancel = sanitize_text_field( $_POST['reason_to_cancel'] );

	$subscription = wc_get_order( $subscription_id );
	if($act_button === 'cancel'){
		$subscription->update_status('canceled-by-user');
	}else{
		if($subscription->has_status('canceled-by-user')){
			require( '/var/www/sites/dev.clicknstore.se/wp-load.php' );
			add_filter( 'wp_mail_content_type', function($content_type){
				return "text/html";
			});

			$email_text = '<p>Hej '.$subscription->get_billing_first_name().',<br> Vi har tagit emot informationen att du vill fortsätta hyra ditt förråd hos oss på Click N Store. Tack för att du valt att fortsätta vara vår kund.</p>
			<p>Vänliga hälsningar från oss på Click N Store ♥</p>';

			wp_mail( $subscription->get_billing_email(), 'Vi har tagit emot din förlängning', $email_text );
		}
		$subscription->update_status('active');
		remove_all_cancelled_actions($subscription_id);
	}

	$subscription->save();

	wp_die(); 
}
add_action( 'wp_ajax_wcs_cancel_confirmation', 'wcs_cancel_confirmation' );


function add_cancelation_settings( $settings ) {

	$misc_section_end = wp_list_filter( $settings, array( 'id' => 'woocommerce_subscriptions_miscellaneous', 'type' => 'sectionend' ) );

	$spliced_array = array_splice( $settings, key( $misc_section_end ), 0, array(
		array(
			'name'     => __( 'Ask for the cancellation reason', 'wcs-cancel-confirmation' ),
			'desc'     => __( 'Prompt the customer for a cancellation reason', 'wcs-cancel-confirmation' ),
			'id'       => 'wcs-cancel-confirmation',
			'default'  => 'no',
			'type'     => 'checkbox',
			'desc_tip' =>  __( 'Ask for the cancellation reason when the customer cancels a subscription from the My Account page. The provided reason will be added as a subscription note in the backend.' ),
		),
	) );

	return $settings;
}
add_filter( 'woocommerce_subscription_settings', 'add_cancelation_settings'  );

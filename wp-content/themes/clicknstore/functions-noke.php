<?php 
add_action( 'woocommerce_thankyou', 'bbloomer_redirectcustom');

function bbloomer_redirectcustom( $order_id ){
	$order = wc_get_order( $order_id );
	setcookie('add_to_catr_time', null, -1, '/');
}

function noke_changes($order, $status = "inuse"){
	$url_noke_api = 'https://www.sg.noke.com/webhooks/v1/pms/changes';
	$pa_number = "";
	$order_items = $order->get_items();
	foreach ($order_items as $item_id => $item) {
		$pa_number = wc_get_order_item_meta($item_id, 'pa_number', true);
	}

	$user_id = $order->get_user_id();

	$phone = $status == "available" ? "" : str_replace(['-',' '],'',$order->billing_phone);
	if (stripos($phone, "07") === 0) {
		$phone =  "+46" . substr_replace($phone, "", 0, 1 );
	} elseif (stripos($phone, "46") === 0 ) {
		$phone =  "+" . $phone;
	}

	$first_name = $status == "available" ? "" : $order->billing_first_name;
	$last_name = $status == "available" ? "" : $order->billing_last_name;
	$email = $status == "available" ? "" : $order->billing_email;

	$args_noke_api = array(
		'headers' => array(
			'Content-Type' => 'application/json', 
			'X-SecurGuard-API-Key-V1' => NOKE_API_KEY, 
			'User-Agent' => NOKE_USER_AGENT
		),
		'body'    => '{
			"siteId":"boras1",
			"changes":[
			{
				"unitName":"'.$pa_number.'",
				"firstName":"'.$first_name.'",
				"lastName:":"'.$last_name.'",
				"phone":"'.$phone.'",
				"email":"'.$email.'",
				"unitId":"'.$pa_number.'",
				"tenantId":"'.$user_id.'",
				"rentalStatus": "'.$status.'"
			}
			]
		}'
	);
	$order->add_order_note('User id -> '. $user_id .' Phone -> ' . $phone . " Status ->" . $status);

	$response = wp_remote_post( $url_noke_api, $args_noke_api );
}

// ----------------------------- STEPS for: Subscription cancelled by user ------------------------------------

// if subscription canceled_by_user
add_action('woocommerce_subscription_status_canceled-by-user', 'noke_changes_status_canceled_by_user', 10, 3 );
function noke_changes_status_canceled_by_user($subscription){
	$subscription_id = array( 'subscription_id' => $subscription->ID );
	// Send email after canceled by user
	send_email_from_noke(
		$subscription,
		$subscription->get_billing_email(), 
		wc_get_template_html(
			'canceled_by_user.php',
			array('first_name' => $subscription->get_billing_first_name(),
				'last_name' => $subscription->get_billing_last_name(),
				'date_move_out' => date_i18n('j M Y',$subscription->get_time( 'next_payment' ))
			),
			'woocommerce/emails/noke'
		),
		'Vi har tagit mottagit uppsägningen av ditt förråd'
	);

	// Create action
	as_schedule_single_action($subscription->get_time( 'next_payment' ), 'cancel_after_canceled_by_user_action', $subscription_id);
	// Remove next payment
	as_unschedule_all_actions('woocommerce_scheduled_subscription_payment', $subscription);
	
}
add_action( 'cancel_after_canceled_by_user_action', 'cancel_after_canceled_by_user' );
function cancel_after_canceled_by_user($subscription_id) {
	$subscription = wcs_get_subscription( $subscription_id );
	$order = wc_get_order( $subscription->parent_id );
	retutn_one_item($order);
	noke_changes($order, "available");
	$subscription->update_status('cancelled');
}

// ------------------------ STEPS for: Subscription cancelled due to failed payment -------------------------

// if subscription is failed payment
add_action('woocommerce_subscription_renewal_payment_failed', 'noke_changes_status_on_hold', 10, 3 );
function noke_changes_status_on_hold($subscription){
	$subscription_id = array( 'subscription_id' => $subscription->ID ); 
	
	$time_to_next_hook = time() + 60*60*26*1; // sec * min * hour * day 

	$dates['next_payment'] = date( 'Y-m-d H:i:s', $time_to_next_hook );
	$subscription->update_dates( $dates );
	// Create action
	if(count(as_get_scheduled_actions( array('hook' => 'on_hold_first_five_days_action', 'args' => $subscription_id, 'status' => ActionScheduler_Store::STATUS_PENDING ))) === 0
		&& count(as_get_scheduled_actions( array('hook' => 'on_hold_after_five_days_action', 'args' => $subscription_id, 'status' => ActionScheduler_Store::STATUS_PENDING ))) === 0
		&& count(as_get_scheduled_actions( array('hook' => 'cancel_after_on_hold_action', 'args' => $subscription_id, 'status' => ActionScheduler_Store::STATUS_PENDING ))) === 0){
		// Send email change subscription status to on_hold
		send_email_from_noke(
			$subscription,
			$subscription->get_billing_email(),
			wc_get_template_html(
				'status_on_hold.php',
				array('first_name' => $subscription->get_billing_first_name(),
					'last_name' => $subscription->get_billing_last_name(),
					'date_move_out' => date_i18n('j M Y',
						$subscription->get_time( 'next_payment' )
					)
				),
				'woocommerce/emails/noke'
			),
			'Vi saknar din senaste betalning'
		);

	as_schedule_single_action($time_to_next_hook , 'on_hold_first_five_days_action', $subscription_id);
}
}

add_action( 'on_hold_first_five_days_action', 'on_hold_first_five_days' );
function on_hold_first_five_days($subscription_id){
	$subscription = wcs_get_subscription( $subscription_id );
	$subscription_id = array( 'subscription_id' => $subscription_id );
	// $dates_to_update = $subscription->get_time( 'next_payment' ) + 86400; // plus half day for test 86400 - 1 day
	$time_to_next_hook = time() + 60*60*26*1; // sec * min * hour * day 
	// Send email after 5 day
	send_email_from_noke(
		$subscription,
		$subscription->get_billing_email(),
		wc_get_template_html(
			'first_five_days.php',
			array('first_name' => $subscription->get_billing_first_name(),
				'last_name' => $subscription->get_billing_last_name(),
				'date_move_out' => date_i18n('j M Y',
					$subscription->get_time( 'next_payment' )
				)
			),
			'woocommerce/emails/noke'
		),
		'Vi saknar fortfarande din senaste betalning'
	);
	$dates['next_payment'] = date( 'Y-m-d H:i:s', $time_to_next_hook );
	$subscription->update_dates( $dates );
	// Create action
	as_schedule_single_action($time_to_next_hook, 'on_hold_after_five_days_action', $subscription_id);
}

add_action( 'on_hold_after_five_days_action', 'on_hold_after_five_days' );
function on_hold_after_five_days($subscription_id){
	$subscription = wcs_get_subscription( $subscription_id );
	$order = wc_get_order( $subscription->parent_id );
	noke_changes($order, "overlock");
	// Send email after change noke to overlock
	send_email_from_noke(
		$subscription,
		$subscription->get_billing_email(),
		wc_get_template_html(
			'after_five_days.php',
			array('first_name' => $subscription->get_billing_first_name(),
				'last_name' => $subscription->get_billing_last_name(),
				'date_move_out' => date_i18n('j M Y',
					$subscription->get_time( 'next_payment' )
				)
			),
			'woocommerce/emails/noke'
		),
		'Du har förlorat åtkomsten till ditt förråd'
	);
	// $subscription_id = array( 'subscription_id' => $subscription_id );
	// Create action
	// as_schedule_single_action($subscription->get_time( 'next_payment' ), 'cancel_after_on_hold_action', $subscription_id);
	cancel_after_on_hold($subscription_id);
}

add_action( 'cancel_after_on_hold_action', 'cancel_after_on_hold' );
function cancel_after_on_hold($subscription_id) {
	$subscription = wcs_get_subscription( $subscription_id );
	$order = wc_get_order( $subscription->parent_id );
	// retutn_one_item($order);
	$subscription->update_status('cancelled');
}

// if subscription active
add_action('woocommerce_subscription_status_active', 'noke_changes_status_active', 10, 3 );
function noke_changes_status_active($subscription){
	$order = wc_get_order( $subscription->parent_id );
	$order_id = $order->get_id();

	$repossessed_date = get_post_meta( $order_id,'_checkout_datepicker', true );

	date_default_timezone_set('Europe/Stockholm');
	$current_date = date('Y-m-d');

	//Changes the date string to format 'timestamp'
	$repossessed_date_timestamp = strtotime($repossessed_date);
	$current_date_timestamp = strtotime($current_date);

	if( $repossessed_date_timestamp > $current_date_timestamp ){
		noke_changes($order, $status = 'repossessed');
	}else{
		noke_changes($order);
	}

	$subscription = array( 'subscription_id' => $subscription->ID );
	as_unschedule_all_actions('cancel_after_canceled_by_user_action', $subscription);
}


add_action('woocommerce_subscription_renewal_payment_complete', 'subscription_payment_complete', 10, 3 );
function subscription_payment_complete($subscription_obj){

	$subscription = array( 'subscription_id' => $subscription_obj->ID );
	as_unschedule_all_actions('on_hold_first_five_days_action', $subscription);
	as_unschedule_all_actions('on_hold_after_five_days_action', $subscription);
	as_unschedule_all_actions('cancel_after_on_hold_action', $subscription);
}

add_action('woocommerce_subscription_status_cancelled', 'remove_all_cancelled_actions', 10, 3 );
function remove_all_cancelled_actions($subscription_id){
	$subscription = array( 'subscription_id' => $subscription_id );
	as_unschedule_all_actions('cancel_after_canceled_by_user_action', $subscription);
	as_unschedule_all_actions('on_hold_first_five_days_action', $subscription);
	as_unschedule_all_actions('on_hold_after_five_days_action', $subscription);
	as_unschedule_all_actions('cancel_after_on_hold_action', $subscription);
}

function send_email_from_noke($subscription,$email, $email_content, $subject){
	require( '/var/www/sites/dev.clicknstore.se/wp-load.php' );

	add_filter( 'wp_mail_content_type', function($content_type){
		return "text/html";
	});

	$send_status = wp_mail( $email, $subject, $email_content);

	if ($send_status) {
		$send_status = 'Succsess';
	} else {
		$send_status = 'Fail';
	}
	$subscription->add_order_note('Email -> ' . $email . " Email subject ->" . $subject .' Status -> '.$send_status);
}

function retutn_one_item($order) {
	$variation_id = 0;
	foreach ($order->get_items() as $item_id => $item) {
		$variation_id = $item->get_variation_id();
	}
	$variation = wc_get_product($variation_id);
	wc_update_product_stock($variation,1);
}
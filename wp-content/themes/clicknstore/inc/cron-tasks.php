<?php
/**
 * This file will be start by Cron
 */

add_action( 'change_order_noke_status_cron', 'function_change_order_noke_status' );

function function_change_order_noke_status() {
	//Set current date format
	date_default_timezone_set( 'Europe/Stockholm' );
	$current_date = date( 'Y-m-d' );

// Get orders
	$args           = array(
		'limit'  => - 1,
		'meta_key' => '_checkout_datepicker',
		'meta_compare' => '=',
		'meta_value'   => $current_date,
		'return' => 'ids',
	);
	$array_order_id = wc_get_orders( $args );

// loop for orders
	if(!empty( $array_order_id )){
		foreach ( $array_order_id as $order_id ) {
			$order = wc_get_order( $order_id );
			noke_changes( $order ); // second parameter $status='inuse'
		}
	}
}
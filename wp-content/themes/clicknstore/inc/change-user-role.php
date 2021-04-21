<?php
/**
 * Change the user role depend on KCO trigger
 */
add_action('user_register','change_user_role', 10, 1);
function change_user_role($user_id){
	if(isset($_POST['user_role']) && !empty($_POST['user_role'])) {
		$user = get_userdata( $user_id );
		$user_roles = $user->roles;
		if ( $_POST['user_role'] === 'business' && ! in_array( 'business', $user_roles, true ) ) {
			$user->add_role( 'business' );
		}
	}
}

add_action('woocommerce_subscription_status_updated', 'remove_user_role', 200, 1);
function remove_user_role($order_id){
	$order = wc_get_order( $order_id );
	$user = get_userdata( $order->user_id );
	$user_roles = $user->roles;
	if(in_array( 'business', $user_roles, true )){
		$user->remove_role( 'customer' );
	}
}
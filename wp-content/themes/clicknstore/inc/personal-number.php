<?php

/**
 * Update order metadate with value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'personal_number_checkout_field_update_extra_profile_field' );
function personal_number_checkout_field_update_extra_profile_field() {
	if ( ! empty( $_POST['personal_number'] ) ) {
		update_user_meta( get_current_user_id(), 'bankID', sanitize_text_field( $_POST['personal_number'] ));
	}
}
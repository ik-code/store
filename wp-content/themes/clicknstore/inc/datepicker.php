<?php
// Field validation
add_action( 'woocommerce_after_checkout_validation', 'checkout_datepicker_custom_field_validation', 10, 2 );
function checkout_datepicker_custom_field_validation( $data, $errors ) {
	$field_id = 'checkout_datepicker';

	if ( isset($_POST[$field_id]) && empty($_POST[$field_id]) ) {
		$errors->add( 'validation', __('You must choose a date on datepicker field.', 'woocommerce') );
	}
}

// Save field
add_action( 'woocommerce_checkout_create_order', 'save_datepicker_custom_field_value', 10, 2 );
function save_datepicker_custom_field_value( $order, $data ){
	$field_id = 'checkout_datepicker';
	$meta_key = '_'.$field_id;

	if ( isset($_POST[$field_id]) && ! empty($_POST[$field_id]) ) {
		$date = esc_attr($_POST[$field_id]);

		$order->update_meta_data( $meta_key, $date ); // Save date as order meta data

		$note = sprintf(__("Inflyttningsdatum: %s.", "woocommerce"), $date );
		$note = isset($data['order_comments']) && ! empty($data['order_comments']) ? $data['order_comments'] . '. ' . $note : $note;

		// Save date on customer order note
		$order->set_customer_note( $note );

	}
}


// Display custom field value in admin order pages
add_action( 'woocommerce_admin_order_data_after_billing_address', 'admin_display_date_custom_field_value', 10, 1 );
function admin_display_date_custom_field_value( $order ) {
	$meta_key   = '_checkout_datepicker';
	$meta_value = $order->get_meta( $meta_key ); // Get carrier company

	if( ! empty($meta_value) ) {
		// Display
		echo '<p><strong>' . __("Inflyttningsdatum", "woocommerce") . '</strong>: ' . $meta_value . '</p>';
	}
}

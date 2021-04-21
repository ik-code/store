<?php
/**
 * Klarna Checkout page
 *
 * Overrides /checkout/form-checkout.php.
 *
 * @package klarna-checkout-for-woocommerce
 */
?>
<div class="booking-final__container" id="kco-wrapper">

	<div class="booking-final__wrapper">
        <div class="booking-final__wrapper-order">
            <h3 class="booking-final__title-desktop"><?php _e('Din bokning', 'woocommerce'); ?></h3>

            <div class="booking-final__timer" data-timer="<?php echo $_COOKIE['add_to_catr_time']; ?>">
                <span class="booking-final__timer-title"><?php _e('Time left to finish', 'woocommerce'); ?></span>
                <span class="booking-final__time"></span>
            </div>

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    var date_now = new Date().getTime();
                    var cart_created = <?php echo $_COOKIE['add_to_catr_time'] ? $_COOKIE['add_to_catr_time'] : '0'; ?>;
                    var time_left = date_now - cart_created;
                    var ms = time_left % 1000;
                    var s = (time_left - ms) / 1000;
                    $('.booking-final__timer').attr("data-timer", s);
                });
            </script>

            <div class="booking-final__rent-info">

                <div class="booking-final__rent-info-title">
                    <span><?php _e('MÅNADSHyra:', 'woocommerce'); ?></span>
                    <span class="booking-final__total-price"><?php wc_cart_totals_order_total_html(); ?></span>
                    <div class="booking-final__arrow-icon"></div>
                </div>

                <div class="booking-final__rent-info-wrapper">
                    <div id="kco-order-review" class="woocommerce-checkout-review-order">
						<?php woocommerce_order_review(); ?>
                    </div>
                </div>
            </div>

            <div class="booking-final__info">
                <div class="booking-final__info-title">
                    <h4>DINA UPPGIFTER</h4>
                    <div class="booking-final__arrow-icon"></div>
					<?php $current_user = wp_get_current_user(); ?>
                </div>
                <div class="booking-final__info-user">
                    <div class="booking-final__info-block">
                        <span class="booking-final__user-name"><?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname; ?></span>
                        <a class="booking-final__edit-button" href="/my-account/edit-account/"><?php _e('Edit', 'woocommerce'); ?></a>
                    </div>
                    <div>
                        <span class="booking-final__company-name">Företagsnamn</span>
                        <span class="booking-final__user-email"><?php echo $current_user->user_email ?></span>
                        <span class="booking-final__user-phone"><?php echo $current_user->billing_phone; ?></span>
                        <span class="booking-final__adress"><?php echo $current_user->billing_address_1; ?>, <?php echo $current_user->billing_postcode; ?> <?php echo $current_user->billing_city; ?></span>
                    </div>
                </div>
            </div>
        </div>

		<div class="login-personal-number">
			<h3 class="booking-final__user-title"><?php _e('Dina Uppgifter', 'woocommerce'); ?></h3>
			<?php do_action('klarna_checkout_before_form'); ?>
		</div>
		<form name="checkout" class="checkout woocommerce-checkout booking-final__form">
			<div class="booking-final__insurance">
				<!--<span> registrera företag?<span><a href="#">tryck här!</a></span> </span>-->

				<div class="booking-final__user">
					<?php /*do_action( 'woocommerce_checkout_billing' ); */?>
				</div>

				<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>

				<p class="booking-final__description"><?php _e('Försäkringsskydd av förvarad egendom är obligatoriskt för alla kunder. Beräkna värdet på det du skall förvara utifrån nyvärde.', 'woocommerce'); ?> <a href="/forsakring/" target="_blank">Läs mer.</a></p>

				<div class="booking-final__contract">
					<div class="booking-final__contract-block">
						<?php wc_get_template( 'checkout/terms.php' ); ?>
					</div>
				</div>
			</div>
			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
			<div class="hidden">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>
		</form>
		<p class="form-row validate-required">
			<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox booking-final__checkbox" name="general_terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['general_terms'] ) ), true ); ?> id="general_terms" />
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox booking-final__contract-label" for="general_terms">
				<span class="woocommerce-terms-and-conditions-checkbox-text"><?php _e('Jag godkänner de allmänna villkoren inklusive villkoren för försäkringsskyddet.', 'woocommerce'); ?></span> <a href="<?php echo get_allmanna_villkor_url(); ?>" target="_blank"><?php _e('Allmänna villkor', 'woocommerce'); ?></a>&nbsp;<span class="required">*</span>
			</label>
			<input type="hidden" name="terms-field" value="1" />
		</p>
		<p class="form-row validate-required">
			<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox booking-final__checkbox" name="start_using" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['start_using'] ) ), true ); ?> id="start_using" />
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox booking-final__contract-label" for="start_using">
				<span class="woocommerce-terms-and-conditions-checkbox-text">
					<?php _e('Jag godkänner att jag får tillgång till och börjar använda förrådet under ångerrättsfristen.', 'woocommerce'); ?>
				</span>&nbsp;<span class="required">*</span>
			</label>
			<input type="hidden" name="terms-field" value="1" />
		</p>
		<button class="booking-final__button booking-final__button--mobile btn btn--yellow"><?php _e('TILL KASSAN', 'woocommerce'); ?></button>


	</div><!-- .booking-final__wrapper-->

    <div class="booking-final__wrapper">
        <h3 class="booking-final__title-desktop"><?php _e('Betalning', 'woocommerce'); ?></h3>
        <div id="kco-iframe">
			<?php kco_wc_show_snippet(); ?>
        </div>
    </div><!-- .booking-final__wrapper-->


	<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>


</div>

<script type="text/javascript">
	function ajax_my_custom_checkout_field_update_order_meta(){
		jQuery.ajax({
			url: '/wp-admin/admin-ajax.php',
			type: 'POST',
			data: {action: 'ajax_my_custom_checkout_field_update_order_meta'},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}
</script>



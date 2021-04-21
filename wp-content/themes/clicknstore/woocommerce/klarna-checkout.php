<?php
/**
 * Klarna Checkout page
 *
 * Overrides /checkout/form-checkout.php.
 *
 * @package klarna-checkout-for-woocommerce
 */

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', WC()->checkout() );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

$settings = get_option( 'woocommerce_kco_settings' );
?>
<form name="checkout" class="checkout woocommerce-checkout booking-final__form">
    <div class="booking-final__container" id="kco-wrapper">

		<?php do_action( 'kco_wc_before_wrapper' ); ?>

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

                <div class="booking-final__datepicker">
                    <label for="checkout_datepicker">Inflyttningsdatum:</label>
                    <input type="text" class="datepicker input-text booking-final__user-input" id="checkout_datepicker" name="checkout_datepicker" readonly require>
                </div><!-- .booking-final__datepicker -->

                <div class="booking-final__rent-info">

                    <div class="booking-final__rent-info-title">
                        <span><?php _e('MГ…NADSHyra:', 'woocommerce'); ?></span>
                        <span class="booking-final__total-price"><?php wc_cart_totals_order_total_html(); ?></span>
                        <div class="booking-final__arrow-icon"></div>
                    </div>

                    <div class="booking-final__rent-info-wrapper">
                        <div id="kco-order-review">
							<?php do_action( 'kco_wc_before_order_review' ); ?>
							<?php
							if ( ! isset( $settings['show_subtotal_detail'] ) || in_array( $settings['show_subtotal_detail'], array( 'woo', 'both' ), true ) ) {
								woocommerce_order_review();
							}
							?>
							<?php do_action( 'kco_wc_after_order_review' ); ?>
                        </div>
                    </div>
                </div>

				<?php if( ! is_user_logged_in() ) : ?>
                    <p class="form-row booking-final__user-wrapper" id="user_role_field">
                <span class="woocommerce-input-wrapper">
						<div id="notice"></div>
						<input type="hidden" class="input-text booking-final__user-input booking-final__user_role" name="user_role"
                               id="user_role" placeholder="User role"  required value="">
					</span>
                    </p>

                    <p class="form-row booking-final__user-wrapper" id="personal_number_field">
                    <h3 class="booking-final__insurance-title">Dina uppgifter</h3>
                    <label for="personal_number" class="screen-reader-text">Dina uppgifter&nbsp;
                        <span class="optional">(valfritt)</span>
                    </label>
                    <span class="woocommerce-input-wrapper">
						<div id="notice"></div>
						<input type="text" class="input-text booking-final__user-input booking-final__personal-number" name="personal_number"
                               id="personal_number" placeholder="Г…Г…Г…Г…MMDD-NNNN" pattern="[0-9]{12}" required value="">
					</span>
                    </p>
				<?php endif; ?>

                <div class="booking-final__insurance">
					<?php do_action( 'woocommerce_after_checkout_billing_form', WC()->checkout() ); ?>

                    <p class="booking-final__description">
						<?php _e('FГ¶rsГ¤kringsskydd av fГ¶rvarad egendom Г¤r obligatoriskt fГ¶r alla kunder. BerГ¤kna vГ¤rdet pГҐ det du skall fГ¶rvara utifrГҐn nyvГ¤rde.', 'woocommerce'); ?> <a href="/forsakring/" target="_blank">LГ¤s mer.</a>
                    </p>
                </div>


            </div>
        </div><!-- .booking-final__wrapper-->


        <div class="booking-final__wrapper">
            <div id="kco-wrapper-disable"></div>
            <h3 class="booking-final__title-desktop"><?php _e('Betalning', 'woocommerce'); ?></h3>

            <div id="kco-iframe">

				<?php do_action( 'kco_wc_before_snippet' ); ?>
				<?php kco_wc_show_snippet(); ?>
				<?php do_action( 'kco_wc_after_snippet' ); ?>
            </div>
        </div><!-- .booking-final__wrapper-->




		<?php do_action( 'kco_wc_after_wrapper' ); ?>

    </div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', WC()->checkout() ); ?>


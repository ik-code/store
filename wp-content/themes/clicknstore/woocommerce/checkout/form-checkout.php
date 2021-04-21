<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout booking-final__form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<div class="booking-final__container">
		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
		<div class="booking-final__wrapper">
			<h3 class="booking-final__title-desktop">Check-out</h3>
			
			<div class="booking-final__timer">
				<span class="booking-final__timer-title">Time left to finish</span>
				<span class="booking-final__time">30:00</span>
			</div>

			<div class="booking-final__rent-info">
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>

				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			</div>
			<div class="booking-final__info">
				<div class="booking-final__info-title">
					<h4>DINA UPPGIFTER</h4>
					<div class="booking-final__arrow-icon"></div>
				</div>
				<div class="booking-final__info-user">
					<div class="booking-final__info-block">
						<span class="booking-final__user-name">Bill Grahanam</span>
						<a class="booking-final__edit-button" href="edit-account.html">Edit</a>
					</div>
					<div>
						<span class="booking-final__company-name">Företagsnamn</span>
						<span class="booking-final__user-email">email@gmail.com</span>
						<span class="booking-final__user-phone">040 5677676</span>
						<span class="booking-final__adress">Stockholm, address, 00200</span>
						<span class="booking-final__ensurance">Ensurance 50,000 Kr</span>
					</div>
				</div>
			</div>

			<div class="booking-final__rent-info">
				<div class="booking-final__rent-info-title">
					<span>MÅNADSHyra:</span>
					<span class="booking-final__total-price">1550 Kr</span>
					<div class="booking-final__arrow-icon"></div>
				</div>

				<div class="booking-final__rent-info-wrapper">

					<div class="booking-final__rent-info-block">
						<span>Inflyttningsdatum:</span>
						<span class="booking-final__order-date">2019-03-06</span>
					</div>
					<div class="booking-final__rent-info-block">
						<p>Förråd: </p>
						<span class="booking-final__storage-size">Small 1.5 m² , Borås</span>
						<span class="booking-final__rent-price">1500 KR </span>
					</div>
					<div class="booking-final__rent-info-block">
						<p>Försäkring: </p>
						<span class="booking-final__insurance-value">Upp till: 150,000 Kr</span>
						<span class="booking-final__insurance-price">119 KR </span>
					</div>
					<div class="booking-final__rent-info-block">
						<div class="booking-final__tax">Moms
							<div class="booking-final__tooltip">
								<span class="booking-final__tooltip-button">?</span>
								<div class="booking-final__tooltip-popup">Moms betalas endast utav företagskunder</div>
							</div>
						</div>
						<span class="booking-final__tax-price">0 KR</span>
					</div>

					<div class="booking-final__rent-info-block booking-final__rent-info-block--total">
						<span>TOTAL</span>
						<span class="booking-final__total-price">1619 KR</span>
					</div>
					<div class="booking-final__rent-info-block booking-final__rent-info-block--discont">
						<span>Rabatt</span>
						<span class="booking-final__discont-value">- 60kr</span>
					</div>
					<div class="booking-final__discont">
						<div class="booking-final__discont-wrapper">
							<input class="booking-final__discont-input" type="text" placeholder="+ Eventuell kampanjkod">
						</div>
						<button class="booking-final__discont-button" type="submit">APPLY</button>
						<p class="booking-final__discont-success-message">Promo code is applied</p>
					</div>
				</div>
			</div>
			<button class="booking-final__button booking-final__button--desktop btn btn--yellow">TILL KASSAN</button>
		</div>

		<div class="booking-final__insurance">

			<div class="booking-final__user">
				<h3 class="booking-final__user-title">Dina Uppgifter</h3>
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>

			<p class="booking-final__description">Beräkna värdet på det du skall förvara utifrån nyvärde. Vad är värdet om
			du skulle införskaffa allting nytt idag?</p>

			<div class="booking-final__contract">
				<div class="booking-final__contract-block">
					<?php wc_get_template( 'checkout/terms.php' ); ?>
				</div>
				<!-- <div class="booking-final__contract-block">
					<input class="booking-final__checkbox" id="contract-checkbox-1" type="checkbox" name="privacy-policy" required>
					<label class="booking-final__contract-label" for="contract-checkbox-1">Jag har läst och förstår* <a href="#">Integritetspolicyn</a></label>
				</div>
				<div class="booking-final__contract-block">
					<input class="booking-final__checkbox" id="contract-checkbox-2" type="checkbox" name="terms-and-conditions" required>
					<label class="booking-final__contract-label" for="contract-checkbox-2">Jag godkänner de allmänna villkoren
						inklusive villkoren för
						försäkringsskyddet.* <a href="#">Allmänna villkor</a></label>
					</div>
					<div class="booking-final__contract-block">
						<input class="booking-final__checkbox" id="contract-checkbox-3" type="checkbox" name="" required>
						<label class="booking-final__contract-label" for="contract-checkbox-3">Jag godkänner att jag får tillgång
						till och börjar använda förrådet under ångerrättsfristen.*</label>
					</div>
				</div> -->
				<button class="booking-final__button booking-final__button--mobile btn btn--yellow">TILL KASSAN</button>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	</form>

	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div class="cabinet__user-info show data-tab" data-cabinet-tab="1">

	<form class="woocommerce-EditAccountForm edit-account cabinet__user-info-form" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >
		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
		<div class="cabinet__user-wrapper">

			<?php $get_user_meta = get_user_meta(1); ?>

			<div class="cabinet__personal-info">
				<h4 class="cabinet__personal-info-title"><?php _e('Personal Info', 'woocommerce'); ?></h4>
				<div class="cabinet__input-wrapper">
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text cabinet__input" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" placeholder="Förnamn" />
				</div>
				<div class="cabinet__input-wrapper">
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text cabinet__input" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" placeholder="Efternamn" />
				</div>
				<div class="cabinet__input-wrapper" style="display: none;">
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
				</div>
				<div class="cabinet__input-wrapper">
                    <input class="cabinet__input" type="text" name="account_address" value="<?php echo esc_attr( $user->billing_address_1 ); ?>" placeholder="Adress">
				</div>
				<div class="cabinet__block">
					<div class="cabinet__input-wrapper">
						<input class="cabinet__input postcode" type="text" name="account_postcode" value="<?php echo esc_attr( $user->billing_postcode ); ?>" placeholder="Postnummer">
					</div>
					<div class="cabinet__input-wrapper">
						<input class="cabinet__input" type="text" name="account_city" value="<?php echo esc_attr( $user->billing_city ); ?>" placeholder="Postort">
					</div>
				</div>
				<?php do_action( 'woocommerce_edit_account_form' ); ?>
			</div>

			<div class="cabinet__inner-block">
				<div class="cabinet__contact-info">
					<h4 class="cabinet__personal-info-title"><?php _e('Contact', 'woocommerce'); ?></h4>
					<div class="cabinet__input-wrapper">
						<input type="email" class="woocommerce-Input woocommerce-Input--email input-text cabinet__input" name="account_email" id="account_email" placeholder="E-post" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
					</div>
					<div class="cabinet__input-wrapper">
						<input class="cabinet__input phone-number" type="tel" name="account_phone" value="<?php echo esc_attr( $user->billing_phone ); ?>" placeholder="Mobilnummer">
					</div>
				</div>

				<div class="cabinet__business-info">
					<h4 class="cabinet__personal-info-title"><?php _e('Business Info', 'woocommerce'); ?></h4>
					<?php if($user->roles[0] === 'administrator' || $user->roles[0] === 'business') {
						$company_attr = 'required';
					} else {
						$company_attr = 'disabled';
					} ?>
					<div class="cabinet__input-wrapper">
						<input class="cabinet__input" type="text" name="company_name" value="<?php echo esc_attr( $user->billing_company ); ?>" placeholder="Företagsnamn" <?php echo $company_attr; ?> >
					</div>
					<div class="cabinet__input-wrapper">
                        <input class="cabinet__input" type="text" name="company_number" value="<?php echo esc_attr( $user->company_number ); ?>" placeholder="Organisationsnummer" <?php echo $company_attr; ?> >
					</div>
				</div>
			</div>

		</div>
		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="woocommerce-Button button cabinet__button btn btn--yellow btn--disable" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Update', 'woocommerce' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />

	</form>
</div>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>

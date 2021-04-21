<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>
<div class="cabinet__tabs">
	<div class="cabinet__tabs">
		<div class="cabinet__tabs-title">
			<span class="cabinet__tabs-title-text"><?php _e('Meny', 'woocommerce'); ?></span>
			<span class="cabinet__arrow-icon"></span>
		</div>
		<ul class="cabinet__tabs-list">
			<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				<li class="cabinet__tabs-item <?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="referral_block">
		<p class="referral_block-title">Få en månad gratis!</p>
		<p>Dela länken till någon som behöver hyra ett förråd* så bjuder vi dig på en månadshyra!</p>
		<?php 
		$pname = get_option( 'aff_pname', AFFILIATES_PNAME ); 
		$val_copy = $_SERVER['SERVER_NAME'] . '/?' . $pname . '=' . affiliates_get_user_affiliate(get_current_user_id())[0]; ?>
		<input type="text" name="referral_link" class="referral_link" data-value="<?php echo $val_copy; ?>" value="<?php echo $val_copy; ?>">
		<p>*Gäller endast nya kunder.</p>
	</div>

	<a href="<?php echo wp_logout_url(home_url()); ?>" class="cabinet__log_out"><?php _e('Logga ut', 'woocommerce'); ?></a>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.referral_link').click(function(event) {
			event.preventDefault();
			var $tmp = $("<textarea>");
			$(".referral_block").append($tmp);
			$tmp.val($(this).data('value')).select();
			document.execCommand("copy");
			$tmp.remove();

			ui_copyDone( this );
		});

		function ui_copyDone(btn) {

			var contentSaved = $(btn).data('value');

			$(btn).val('Kopieras');
			$(btn).addClass('copied');

			setTimeout(function() {
				$(btn).val(contentSaved);
				$(btn).removeClass('copied');
			}, 1000);
		}
	});
</script>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>

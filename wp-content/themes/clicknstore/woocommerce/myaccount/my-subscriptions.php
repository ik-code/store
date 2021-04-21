<?php
/**
 * My Subscriptions section on the My Account page
 *
 * @author   Prospress
 * @category WooCommerce Subscriptions/Templates
 * @version  2.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="cabinet__history data-tab show" data-cabinet-tab="2">
	<h4 class="cabinet__personal-info-title"><?php _e('Booking history', 'woocommerce'); ?></h4>
	<?php if ( !empty( $subscriptions ) ) : ?>

		<?php foreach ( $subscriptions as $subscription_id => $subscription ) : ?>
			<div class="cabinet__history-wrapper">
				<?php 
				$items = $subscription->get_items();
				foreach ($items as $item) { 
					$terms = wp_get_post_terms( $item['product_id'], 'product_cat' );
					$product = wc_get_product( $item['product_id'] ); ?>
					<div class="cabinet__image-wrapper">
						<img class="cabinet__image" src="<?php echo get_the_post_thumbnail_url($item['product_id']); ?>" alt="storage photo">
					</div>
					<div class="cabinet__order-wrapper">
						<div class="cabinet__text-block">
							<span class="cabinet__storage-size"><?php echo $product->get_title(); ?></span>
						</div>
						<div class="cabinet__text-block">
							<span><?php _e('Anläggning:', 'woocommerce') ?> </span>
							<span><?php echo $terms[0]->name; ?></span>
						</div>

						<?php
						$order_free_trial = 0;
						foreach ($item->get_meta_data() as $meta_data) {
							if( $meta_data->key === 'pa_number'){
								$get_meta_data = $meta_data->get_data(); ?>
								<div class="cabinet__text-block">
									<span><?php _e('Förrådsnummer:', 'woocommerce'); ?> </span>
									<span>
										<?php echo $get_meta_data['value']; ?>
									</span>
								</div>
							<?php } elseif ($meta_data->key === '_has_trial' && $meta_data->value === 'true') {
								$order_free_trial = 1; }
							} ?>

							<?php $order_item_total = $subscription->get_order_item_totals();  ?>
							<div class="cabinet__text-block">
								<span><?php echo $order_item_total['order_total']['label']; ?></span>
								<span class="cabinet__price">
									<span class="cabinet__price"><?php echo $order_item_total['order_total']['value']; ?> <?php //echo $order_free_trial ? "(Första mån 1kr)" : ""; ?></span>
								</span>
							</div>

							<?php if($subscription->schedule_next_payment && !$subscription->has_status( 'canceled-by-user' )){ ?> 
								<div class="cabinet__text-block">
									<span><?php _e('Nästa debitering: '); ?></span>
									<span class="cabinet__price">
										<?php echo date_i18n( 'j F Y', $subscription->get_time('next_payment') ); ?>
									</span>
								</div>
							<?php } ?>
							<?php if($order_free_trial){ ?>
								<div class="cabinet__text-block">
									<span><?php _e('Notering:', 'woocommerce'); ?> </span>
									<span>Första mån 1kr</span>
								</div>
							<?php } ?>
							<?php  foreach( $subscription->get_coupon_codes() as $coupon_code ) {
								$coupon = new WC_Coupon($coupon_code);
								$coupon_description = $coupon->get_description();
								if($coupon_description){
									?>
									<div class="cabinet__text-block">
										<span><?php _e('Notering:', 'woocommerce'); ?> </span>
										<span><?php echo $coupon_description; ?></span>
									</div>
								<?php } } ?>
							</div>
						<?php } ?>

						<div class="cabinet__order-date">

							<div>
								<span class="cabinet__order-start"><?php echo date_i18n('j M Y', $subscription->get_time('start')); ?></span>
								-
								<?php if($subscription->has_status( 'active' )){ ?>
									<span class="cabinet__order-end"><?php _e('Now', 'woocommerce') ?></span>
								<?php }else{ ?>
									<?php if($subscription->get_time('end')){ ?>
										<span class="cabinet__order-start"><?php echo date_i18n('j M Y',$subscription->get_time('end')); ?></span>
									<?php }else{ ?>
										<span class="cabinet__order-start"><?php echo date_i18n('j M Y',$subscription->get_time('next_payment')); ?></span>
									<?php } ?>
								<?php } ?>
							</div>
							<?php 
							$actions = wcs_get_all_user_actions_for_subscription( $subscription, get_current_user_id() );

							if(!empty($actions)){
								foreach ( $actions as $key => $action ){
									if(strtolower($action['name']) == "cancel" && $subscription->has_status( 'active' )){
										$cancelLink = esc_url( $action['url'] );
										echo "<a href='$cancelLink' data-next_payment='".date_i18n( 'j F Y', $subscription->get_time('next_payment'))."' data-subscription_id='".$subscription->get_id()."' data-act='cancel' class='cancel_subscription'>Säg upp förråd</a>";
										break;
									}elseif($subscription->get_status() == 'canceled-by-user'){
								// 86400 - one day in sec.
										if($subscription->get_time('next_payment') - time() > 86400){
											$reactivateLink = esc_url( $action['url'] );
											echo "<a href='$reactivateLink' data-subscription_id='".$subscription->get_id()."' data-act='reactivate' class='reactivate_subscription'>Fortsätt hyra förråd</a>";
										}
										break;
									}
								}
							}
							?>
						</div>
					</div>
				<?php endforeach; ?>

				<?php if ( 1 < $max_num_pages ) : ?>
					<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
						<?php if ( 1 !== $current_page ) : ?>
							<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'subscriptions', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Föregående Sida', 'woocommerce-subscriptions' ); ?></a>
						<?php endif; ?>

						<?php if ( intval( $max_num_pages ) !== $current_page ) : ?>
							<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'subscriptions', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Nästa Sida', 'woocommerce-subscriptions' ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php else : ?>
					<p class="no_subscriptions">
						<?php if ( 1 < $current_page ) :
							printf( esc_html__( 'You have reached the end of subscriptions. Go to the %sfirst page%s.', 'woocommerce-subscriptions' ), '<a href="' . esc_url( wc_get_endpoint_url( 'subscriptions', 1 ) ) . '">', '</a>' );
						else :
							printf( esc_html__( 'Du har inte hyrt något förråd ännu. Se %svåra förråd%s.', 'woocommerce-subscriptions' ), '<a href="' . esc_url( apply_filters( 'woocommerce_subscriptions_message_store_url', get_permalink( wc_get_page_id( 'shop' ) ) ) ) . '">', '</a>' );
						endif; ?>
					</p>

				<?php endif; ?>

			</div>
			<div class="modal modal__cancel_subscription">
				<div class="modal__container">
					<h2 class="modal__title page-title"><?php _e('Are you sure?', 'woocommerce'); ?></h2>
					<p class="modal__description description"><?php _e('Är du säker på att du vill säga upp ditt förråd? Din sista hyresdag kommer att vara ', 'woocommerce'); ?><span class="modal_next_payment"></span></p>
					<div>
						<a href="#" data-act="" class="button cancel"><?php _e('Yes, i am sure', 'woocommerce'); ?></a>
						<a href="/my-account/subscriptions/" data-act="" class="button button__modal_close"><?php _e('cancel', 'woocommerce'); ?></a>
					</div>
					<div class="modal__close"></div>
				</div>
			</div>
			<div class="modal modal__reactivate_subscription">
				<div class="modal__container">
					<h2 class="modal__title page-title"><?php _e('Are you sure?', 'woocommerce'); ?></h2>
					<p class="modal__description description"><?php _e('Vill du fortsätta hyra ditt förråd?', 'woocommerce'); ?><span class="modal_next_payment"></span></p>
					<div>
						<a href="#" data-act="" class="button reactivate"><?php _e('Yes', 'woocommerce'); ?></a>
						<a href="/my-account/subscriptions/" data-act="" class="button button__modal_close"><?php _e('cancel', 'woocommerce'); ?></a>
					</div>
					<div class="modal__close"></div>
				</div>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('.cancel_subscription').click(function(event) {
						event.preventDefault();
						$('.modal__cancel_subscription').find('.modal_next_payment').text($(this).data('next_payment'));
						$('.modal__cancel_subscription').addClass('open').find('.button.cancel').attr({
							'href': $(this).attr('href'),
							'data-act': $(this).data('act')
						});
					});
					$('.reactivate_subscription').click(function(event) {
						event.preventDefault();
						$('.modal__reactivate_subscription').addClass('open').find('.button.reactivate').attr({
							'href': $(this).attr('href'),
							'data-act': $(this).data('act')
						});
					});
					$('.modal__close').click(function(event) {
						$('.modal').removeClass('open');
					});
				});
			</script>
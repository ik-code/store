<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$available_variations = $product->get_available_variations();
$available = false;
$product_class = 'swiper-slide';
foreach ($available_variations as $item) {
	if ($item['is_in_stock']) {
		$available = true;
		break;
	}
}
if (!$available) {
	$product_class .= ' move_down';
}
?>

<div <?php wc_product_class($product_class);?>>
	<div class="choose-unit__card card" data-squre="<?php echo $product->get_attribute('square'); ?>">
		<?php if($banner_image = get_field('banner_image', $product->get_id())){ ?>
			<div class="unit_banner unit_banner_position_<?php the_field('position', $product->get_id()); ?>">
				<img src="<?php echo $banner_image; ?>">
			</div>
		<?php } ?>
		<div class="card__container">
			<div class="card__image">
				<?php echo woocommerce_get_product_thumbnail(); ?>
				<!-- <div class="card__image-placeholder">
					<?php echo $product->get_attribute('square'); ?> <span>m<sup>2</sup></span>
				</div> -->
			</div>
			<div class="card__block">
				<span class="card__size"><?php echo $product->get_title(); ?></span>
				<span class="card__price"><?php echo $product->get_price(); ?> KR/MÅN</span>
			</div>
			<div>
				<ul class="size_list">
					<li>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/square.svg">
						<?php echo $product->get_attribute('cubic'); ?> m<sup>3</sup>	
					</li>
					<li>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/box.svg">
						x
						<?php echo $product->get_attribute('box'); ?>
					</li>
					<li>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mobile.svg">
					</li>
				</ul>
				<div class="card__block-more">
					Fler detaljer
				</div>
				
			</div>
		</div>

		<?php
		if ($product->is_type( 'variable' ) && $available) {

			$attributes = $product->get_variation_attributes();
			$attribute_keys = array_keys( $attributes );

			$variations_json = wp_json_encode( $available_variations );
			$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
			?>
			<form class="variations_form cart" action="<?php echo get_permalink($product->get_id()); ?>" method="post" enctype="multipart/form-data" data-product_id="<?php echo $product->get_id(); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
				<div class="card__description">
					<?php echo get_the_excerpt(); ?>
				</div>
				<div class="variations_form_attributes">
					<?php foreach ( $attributes as $attribute_name => $options ) : ?>
						<?php
						$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );

						$args = array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected );
						wc_dropdown_variation_attribute_options( $args );
						?>
					<?php endforeach; ?>
				</div>
				<div class="woocommerce-variation-add-to-cart variations_button">
					<button type="submit" class="card__button ajax_add_to_cart btn btn--black button">HYR FÖRRÅD</button>
					<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
					<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
					<input type="hidden" name="variation_id" class="variation_id" value="0" />
				</div>
			</form>
		<?php }else{ ?>
			<div class="variations_form">
				<div class="card__description">
					<?php echo get_the_excerpt(); ?>
				</div>
				<button type="submit" class="card__button ajax_add_to_cart btn btn--black button btn--disable" disabled="disabled">FULLT UTHYRT</button>
			</div>
		<?php } ?>

	</div>
</div>

<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */

// Template Name: Home page

get_header();

$post_id = $post->ID;

?>
<main class="home-page">
	<section class="hero">
		<div class="hero__container">
			<div class="hero__image-wrapper">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Garage.gif" alt="hero illustration" draggable="false" />
			</div>
			<div class="hero__text-wrapper">
				<h1 class="hero__title page-title"><?php the_field('hero_title', $post_id ); ?></h1>
				<p class="landing-hero__descr">
					<?php the_field('hero_description', $post_id ); ?>
				</p>

				<div class="hero__block-wrapper">
					<span class="hero__label">SE VÅRA PRISER:</span>
					<div class="hero__notification">
						Säkra betalningar med
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/klarna-icon.svg" alt="klarna icon" draggable="false" />
					</div>
				</div>

				<?php if($hero_products = get_field('products', $post_id ) ){ ?>
					<form class="hero__form" action="#">
						<select class="js-select" name="box-size">
							<option></option>
							<?php foreach ($hero_products as $hero_product) {
								$product = wc_get_product( $hero_product );
								?>
								<option value="<?php
								echo $product->get_title();
								?>" data-id="<?php
                                echo $hero_product; ?>" data-size="<?php
								echo $product->get_title(); ?>" data-price="<?php
								echo $product->get_price();
                                ?> KR/MÅN"> </option>
							<?php } ?>
						</select>
						<button  class="hero__button btn">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/bankID-black.png" alt="bankID icon">VÄLJ FÖRRÅD
						</button>
					</form>

					<script type="text/javascript">
						jQuery(document).ready(function($) {
							$(".hero__form").submit(function(event) {
								event.preventDefault();
								let product_id = $(this).find(':selected').data('id');
                                document.location.href = '/cart/?add-to-cart=' + product_id;
							});
						});
					</script>
				<?php } ?>
				<div class="hero__notification hero__notification--mobile">
					Säkra betalningar med
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/klarna-icon.svg" alt="klarna icon" draggable="false" />
				</div>
			</div>
		</div>
	</section>

	<?php echo get_template_part('inc/features'); ?>
	

	<section class="how-it-works">
		<h2 class="how-it-works__title page-title"><?php the_field('how_it_works_title', $post_id ); ?></h2>
		<p class="how-it-works__description description">
			<?php the_field('how_it_works_description', $post_id ); ?>
		</p>

		<?php if($how_it_works_blocks = get_field('block', $post_id )){ ?>
			<div class="how-it-works__swiper swiper-container">
				<div class="swiper-wrapper">
					<?php foreach ($how_it_works_blocks as $how_it_works_block) { ?>
						<div class="swiper-slide">
							<div class="how-it-works__block">
								<img class="how-it-works__block-image" src="<?php echo $how_it_works_block['image']; ?>" alt="<?php echo $how_it_works_block['title']; ?>" draggable="false" />
								<div>
									<h3 class="how-it-works__block-title"><?php echo $how_it_works_block['title']; ?></h3>
									<p class="how-it-works__block-text"><?php echo $how_it_works_block['text']; ?></p>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
		<?php } ?>
	</section>

	<section class="choose-unit">
		<div class="choose-unit__container">
			<h2 class="choose-unit__title page-title">Vilket förråd passar dig bäst?</h2>
			<p class="choose-unit__description description">
				Låt oss hjälpa dig att ta fram rätt förrådsutrymme baserat på hur stor yta du behöver förvara. Det förråd som passar bäst kommer att hamna först.
			</p>

			<div class="choose-unit__range">
				<p>Välj yta att förvara</p>
				<?php 
				$pa_square = get_terms(array(
					'orderby'     => 'name',
					'order'       => 'ASC',
					'taxonomy'    => 'pa_square',
					'fields' => 'names',
					'hide_empty' => false
				));
				sort($pa_square, SORT_NUMERIC); 
				?>
				<div id="slider" data-min_square="<?php echo $pa_square[0]; ?>" data-max_square="<?php echo $pa_square[count($pa_square)-1]; ?>"></div>
			</div>

			<?php  
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => 10,
				'meta_key' => 'pa_square',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => '_stock_status',
						'value' => 'instock'
					)
				)
			);
			$loop = new WP_Query( $args );
			?>
			<div class="choose-unit__card-wrapper">
				<div class="swiper-wrapper">
					<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product;
						$available_variations = $product->get_available_variations();
						$available = false;
						$product_attr = 'enable';
						foreach ($available_variations as $item) {
							if ($item['is_in_stock']) {
								$available = true;
								break;
							}
						}
						if (!$available) {
							$product_attr = "disabled";
						}
						?>
						<div class='swiper-slide'>
							<div class="choose-unit__card card" data-squre="<?php echo $product->get_attribute('square'); ?>" data-variations-status="<?php echo $product_attr;?>">
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
										<span class="card__size"><?php the_title(); ?></span>
										<span class="card__price"><?php
											echo $product->get_price();
                                            ?> KR/MÅN</span>
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
											<?php echo $post->post_excerpt; ?>
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
											<button type="submit" class="card__button ajax_add_to_cart skip_add_to_cart btn btn--black button">HYR FÖRRÅD</button>
											<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
											<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
											<input type="hidden" name="variation_id" class="variation_id" value="0" />
                                        </div>
									</form>
								<?php }else{
									echo '<button type="submit" class="card__button ajax_add_to_cart btn btn--black button btn--disable" disabled="disabled">FULLT UTHYRT</button>';
								} ?>
							</div>
						</div>
					<?php endwhile; wp_reset_query(); ?>
				</div>
				<div class="swiper-pagination-card"></div>
			</div>
			<div class="swiper-next"></div>
			<div class="swiper-prev"></div>

			<ul class="choose-unit__benefit-list">
				<li>Övervakat 24/7</li>
				<li>Öppet dygnet runt</li>
				<li>Värmeisolerat</li>
				<li>Ingen bindningstid</li>
			</ul>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$.each($('.variations_form'), function(index, val) {
					var form = $(this),
					product_variations = $(this).data('product_variations');
					$.each(product_variations, function(index, product_variation) {
						if(product_variation.is_in_stock){
							form.find('option[value="'+product_variation.attributes.attribute_pa_number+'"]').attr('selected', 'selected').attr('value','"'+product_variation.variation_id+'"');
                            form.find('input[name="add-to-cart"]').attr('value', product_variation.variation_id);
                            var product_id = form.find('input[name="product_id"]').val();
                            $.each($('.hero__form option[data-id]'), function () {
                                var hero__form = $(this);
                                if(hero__form.attr('data-id') === product_id){
                                    hero__form.attr('data-id', product_variation.variation_id);
                                }
                            });
							return false;
						}
					});
				});
			});
		</script>
	</section>



	<?php if($feedback_video = get_field('feedback_video', $post_id)){ ?>
		<section class="feedback">
			<div class="feedback__container">
				<video controls class="feedback__video">
					<source src="<?php echo $feedback_video; ?>" type="video/mp4">
					</video>
					<!-- <div class="feedback__background"></div> -->
				<!-- <div class="feedback__wrapper">
					<div class="feedback__image-block">
						<img class="feedback__image" src="<?php the_field('feedback_image', $post_id ); ?>" alt="<?php the_field('feedback_text', $post_id ); ?>" draggable="false">
					</div>
					<div class="feedback__text-block">
						<p class="feedback__text"><?php the_field('feedback_text', $post_id ); ?></p>
						<p class="feedback__author"><?php the_field('feedback_author', $post_id ); ?></p>
						<a class="feedback__button btn btn--black" href="<?php the_field('feedback_link', $post_id ); ?>">Se Videon</a>
					</div>
				</div> -->
			</div>
		</section>
	<?php } ?>
	<section class="benefit">
		<h2 class="benefit__title page-title"><?php the_field('benefit_title', $post_id ); ?></h2>
		<p class="benefit__description description"><?php the_field('benefit_description', $post_id ); ?></p>
		<ul class="benefit__list">
			<?php if($benefit_blocks = get_field('benefit_block', $post_id)){
				foreach ($benefit_blocks as $benefit_block) { ?>
					<li class="benefit__item">
						<div class="benefit__image-wrapper">
							<img class="benefit__image" src="<?php echo $benefit_block['image']; ?>" alt="<?php echo $benefit_block['title']; ?>">
						</div>
						<div class="benefit__text-wrapper">
							<h3 class="benefit__sub-title"><?php echo $benefit_block['title']; ?></h3>
							<p class="benefit__text"><?php echo $benefit_block['description']; ?></p>
						</div>
					</li>
				<?php }
			} ?>
		</ul>
	</section>
	<!-- container for google map api -->
	<section class="map" id="map"></section>
	<?php echo get_template_part('inc/call-request'); ?>
</main>
<?php
get_footer();

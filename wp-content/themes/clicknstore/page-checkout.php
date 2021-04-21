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

get_header('booking'); ?>

<main class="booking-final-page">
	<section class="booking-final">
		<div class="booking-final__form-header">
			<div class="booking-final-slider swiper-container">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<span>Ingen bindningstid</span>
					</div>
					<div class="swiper-slide">
							<span>Åtkomst direkt med mobilapp</span>
					</div>
					<div class="swiper-slide">
							<span>Try ggt och säkert</span>
					</div>
				</div>
			</div>
		</div>
		<?php
		while ( have_posts() ) :
			the_post();

			do_action( 'storefront_page_before' );

			get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop.
			?>

		</section>
	</main>

	<?php
	do_action( 'storefront_sidebar' );
	get_footer('booking');

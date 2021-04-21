<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package storefront
 */

get_header('booking'); ?>
<main>
	<section class="error_section">
		<div id="primary" class="content-area">
			<svg class="error_img" width="537" height="196" viewBox="0 0 537 196" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M80.5871 196V156.686H0V124.779L53.9139 0H101.018L45.4012 120.791H81.4384L93.6399 71.7907H124.286V120.791H145V156.686H124.286V196H80.5871Z" fill="#1B1B1B"/>
				<path d="M472.587 196V156.686H392V124.779L445.914 0H493.018L437.401 120.791H473.438L485.64 71.7907H516.286V120.791H537V156.686H516.286V196H472.587Z" fill="#1B1B1B"/>
				<path d="M313.906 5H227.066V48.4678H313.906V5Z" fill="#1B1B1B"/>
				<path d="M313.906 148.532H227.066V192H313.906V148.532Z" fill="#1B1B1B"/>
				<path d="M220.509 55.0324H177V141.79H220.509V55.0324Z" fill="#1B1B1B"/>
				<path d="M364.001 55.0324H320.492V141.79H364.001V55.0324Z" fill="#1B1B1B"/>
			</svg>
			<p class="error_text"><?php _e('Oops! Looks like this page doesn’t exist','woocommerce') ?></p>
		</div><!-- #primary -->
	</section>
	<?php echo get_template_part('inc/call-request'); ?>
</main>
<?php
get_footer();

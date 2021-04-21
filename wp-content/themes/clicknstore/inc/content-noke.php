<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="cabinet__user-info show data-tab" data-cabinet-tab="3">

	<?php
	$noke_page = get_page_by_path('noke');
	?>

	<div class="noke_step_title">
		<p><?php _e('Getting started with', 'woocommerce'); ?></p>
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/noke_logo.svg">
	</div>
	<div class="noke_steps">
		<?php foreach (get_field('noke_steps', $noke_page->ID) as $noke_step) { ?>
			<div class="noke_step">
				<div class="noke_step-image">
					<img src="<?php echo $noke_step['image']; ?>">
				</div>
				<div class="noke_step-description">
					<?php echo $noke_step['description']; ?>
				</div>
			</div>	
		<?php } ?>
		<?php if($app_title = get_field('app_title', $noke_page->ID)){ ?>
			<div class="noke_footer">
				<div class="noke_footer-title"><?php echo $app_title; ?></div>
				<div class="noke_footer-app"><a href="<?php the_field('app_store', $noke_page->ID); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/app_store.svg"></a></div>
				<div class="noke_footer-app"><a href="<?php the_field('google_play', $noke_page->ID); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/google_play.svg"></a></div>
			</div>
		<?php } ?>
	</div>
</div>
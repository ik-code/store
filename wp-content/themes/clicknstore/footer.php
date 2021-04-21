<?php $user_login = is_user_logged_in(); ?>
<footer class="footer">
	<div class="footer__wrapper">
		<div class="footer__logo-wrap">
			<a href="/">
				<img class="footer__logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="Click N Store logo" draggable="false" />
			</a>
		</div>
		<div class="footer__block-wrapper">
			<div class="footer__block">
				<h3 class="footer__block-title">Sitemap</h3>
				<?php 
				$menuParameters = array(
					'theme_location'  => 'primary',
					'container'       => false,
					'echo'            => false,
					'items_wrap'      => '%3$s',
					'depth'           => 0,
					'link_class'   => 'footer__block-link'
				);

				echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
				?>
			</div>
			<div class="footer__block">
				<h3 class="footer__block-title">Mina Sidor</h3>
				<a class="footer__block-link" href="<?php the_permalink( wc_get_page_id( 'shop' ) ); ?>">Hyr Förråd</a>
				<?php if(!$user_login){ ?>
				<a class="footer__block-link login" href="#"><?php _e('Logga in', 'woocommerce'); ?></a>
			<?php } else { ?>
				<a class="footer__block-link" href="<?php echo wp_logout_url(home_url()); ?>"><?php _e('Logout', 'woocommerce'); ?></a>
			<?php } ?>
			</div>
			<div class="footer__block">
				<h3 class="footer__block-title">Sociala Medier</h3>
				<?php if($facebook = get_field('facebook', 'option')){ ?>
					<a class="footer__block-link" href="<?php echo $facebook; ?>" target="_blank">Facebook</a>
				<?php } ?>
				<?php if($instagram = get_field('instagram', 'option')){ ?>
				<a class="footer__block-link" href="<?php echo $instagram; ?>" target="_blank">Instagram</a>
				<?php } ?>

			</div>
			<div class="footer__block">
				<h3 class="footer__block-title">Kontakt</h3>
				<a class="footer__block-link" href="mailto:support@clicknstore.se">support@clicknstore.se</a>
				<a class="footer__block-link" href="tel:+4631-99 00 69">031 - 99 00 69</a>
			</div>
		</div>
	</div>
	<div class="footer__container">
		<p class="footer__copyright">© 2020 Clicknstore AB</p>
		<div>
			<a class="footer__block-link" href="<?php echo get_privacy_policy_url(); ?>">Integritetspolicy</a>
			<a class="footer__block-link" href="<?php echo get_allmanna_villkor_url(); ?>">Allmänna Villkor</a>
			<a class="footer__block-link" href="<?php echo get_allmanna_villkor_url(); ?>">Allmänna Villkor</a>
		</div>
		<ul class="footer__list">
			<li class="footer__item">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/bankID.svg" alt="bankID icon" draggable="false" />
			</li>
			<li class="footer__item">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/american-express.svg" alt="bankID icon" draggable="false" />
			</li>
			<li class="footer__item">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/visa.svg" alt="visa icon" draggable="false" />
			</li>
			<li class="footer__item">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/master-card.svg" alt="master card icon" draggable="false" />
			</li>
			<li class="footer__item">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/klarna.svg" alt="klarna icon" draggable="false" />
			</li>
		</ul>
	</div>
</footer>

<?php echo get_template_part('inc/modals'); ?>

<?php wp_footer(); ?>

</body>
</html>

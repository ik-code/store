<footer class="footer footer--booking">
	<div class="footer__container">
		<p class="footer__copyright">© 2020 Clicknstore AB</p>
		<div>
			<a class="footer__block-link" href="<?php echo get_privacy_policy_url(); ?>">Integritetspolicy</a>
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

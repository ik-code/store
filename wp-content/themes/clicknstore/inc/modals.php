<div class="modal">
	<div class="modal__container">
		<h2 class="modal__title page-title">Logga in med BankID</h2>
		<p class="modal__description description">Redan kund? Avänd ditt personnummer nedan.</p>

		<?php echo do_shortcode('[bank_id_login]'); ?>

		<div class="modal__link">
			<a href="<?php the_permalink( wc_get_page_id( '#' ) ); ?>">Stäng (x)</a>
		</div>
		<div class="modal__close"></div>
	</div>
</div>
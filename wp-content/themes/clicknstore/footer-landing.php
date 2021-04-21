<footer class="landing-footer footer">
  <div class="footer__wrapper">
		<div class="footer__logo-wrap">
            <img class="footer__logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="Click N Store logo" draggable="false" />
		</div>
		<div class="footer__block-wrapper">
      <div class="footer__block">
        <h3 class="footer__block-title">E-mail:</h3>
        <a class="footer__block-link" href="mailto:contact@click.com">support@clicknstore.se</a>
      </div>
			<div class="footer__block">
        <h3 class="footer__block-title">Kontakt:</h3>
				<a class="footer__block-link" href="tel:031-313 45 71">031-313 45 71</a>
      </div>
      <div class="footer__block footer__block--social">
        <h3 class="footer__block-title">Sociala Medier:</h3>
        <div>
          <?php if($facebook = get_field('facebook', 'option')){ ?>
            <a class="footer__block-link" href="<?php echo $facebook; ?>" target="_blank">Facebook</a>
          <?php } ?>
          <?php if($instagram = get_field('instagram', 'option')){ ?>
          <a class="footer__block-link" href="<?php echo $instagram; ?>" target="_blank">Instagram</a>
          <?php } ?>
        </div>
      </div>
		</div>
	</div>
	<div class="footer__container">
		<p class="footer__copyright">© Clicknstore AB </p>
		<ul class="footer__list">
			<li class="footer__item">
                <?php if($footer_american_express = get_field('footer_american_express')){ ?>
				    <img src="<?php echo $footer_american_express;?>" alt="american express icon" draggable="false" />
                <?php } ?>
			</li>
            <li class="footer__item">
                <?php if($footer_bank_id = get_field('footer_bank_id')){ ?>
                    <img src="<?php echo $footer_bank_id;?>" alt="bankID icon" draggable="false" />
                <?php } ?>
            </li>
			<li class="footer__item">
                <?php if($footer_visa_icon = get_field('footer_visa_icon')){ ?>
				    <img src="<?php echo $footer_visa_icon;?>" alt="visa icon" draggable="false" />
                <?php } ?>
			</li>
			<li class="footer__item">
                <?php if($footer_master_card_icon = get_field('footer_master_card_icon')){ ?>
				    <img src="<?php echo $footer_master_card_icon;?>" alt="master card icon" draggable="false" />
                <?php } ?>
			</li>
			<li class="footer__item">
                <?php if($footer_klarna_icon = get_field('footer_klarna_icon')){ ?>
				    <img src="<?php echo $footer_klarna_icon;?>" alt="klarna icon" draggable="false" />
                <?php } ?>
			</li>
		</ul>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>

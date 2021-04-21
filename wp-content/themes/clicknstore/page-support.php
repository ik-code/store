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

// Template Name: Support page
get_header(); ?>


<?php 
$faq = get_field('theme_question', $post->ID);
$faq_count = 0;
?>
<main class="support-page">
	<section class="faq">
		<h2 class="faq__title page-title">Frågor & Svar</h2>
		<?php if($faq){ ?>
			<div class="faq__wrapper">
				<div class="faq__category">
					<p class="faq__category-label"></p>
					<div class="faq__category-title"><span class="faq__category-text"><?php echo $faq[0]['title']; ?></span><span class="faq__arrow-icon"></span></div>
					<ul class="faq__category-list">
						<?php foreach ($faq as $faq_theme) { ?>
							<li class="faq__category-item <?php echo $faq_count == 0 ? 'faq__category-item--active' : ''; ?>" data-category="<?php echo $faq_count++; ?>"><?php echo $faq_theme['title']; ?></li>
						<?php } $faq_count = 0; ?>
					</ul>
				</div>

				<div class="faq__answer">
					<?php foreach ($faq as $faq_theme) { ?>
						<div class="faq__answer-wrapper <?php echo $faq_count == 0 ? 'show' : ''; ?>" data-tab="<?php echo $faq_count++; ?>">
							<?php if(isset($faq_theme['question']) && !empty($faq_theme['question'])){ ?>
								<?php foreach ($faq_theme['question'] as $question) { ?>
									<div class="faq__item">
										<div class="faq__item-title">
											<h4><?php echo $question['question']; ?></h4>
											<div class="faq__arrow-icon"></div>
										</div>
										<div class="faq__description">
											<div class="faq__content">
												<?php echo $question['answer']; ?>
											</div>
										</div>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</section>

	<section class="contact-us">
		<div class="contact-us__container">
			<h2 class="contact-us__title page-title">Frågor?</h2>
			<p class="contact-us__descriction description">Behöver du mer hjälp eller vill ha ytterligare information? Tveka inte att kontakta oss! </p>
			<?php echo do_shortcode('[contact-form-7 id="81" title="Contact us" html_class="contact-us__form"]'); ?>
		</div>
	</section>


	<?php echo get_template_part('inc/call-request'); ?>
</main>
<?php
get_footer();

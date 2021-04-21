<section class="features">
	<?php if($features = get_field('features', 'option')){ ?>
		<ul class="features__list swiper-wrapper">
			<?php 
			foreach ($features as $feature) { ?>
			<li class="features__item swiper-slide">
				<img class="features__image" src="<?php echo $feature['image']; ?>" alt="<?php echo $feature['title']; ?>"
				draggable="false" />
				<?php echo $feature['title']; ?>
			</li>
			<?php } ?>
		</ul>
	<?php } ?>
</section>
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

// Template Name: How it works

get_header(); ?>
<main class="landing">
	<section class="landing-hero">
        <div class="landing-hero__container">
            <div class="landing-hero__text-block">
                <h2 class="landing-hero__title">
                    <?php if($header_title = get_field('header_title', $post->ID)) {?>
                        <?php echo $header_title; ?>
                    <?php } ?>
                </h2>
                <p class="landing-hero__descr">
                    <?php if($header_text = get_field('header_text', $post->ID)) {?>
                        <?php echo $header_text; ?>
                    <?php } ?>
                </p>
                <div class="landing-hero__klarna">
                    <span>
                        <?php if($header_footer_text = get_field('header_footer_text', $post->ID)) {?>
                            <?php echo $header_footer_text; ?>
                        <?php } ?>
                    </span>
                    <?php if($header_klarna_icon = get_field('header_klarna_icon', $post->ID)) {?>
                        <img src="<?php echo $header_klarna_icon; ?>" alt="klarna icon" draggable="false">
                    <?php } ?>
                </div>
                <div class="landing-hero__video-title-mobile">
                    <?php  if($video_title_mobile = get_field('video_title_mobile', $post->ID)) {?>
                        <?php  echo $video_title_mobile;?>
                    <?php  }?>
                </div>
            </div>
            <div class="landing-hero__video-wrapper">
                <div class="landing-hero__video-container">
                    <?php if($video = get_field('video', $post->ID)){ ?>
                    <video class="landing-hero__video">
                        <source src="<?php echo $video; ?>" type='video/mp4'>
                    </video>
                    <?php }?>
                    <?php if($landing_hero_video_title = get_field('landing_hero_video_title')) {?>
                    <img class="landing-hero__video-title" src="<?php echo $landing_hero_video_title; ?>" alt="video text" draggable="false">
                    <?php }?>
                    <button class="landing-hero__video-button" type="button">
                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.8999 10.359C19.5666 10.7439 19.5666 11.7062 18.8999 12.0911L2.13741 21.7689C1.47075 22.1538 0.637412 21.6727 0.637412 20.9029L0.637413 1.54719C0.637413 0.777394 1.47075 0.296267 2.13741 0.681167L18.8999 10.359Z" fill="white" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

		<section class="steps">
			<div class="section-title">
				Så här funkar det
			</div>
			<?php $step_count = 1;
			if($steps = get_field('steps', $post->ID)){
				foreach ($steps as $step) { ?>
					<div class="steps__block <?php echo !($step_count%2) ? 'steps__block--reverse' : ''; ?>">
						<div class="steps__text-block">
							<span class="steps__count"><?php echo $step_count; ?></span>
							<h3 class="steps__block-title"><?php echo $step['title']; ?></h3>
							<p class="steps__block-description"><?php echo $step['description']; ?></p>
						</div>
						<div class="steps__image-block">
							<img class="steps__image" src="<?php echo $step['image']; ?>" alt="<?php echo $step['title']; ?>"
							draggable="false" />
						</div>
					</div>
					<?php $step_count++; 
				}
			} ?>
		</section>


	<section class="advantages">
		<h2 class="advantages__title page-title">Mer än bara ett förråd</h2>
		<p class="advantages__description description">
			Hos Clicknstore® får du ut mer av ditt hyrda utrymme. Alla våra förråd är uppkopplade och styrs via vår
			mobilapp.
		</p>
		<?php if($advantages = get_field('advantages', $post->ID)){ ?>
			<ul class="advantages__list">
				<?php foreach ($advantages as $advantage) { ?>
					<li class="advantages__item">
						<img class="advantages__image" src="<?php echo $advantage['icon']; ?>" alt="<?php echo $advantage['title']; ?>"
						draggable="false" />
						<h3 class="advantages__item-title"><?php echo $advantage['title']; ?></h3>
						<p class="advantages__item-text"><?php echo $advantage['text']; ?></p>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</section>
	
	<?php echo get_template_part('inc/call-request'); ?>
</main>
<?php
get_footer();

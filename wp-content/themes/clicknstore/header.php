<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>

	<?php $user_login = is_user_logged_in(); ?>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-WC6DJB8');
    </script>
    <!-- End Google Tag Manager -->
    <!-- Help Scout-->
    <script type="text/javascript">!function(e,t,n){function a(){var e=t.getElementsByTagName("script")[0],n=t.createElement("script");n.type="text/javascript",n.async=!0,n.src="https://beacon-v2.helpscout.net",e.parentNode.insertBefore(n,e)}if(e.Beacon=n=function(t,n,a){e.Beacon.readyQueue.push({method:t,options:n,data:a})},n.readyQueue=[],"complete"===t.readyState)return a();e.attachEvent?e.attachEvent("onload",a):e.addEventListener("load",a,!1)}(window,document,window.Beacon||function(){});</script>
	<script type="text/javascript">window.Beacon('init', '89c2a71a-877b-40b2-a9af-8663c200e7e2')</script>
	<!-- End Help Scout-->
</head>
<body <?php body_class(); ?>>

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WC6DJB8" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

	<?php do_action( 'storefront_before_site' ); ?>
	<header class="header <?php echo $user_login ? "header--login" : ""; ?>">
		<div class="header__container">
			<div class="header__inner">
				<div class="header__logo-wrap">
					<a href="<?php echo home_url(); ?>">
						<svg class="header__logo" width="170" height="30" viewBox="0 0 170 30" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M89.1225 0H75.1722V6.98006H89.1225V0Z" fill="black" />
							<path d="M89.1225 23.0484H75.1722V30.0285H89.1225V23.0484Z" fill="black" />
							<path d="M74.1165 8.03418H67.1271V21.9658H74.1165V8.03418Z" fill="black" />
							<path d="M97.1675 8.03418H90.1781V21.9658H97.1675V8.03418Z" fill="black" />
							<path d="M6.27641 9.20232C5.33498 9.20232 4.93558 9.85759 4.93558 11.0257V19.0314C4.93558 20.3134 5.42056 20.8547 6.27641 20.8547C7.13226 20.8547 7.73135 20.228 7.67429 17.8348H12.41C12.5812 24.473 9.10071 25.869 6.30494 25.869C5.42041 25.9333 4.53269 25.7988 3.70706 25.4754C2.88143 25.152 2.1389 24.6479 1.53406 24.0001C0.929227 23.3524 0.477475 22.5775 0.212029 21.7324C-0.0534169 20.8873 -0.125805 19.9936 0.00018844 19.1169V10.9117C-0.125043 10.0338 -0.0523393 9.13904 0.212989 8.29277C0.478317 7.44651 0.929569 6.67011 1.53379 6.02028C2.13801 5.37045 2.87994 4.86361 3.7054 4.53676C4.53085 4.20992 5.41899 4.07132 6.30494 4.1311C9.15776 4.1311 12.5241 5.49862 12.41 11.8519H7.67429C7.73135 9.85759 7.2749 9.20232 6.27641 9.20232Z"
							fill="black" />
							<path d="M14.2641 4.75781H19.0568V20.3134H24.1349V25.2421H14.2641V4.75781Z" fill="black" />
							<path d="M25.6754 4.75781H30.6393V25.2421H25.6754V4.75781Z" fill="black" />
							<path d="M38.8272 9.20226C37.8573 9.20226 37.4579 9.85753 37.4579 11.0256V19.0313C37.4579 20.3134 37.9428 20.8547 38.8272 20.8547C39.7116 20.8547 40.2822 20.2279 40.2251 17.8347H44.9608C45.1034 24.4729 41.623 25.8689 38.8557 25.8689C37.9689 25.9378 37.078 25.8066 36.2487 25.4852C35.4195 25.1638 34.6733 24.6603 34.0652 24.012C33.4571 23.3637 33.0027 22.5871 32.7357 21.7398C32.4686 20.8925 32.3958 19.996 32.5225 19.1168V10.9117C32.3966 10.0312 32.4698 9.13377 32.7367 8.28527C33.0036 7.43677 33.4575 6.65876 34.0649 6.00839C34.6724 5.35802 35.418 4.85181 36.2471 4.52694C37.0761 4.20206 37.9675 4.06679 38.8557 4.13104C41.7086 4.13104 45.0749 5.49856 44.9608 11.8518H40.2251C40.2822 9.85753 39.9398 9.20226 38.8272 9.20226Z"
							fill="black" />
							<path d="M51.779 15.2421V25.2421H46.701V4.75781H51.6364V13.3048L54.4892 4.75781H59.9096L56.6003 13.9031L60.7369 25.1282H55.1739L51.779 15.2421Z"
							fill="black" />
							<path d="M80.9064 14.8148V21.2536H78.0535V8.74646H81.2487L83.5024 14.5869V8.74646H86.3553V21.2536H83.2742L80.9064 14.8148Z"
							fill="black" />
							<path d="M107.124 16.3533C105.977 15.6856 105.03 14.7227 104.383 13.5651C103.736 12.4075 103.411 11.0976 103.444 9.77207C103.462 8.98752 103.638 8.21459 103.961 7.49946C104.285 6.78432 104.749 6.14164 105.327 5.6098C105.905 5.07796 106.584 4.66786 107.324 4.404C108.064 4.14014 108.85 4.02793 109.635 4.07407C112.687 4.07407 115.768 5.75498 115.626 11.339H111.261C111.261 9.48717 110.89 8.49002 109.749 8.49002C109.563 8.46387 109.373 8.47975 109.194 8.53651C109.015 8.59327 108.851 8.68945 108.714 8.81796C108.577 8.94648 108.471 9.10404 108.403 9.27904C108.335 9.45403 108.308 9.64199 108.322 9.82905C108.347 10.2442 108.471 10.6472 108.685 11.0042C108.898 11.3612 109.195 11.6617 109.549 11.8803L112.402 13.9031C113.435 14.532 114.285 15.421 114.865 16.481C115.446 17.5411 115.738 18.7349 115.711 19.943C115.72 20.7481 115.564 21.5466 115.25 22.2886C114.937 23.0306 114.475 23.7004 113.892 24.2562C113.308 24.812 112.617 25.2421 111.86 25.5195C111.103 25.7969 110.297 25.9159 109.492 25.8689C106.211 25.8689 103.187 24.131 103.33 18.6325H107.723C107.723 20.5983 108.208 21.4815 109.321 21.4815C109.521 21.5097 109.724 21.487 109.913 21.4155C110.102 21.344 110.27 21.2261 110.401 21.0726C110.531 20.9191 110.621 20.7351 110.662 20.5376C110.703 20.3402 110.693 20.1356 110.633 19.943C110.633 19.4872 110.633 18.7749 109.406 17.8917L107.124 16.3533Z"
							fill="black" />
							<path d="M116.767 4.75781H128.863V9.54414H125.354V25.2421H120.39V9.54414H116.767V4.75781Z" fill="black" />
							<path d="M130.146 11.0257C130.146 9.28021 130.841 7.60626 132.076 6.37205C133.312 5.13783 134.988 4.44446 136.736 4.44446C138.484 4.44446 140.16 5.13783 141.396 6.37205C142.632 7.60626 143.326 9.28021 143.326 11.0257V19.0029C143.326 20.7483 142.632 22.4223 141.396 23.6565C140.16 24.8907 138.484 25.5841 136.736 25.5841C134.988 25.5841 133.312 24.8907 132.076 23.6565C130.841 22.4223 130.146 20.7483 130.146 19.0029V11.0257ZM138.362 11.0257C138.362 9.62964 137.621 9.05984 136.736 9.05984C135.852 9.05984 135.082 9.62964 135.082 11.0257V18.9174C135.082 20.2849 135.852 20.8262 136.736 20.8262C137.621 20.8262 138.362 20.2849 138.362 18.9174V11.0257Z"
							fill="black" />
							<path d="M145.295 25.2421V4.75781H151.2C155.993 4.75781 157.476 7.60682 157.476 10.1709C157.46 11.1178 157.186 12.0425 156.684 12.8456C156.181 13.6487 155.469 14.2999 154.624 14.7293C155.561 15.0398 156.36 15.6688 156.882 16.5069C157.403 17.345 157.613 18.3391 157.476 19.3162V25.0142H152.798V19.3162C152.798 17.9487 152.341 17.2649 151.115 17.2649H150.259V24.9572L145.295 25.2421ZM150.259 13.1054H150.972C152.199 13.1054 152.684 12.2507 152.684 10.9971C152.684 9.74357 152.17 9.14528 151.058 9.14528H150.259V13.1054Z"
							fill="black" />
							<path d="M159.502 4.75781H169.886V9.6581H164.466V12.2792H169.629V16.8946H164.466V20.3134H170V25.2421H159.502V4.75781Z"
							fill="black" />
						</svg>
					</a>
				</div>
				<div class="header__nav-wrap">

					<ul class="header__nav-list">
						<?php 
						wp_nav_menu( [
							'theme_location'  => 'primary',
							'menu'            => '', 
							'container'       => '', 
							'container_class' => '', 
							'container_id'    => '',
							'menu_class'      => 'menu', 
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '%3$s',
							'depth'           => 0,
							'walker'          => '',
						] );
						?>
						<?php if(!$user_login){ ?>
							<li class="header__nav-item login">
								<a href="#">Logga in</a>
							</li>
							<li class="header__nav-item header__nav-item--button">
								<a class="header__btn btn" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
									Hyr Förråd
								</a>
							</li>
						<?php }else{ ?>
                            <li class="header__nav-item header__nav-item--mobile">
                                <a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' )); ?>">Mina Sidor</a>
                            </li>
							<li class="header__nav-item header__nav-item--mobile">
								<a href="<?php echo wp_logout_url(home_url()); ?>">Logga ut</a>
							</li>
							<li class="header__nav-item header__nav-item--desktop">
								<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/user-loggin.svg" alt="user icon" draggable="false">
								</a>
							</li>
							<li class="header__nav-item header__nav-item--button">
								<a class="header__btn btn" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
									Hyr Förråd
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
				<div class="header__mobile-menu">
					<div class="header__mobile-menu-icon"></div>
				</div>
			</div>
		</div>
	</header>

    <?php
    $message = get_field('message_body', 'option');
    if ($message && get_field('show_popup', 'option')) { ?>
        <?php if ( !isset($_COOKIE["hide_popup"]) || ($_COOKIE["hide_popup"] !== wp_strip_all_tags($message)) ) {
            setcookie('hide_popup', null, -1, '/');?>

            <div class="header_popup_message" style="display: none;">
                <?php echo $message; ?>
                <svg width="12" height="12" class="close_header_popup_message" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99934 7.41355L10.5824 11.9966L11.9966 10.5824L7.41355 5.99934L11.9977 1.41523L10.5835 0.00101644L5.99934 4.58513L1.41421 0L0 1.41421L4.58513 5.99934L0.00109005 10.5834L1.4153 11.9976L5.99934 7.41355Z" fill="white"/>
                </svg>
                <script type="text/javascript">
                    jQuery(document).ready(function($) {

                        function set_popup_cookie() {
                           Date.prototype.addDays = function(days) {
                               var date = new Date(this.valueOf());
                               date.setDate(date.getDate() + days);
                               return date;
                           };
                           var date = new Date();
                            document.cookie = "hide_popup=<?php echo urlencode(wp_strip_all_tags($message))?>;domain="+window.location.hostname+";path=/;expires=" + date.addDays(780).toUTCString();

                            console.log(document.cookie);
                        }

                        $('.header_popup_message').delay(2000).slideDown('400');
                        $('.close_header_popup_message').click(function(event) {
                            $(".header_popup_message").slideUp(400);
                            set_popup_cookie();
                        });
                    });
                </script>
            </div>

        <?php } ?>
    <?php } ?>
    <?php if(isset($_COOKIE['add_to_catr_time']) && $message = get_field('popup_message', 'option')){ ?>
		<div class="header_cart_timer" style="display: none;">
			<p>
                <?php
                    $confirm = '<a href="' . get_permalink( wc_get_page_id( "checkout" ) ) . '">' . get_field('confirm_link', 'option') .'</a>';
                    $timer = '<span class="header_final__timer" data-timer="' . $_COOKIE["add_to_catr_time"] . '"><span class="header_final__time"></span></span>';
                    $cancel = '<a href="#" class="clear_cart">' . get_field('cancel_link', 'option') . '</a>';

                    $confirm_replace = str_replace("#confirm_link", $confirm, $message);
                    $timer_replace = str_replace("#timer", $timer, $confirm_replace);
                    $cancel_replace = str_replace("#cancel_link", $cancel, $timer_replace);

                    echo $cancel_replace;
                ?>
			</p>
			<svg width="12" height="12" class="close_header_cart_timer clear_cart" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M5.99934 7.41355L10.5824 11.9966L11.9966 10.5824L7.41355 5.99934L11.9977 1.41523L10.5835 0.00101644L5.99934 4.58513L1.41421 0L0 1.41421L4.58513 5.99934L0.00109005 10.5834L1.4153 11.9976L5.99934 7.41355Z" fill="white"/>
			</svg>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					var date_now = new Date().getTime();
					var cart_created = <?php echo $_COOKIE['add_to_catr_time'] ? $_COOKIE['add_to_catr_time'] : '0'; ?>;
					var time_left = date_now - cart_created;
					var ms = time_left % 1000;
					var s = (time_left - ms) / 1000;
					$('.header_final__timer').attr("data-timer", s);

					var thirtyMinutes = 60 * 30;
					var timerElement = document.querySelector('.header_final__time');

					$('.header_cart_timer').delay(2000).slideDown('400');
					startHeaderTimer(thirtyMinutes, timerElement);

					function startHeaderTimer(duration, display) {
						var timer = duration - $('.header_final__timer').data('timer');
						var minutes,
						seconds;

						setInterval(function () {
							minutes = parseInt(timer / 60, 10);
							seconds = parseInt(timer % 60, 10);
							minutes = minutes < 10 ? '0' + minutes : minutes;
							seconds = seconds < 10 ? '0' + seconds : seconds;
							display.textContent = minutes + ' : ' + seconds;

							if (--timer < 0) {
								ajax_clear_cart();
								return false;
							}
						}, 1000);
					}
					$('.clear_cart').click(function(event) {
						event.preventDefault();
						ajax_clear_cart();
					});
					$('.close_header_cart_timer').click(function(event) {
						$(".header_cart_timer").slideUp(400);
					});
					function ajax_clear_cart(){
						$.ajax({
							url : '/wp-admin/admin-ajax.php',
							type: 'POST',
							data : {
								action : 'ajax_clear_cart'
							},
						})
						.done(function() {
							console.log("cart is clear");
						})
						.fail(function() {
							console.log("cart error");
						})
						.always(function() {
							console.log("cart complete");
							$(".header_cart_timer").slideUp(400,function(){
								$(this).remove();
							});
						});
					}
				});
			</script>
		</div>
		<?php } ?>
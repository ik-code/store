<form class="modal__form modal__form--bankID" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<div class="modal__wrapper">
		<input class="modal__input" type="text" name="personal_number" placeholder="ÅÅÅÅMMDD-NNNN">
	</div>
	<button class="modal__button btn btn--black" name="submit"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/bankID-black.png" alt="bankID icon">LOGGA IN</button>
</form>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.modal__form--bankID').submit(function(event) {
			event.preventDefault();

			var personalNumber = $('.modal__form--bankID').find('input[name="personal_number"]').val();

			$.ajax({
				url : '/wp-admin/admin-ajax.php',
				type: 'POST',
				data : {
					action : 'check_user',
					personalNumber : personalNumber
				},
			})
			.done(function(data) {
				console.log("success");
				if(data){
					window.location.replace("<?php echo get_permalink( get_page_by_path( 'bank-id-login' ) ); ?>");
				}else{
					window.location.replace("<?php echo get_permalink( get_page_by_path( 'shop' ) ); ?>");
				}
			})
			.fail(function() {
				console.log("error");
			})
			.always(function(data) {
				console.log("complete");
			});
			
		});
	});
</script>
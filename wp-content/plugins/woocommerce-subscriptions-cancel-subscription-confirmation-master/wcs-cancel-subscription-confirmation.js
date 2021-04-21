jQuery(document).ready(function($) {
	$('.button.cancel, .modal .button.reactivate').click(function(e) {
		e.preventDefault();
		var cancelURL = jQuery(this).attr("href");
		var actButton = jQuery(this).data("act");
		var subscription_id = $.urlParam('subscription_id', cancelURL);

			var data = {
				'action': 'wcs_cancel_confirmation',
				'subscription_id': subscription_id,
				'act_button': actButton
			};

			$.ajax({
				url: ajax_object.ajax_url,
				type: 'POST',
				data: data,
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				document.location.reload(true);
				console.log("complete");
			});
	});
})

jQuery.urlParam = function(name, url) {
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
	return results[1] || 0;
}
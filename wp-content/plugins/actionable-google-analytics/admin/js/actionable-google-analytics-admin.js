(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
jQuery(document).ready(function(){
	jQuery('.gad_label, .fb_label, .google_optimize_label').popover({
		trigger:'hover',
		html:true,
		delay: {"hide":1000},
		offset: '1100px 10px',
	});
	//Adwords Conversion
	let  t_ga_chk=jQuery("#ga_adwords").is(":checked");
	if(t_ga_chk == true){
		jQuery('#ga_adwords_data, #ga_adwords_label').show();
	}
	else{
		jQuery('#ga_adwords_data, #ga_adwords_label').hide();
	}
	jQuery("#ga_adwords").live("change",function(){
		let t_ga_chk=jQuery(this).is(":checked");
		if(t_ga_chk){
			 jQuery("#ga_adwords_data, #ga_adwords_label").show();
		}else{
				jQuery("#ga_adwords_data, #ga_adwords_label").hide();
				let t_display_chk=jQuery("#ga_adwords_data, #ga_adwords_label").is(":checked");
				if(t_display_chk){
					jQuery("#ga_adwords_data, #ga_adwords_label").removeAttr("checked");
				}
		}
	});
	//Fb Pixel, Google Optimize, GA promotion 
	let  t_fb_chk=jQuery("#fb_pixel, #ga_optimize, #ga_InPromo").is(":checked");
	if(t_fb_chk == true){
		jQuery('#fb_pixel_data, .fb_span, #ga_optimize_data, #ga_InPromoData, #ga_optimize_delay, #ga_hide_snippet, label[for="ga_hide_snippet"]').show();
	}
	else{
		jQuery('#fb_pixel_data, .fb_span, #ga_optimize_data, #ga_InPromoData, #ga_optimize_delay, #ga_hide_snippet, label[for="ga_hide_snippet"]').hide();
	}
	jQuery("#fb_pixel, #ga_optimize, #ga_InPromo").live("change",function(){
		let t_fb_chk=jQuery(this).is(":checked");

		if(t_fb_chk){
				let t_snippet = jQuery(".ga_hide_snippet").is(":checked");
				if(t_snippet == true){
					jQuery('#ga_optimize_delay').hide();
				}
				else{
					jQuery('#ga_optimize_delay').show();
				}
			 jQuery("#fb_pixel_data, .fb_span, #ga_optimize_data, #ga_InPromoData, #ga_hide_snippet, label[for='ga_hide_snippet']").show();
		}else{
				jQuery("#fb_pixel_data, .fb_span, #ga_optimize_data, #ga_InPromoData, #ga_optimize_delay, #ga_hide_snippet,  label[for='ga_hide_snippet']").hide();
				let t_fb_display_chk=jQuery("#fb_pixel_data, #ga_optimize_data, #ga_InPromo").is(":checked");
				if(t_fb_display_chk){
					jQuery("#fb_pixel_data, #ga_optimize_data, #ga_InPromoData, #ga_optimize_delay, #ga_hide_snippet,  label[for='ga_hide_snippet']").removeAttr("checked");
				}
		}
	});
	
	let t_snippet = jQuery(".ga_hide_snippet").is(":checked");
	if(t_snippet == true){
		jQuery('#ga_optimize_delay').hide();
	}
	else{
		let t_optimize = jQuery("#ga_optimize_data").is(":checked");
		if(t_optimize == false && t_fb_chk == false ){
			jQuery('#ga_optimize_delay').hide();
		}
		else{
			jQuery('#ga_optimize_delay').show();
		}
	}
	jQuery(".ga_hide_snippet").live("change",function(){
		let t_page_hide_chk=jQuery(this).is(":checked");
		if(t_page_hide_chk){
			jQuery("#ga_optimize_delay").hide();
		}else{
				jQuery("#ga_optimize_delay").show();
		}
	});
	jQuery(".month_report").hide();
	jQuery(".ecom_report").show();
	jQuery("a[href*='#ecommerce_report']").addClass("active");
	jQuery("a[href*='#ecommerce_report']").on("click",function(){
		jQuery(".ecom_report").show();
		jQuery("a[href*='#ecommerce_report']").addClass("active");
		jQuery("a[href*='#monthly_report']").removeClass("active");
		jQuery(".month_report").hide();
	});
	jQuery("a[href*='#monthly_report']").on("click",function(){
		jQuery(".ecom_report").hide();
		jQuery("a[href*='#ecommerce_report']").removeClass("active");
		jQuery("a[href*='#monthly_report']").addClass("active");
		jQuery(".month_report").show();
	});
});

	
})( jQuery );

function kingkongthemes_theme_option_reset_CLICK(){
    jQuery('input:radio[name="flx-select-footer-choice"][value="f_dark"]').prop('checked', true);  
    
    kingkongthemes_footer_CHANGE('f_dark');    
    
    return false;
}

jQuery(document).ready(function($) {     
	kingkongthemes_style_switch_INIT();
	jQuery('.choose-color a.indigo').addClass('active');
	// jQuery('input:radio[name="flx-select-footer-choice"][value="f_dark"]').prop('checked', true);
	// jQuery('input:radio[name="flx-select-style-choice"][value="light"]').prop('checked', true);
});

function kingkongthemes_style_switch_INIT(){
		
	jQuery('.choose-color a').on("click", function(e){
		var color = jQuery(this).attr('class');
		color = color.replace('color ', '');

		// Color Change
		jQuery("#theme-colors-css" ).attr("href", site_url + "assets/css/skin/"+ color +".css");

		// Logo Change
		jQuery(".k2t-header .k2t-logo img").attr("src", site_url + "assets/img/logo/logo-"+ color +".png");

		e.preventDefault();
		jQuery(this).parent().parent().find('a').removeClass('active');
		jQuery(this).addClass('active');


	});
	
	jQuery("#flx-select-dark-style").on("click", function(){
		jQuery("#theme-template-css" ).attr("href", site_url + "/assets/css/skin/dark.css");
		jQuery('.flx-select-footer').hide();
	});
	
	jQuery("#flx-select-light-style" ).on("click", function(){
		jQuery("#theme-template-css" ).attr("href", "");
		jQuery('.flx-select-footer').show();
	});

	jQuery("#flx-select-footer-light").on("click", function(){
		kingkongthemes_footer_CHANGE('f_light');
	});

	jQuery("#flx-select-footer-dark").on("click", function(){
		kingkongthemes_footer_CHANGE('f_dark');
	});
	
	jQuery(window).load(function($) {	
		// Switcher Layout
		jQuery('#theme-option').animate({
			left: '-275px'
		});
			
		jQuery('.open-close-button').on("click", function(e){
			e.preventDefault();
			var div = jQuery('#theme-option');
			if (div.css('left') === '-275px') {
				jQuery('#theme-option').animate({
					left: '0px'
				}); 
			} else {
				jQuery('#theme-option').animate({
					left: '-275px'
				});
			}
		});
	});
		
	// Reset
	jQuery('a.reset').on("click", function(e){
		jQuery('.color.oran').trigger('click');
		jQuery('#flx-select-light-style').trigger('click');
		jQuery('.theme-opt-wrapper select[name=layout]').val('f_dark');	
	});				    
}

function kingkongthemes_footer_CHANGE(val){
	if('f_light' == val){
		jQuery('body').addClass('light-footer');
	}else{
		jQuery('body').removeClass('light-footer');		
	}
}
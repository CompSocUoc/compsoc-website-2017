/**
 * SMOF js
 *
 * contains the core functionalities to be used
 * inside SMOF
 */

jQuery.noConflict();

/** Fire up jQuery - let's dance! 
 */
jQuery( window ).load(function() {
	if (jQuery.fn.isotope) { 
		jQuery(".k2t-theme-versions").isotope({ 
			itemSelector: '.theme-ver'
		});
	}
	if(jQuery( "#section-enable_menu_header_section .switch-options > label" ).attr( "class" ) == "cb-enable selected"){
		jQuery( ".k2t_header_options_feature_custom_menu" ).css( "display","block" );
	}else{
		//jQuery( ".k2t_header_options_feature_custom_menu" ).css( "display", "none" );
		jQuery( "#header_option_popup_for_header_section_2 .k2t_header_options_feature_custom_menu" ).css( "display", "block" );
	}

	jQuery( "#section-enable_menu_header_section .switch-options > label " ).bind( 'click', function(){
		if( jQuery( "#section-enable_menu_header_section .switch-options > label " ).attr( "class" ) == "cb-enable selected" ){
			jQuery( ".k2t_header_options_feature_custom_menu" ).css( "display", "block" );
		}else{
			jQuery( ".k2t_header_options_feature_custom_menu" ).css( "display", "none" );
			jQuery( "#header_option_popup_for_header_section_2 .k2t_header_options_feature_custom_menu" ).css( "display", "block" );
		}
	});
});
jQuery(function() {
	/* Open Setting All */
	function theme_options_display_all(){
		jQuery( '.k2t_header_options_popup_content_list' ).css( 'display', 'block ');
		jQuery( '.k2t_header_options_feature_wp_editor_params' ).css( 'display', 'block ');
		jQuery( '.k2t_header_options_feature_search_box_params' ).css( 'display', 'block ');
		jQuery( '.k2t_header_options_feature_social_params' ).css( 'display', 'block ');
		jQuery( '.k2t_header_options_feature_custom_menu_params' ).css( 'display', 'block ');
		jQuery( '.k2t_header_options_feature_cart_params' ).css( 'display', 'block ');
		jQuery( '.k2t_header_options_feature_widget_params' ).css( 'display', 'block ');
		jQuery( '.k2t_header_options_feature_setting_params' ).css( 'display', 'block ');
	}
	/* hidden all */
	function theme_options_hidden_all(){
		jQuery( '.k2t_header_options_popup_content_list' ).css( 'display', 'none' );
		jQuery( '.k2t_header_options_feature_wp_editor_params' ).css( 'display', 'none' );
		jQuery( '.k2t_header_options_feature_search_box_params' ).css( 'display', 'none' );
		jQuery( '.k2t_header_options_feature_social_params' ).css( 'display', 'none' );
		jQuery( '.k2t_header_options_feature_custom_menu_params' ).css( 'display', 'none' );
		jQuery( '.k2t_header_options_feature_cart_params' ).css( 'display', 'none' );
		jQuery( '.k2t_header_options_feature_widget_params' ).css( 'display', 'none' );
		jQuery( '.k2t_header_options_feature_setting_params' ).css( 'display', 'none' );
	}
	/* Set for col and current_item*/
	function k2t_clear_attr_header_popup(){
		jQuery( '.header_option_popup' ).removeAttr( 'current-columns' );
		jQuery( '.header_option_popup' ).removeAttr( 'current-item-id' );
		jQuery( '.header_option_popup' ).removeAttr( 'current-setting' );
	}
		
	/* CANCEL AND CALL ACTION CANCEL */
	jQuery( '.k2t_header_option_popup_control_close,.k2t_header_option_popup_control_cancel' ).on( 'click', function(){
		jQuery( '.header_option_popup' ).css( 'display', 'none' );
		theme_options_hidden_all();
	});

	/* DELETE AND CALL ACTION DELETE */
	jQuery( '.k2t_header_option_popup_control_delete' ).on( 'click', function(){
		jQuery( '.header_option_popup' ).css( 'display', 'none' );
		theme_options_hidden_all();
	});
	
});
jQuery(document).ready(function($){
	
	//(un)fold options in a checkbox-group
	jQuery('.fld').click(function() {
		var $fold='.f_'+this.id;
		$($fold).slideToggle('normal', "swing");
	});

	// toggle of-nav mobile 

	$('.hamburger').on('click', function(e){
		e.stopPropagation();
		$(this).toggleClass('is-active');
		$('#of-nav').toggleClass('is-active');
	});

	$('#of-nav a').on('click', function(e) {
		e.stopPropagation();
		$('.hamburger, #of-nav').toggleClass('is-active');
	});
	$('#of-nav, #of-nav *').on('click',function(e){
		e.stopPropagation();
	});
	$('body').on('click',function(){
		$('.hamburger, #of-nav').removeClass('is-active');
	});

	

	//Color picker
	$('.of-color').wpColorPicker();
	
	//hides warning if js is enabled			
	$('#js-warning').hide();
	
	//Tabify Options			
	$('.group').hide();
	
	// Get the URL parameter for tab
	function getURLParameter(name) {
		return decodeURI(
			(RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,''])[1]
		);
	}
	
	// If the $_GET param of tab is set, use that for the tab that should be open
	if (getURLParameter('tab') != "") {
		$.cookie('of_current_opt', '#'+getURLParameter('tab'), { expires: 7, path: '/' });
	}

	// Display last current tab	
	if ($.cookie("of_current_opt") === null) {
		$('.group:first').fadeIn('fast');	
		$('#of-nav li:first').addClass('current');
	} else {
	
		var hooks = $('#hooks').html();
		hooks = jQuery.parseJSON(hooks);
		
		$.each(hooks, function(key, value) { 
		
			if ($.cookie("of_current_opt") == '#of-option-'+ value) {
				$('.group#of-option-' + value).fadeIn();
				$('#of-nav li.' + value).addClass('current');
			}
			
		});
	
	}
				
	//Current Menu Class
	$('#of-nav li a').click(function(evt){
	// event.preventDefault();
				
		$('#of-nav li').removeClass('current');
		$(this).parent().addClass('current');
							
		var clicked_group = $(this).attr('href');
		
		$.cookie('of_current_opt', clicked_group, { expires: 7, path: '/' });
			
		$('.group').hide();
							
		$(clicked_group).fadeIn('fast');
		return false;
						
	});

	//Expand Options 
	var flip = 0;
				
	$('#expand_options').click(function(){
		if(flip == 0){
			flip = 1;
			$('#of_container #of-nav').hide();
			$('#of_container #content').width(755);
			$('#of_container .group').add('#of_container .group h2').show();
	
			$(this).removeClass('expand');
			$(this).addClass('close');
			$(this).text('Close');
					
		} else {
			flip = 0;
			$('#of_container #of-nav').show();
			$('#of_container #content').width(595);
			$('#of_container .group').add('#of_container .group h2').hide();
			$('#of_container .group:first').show();
			$('#of_container #of-nav li').removeClass('current');
			$('#of_container #of-nav li:first').addClass('current');
					
			$(this).removeClass('close');
			$(this).addClass('expand');
			$(this).text('Expand');
				
		}
			
	});
	
	//Update Message popup
	$.fn.center = function () {
		this.animate({"top":( $(window).height() - this.height() - 200 ) / 2+$(window).scrollTop() + "px"},100);
		this.css("left", 250 );
		return this;
	}
		
			
	$('#of-popup-save').center();
	$('#of-popup-reset').center();
	$('#of-popup-fail').center();
			
	$(window).scroll(function() { 
		$('#of-popup-save').center();
		$('#of-popup-reset').center();
		$('#of-popup-fail').center();
	});
			

	//Masked Inputs (images as radio buttons)
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});
	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();
	
	//Masked Inputs (background images as radio buttons)
	$('.of-radio-tile-img').click(function(){
		$(this).parent().parent().find('.of-radio-tile-img').removeClass('of-radio-tile-selected');
		$(this).addClass('of-radio-tile-selected');
	});
	$('.of-radio-tile-label').hide();
	$('.of-radio-tile-img').show();
	$('.of-radio-tile-radio').hide();

	// Style Select
	(function ($) {
	styleSelect = {
		init: function () {
		$('.select_wrapper').each(function () {
			$(this).prepend('<span>' + $(this).find('.select option:selected').text() + '</span>');
		});
		$('.select').live('change', function () {
			$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
		});
		$('.select').bind($.browser.msie ? 'click' : 'change', function(event) {
			$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
		}); 
		}
	};
	$(document).ready(function () {
		styleSelect.init()
	})
	})(jQuery);
	
	
	/** Aquagraphite Slider MOD */
	
	//Hide (Collapse) the toggle containers on load
	$(".slide_body").hide(); 

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$(".slide_edit_button").live( 'click', function(){		
		/*
		//display as an accordion
		$(".slide_header").removeClass("active");	
		$(".slide_body").slideUp("fast");
		*/
		//toggle for each
		$(this).parent().toggleClass("active").next().slideToggle("fast");
		return false; //Prevent the browser jump to the link anchor
	});	
	
	// Update slide title upon typing		
	function update_slider_title(e) {
		var element = e;
		if ( this.timer ) {
			clearTimeout( element.timer );
		}
		this.timer = setTimeout( function() {
			$(element).parent().prev().find('strong').text( element.value );
		}, 100);
		return true;
	}
	
	$('.of-slider-title').live('keyup', function(){
		update_slider_title(this);
	});
		
	
	//Remove individual slide
	$('.slide_delete_button').live('click', function(){
	// event.preventDefault();
	var agree = confirm("Are you sure you wish to delete this slide?");
		if (agree) {
			var $trash = $(this).parents('li');
			//$trash.slideUp('slow', function(){ $trash.remove(); }); //chrome + confirm bug made slideUp not working...
			$trash.animate({
					opacity: 0.25,
					height: 0,
				}, 500, function() {
					$(this).remove();
			});
			return false; //Prevent the browser jump to the link anchor
		} else {
		return false;
		}	
	});
	
	//Add new slide
	$(".slide_add_button").live('click', function(){		
		var slidesContainer = $(this).prev();
		var sliderId = slidesContainer.attr('id');
		
		var numArr = $('#'+sliderId +' li').find('.order').map(function() { 
			var str = this.id; 
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;			
		}).get();
		
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		
		var newSlide = '<li class="temphide"><div class="slide_header"><strong>Slide ' + newNum + '</strong><input type="hidden" class="slide of-input order" name="' + sliderId + '[' + newNum + '][order]" id="' + sliderId + '_slide_order-' + newNum + '" value="' + newNum + '"><a class="slide_edit_button" href="#">Edit</a></div><div class="slide_body" style="display: none; "><label>Title</label><input class="slide of-input of-slider-title" name="' + sliderId + '[' + newNum + '][title]" id="' + sliderId + '_' + newNum + '_slide_title" value=""><label>Image URL</label><input class="upload slide of-input" name="' + sliderId + '[' + newNum + '][url]" id="' + sliderId + '_' + newNum + '_slide_url" value=""><div class="upload_button_div"><span class="button media_upload_button" id="' + sliderId + '_' + newNum + '">Upload</span><span class="button remove-image hide" id="reset_' + sliderId + '_' + newNum + '" title="' + sliderId + '_' + newNum + '">Remove</span></div><div class="screenshot"></div><label>Link URL (optional)</label><input class="slide of-input" name="' + sliderId + '[' + newNum + '][link]" id="' + sliderId + '_' + newNum + '_slide_link" value=""><label>Description (optional)</label><textarea class="slide of-input" name="' + sliderId + '[' + newNum + '][description]" id="' + sliderId + '_' + newNum + '_slide_description" cols="8" rows="8"></textarea><a class="slide_delete_button" href="#">Delete</a><div class="clear"></div></div></li>';
		
		slidesContainer.append(newSlide);
		var nSlide = slidesContainer.find('.temphide');
		nSlide.fadeIn('fast', function() {
			$(this).removeClass('temphide');
		});
				
		optionsframework_file_bindings(); // re-initialise upload image..
		
		return false; //prevent jumps, as always..
	});	
	
	//Sort slides
	jQuery('.slider').find('ul').each( function() {
		var id = jQuery(this).attr('id');
		$('#'+ id).sortable({
			placeholder: "placeholder",
			opacity: 0.6,
			handle: ".slide_header",
			cancel: "a"
		});	
	});
	
	
	/**	Sorter (Layout Manager) */
	jQuery('.sorter').each( function() {
		var id = jQuery(this).attr('id');
		$('#'+ id).find('ul').sortable({
			items: 'li',
			placeholder: "placeholder",
			connectWith: '.sortlist_' + id,
			opacity: 0.6,
			update: function() {
				$(this).find('.position').each( function() {
				
					var listID = $(this).parent().attr('id');
					var parentID = $(this).parent().parent().attr('id');
					parentID = parentID.replace(id + '_', '')
					var optionID = $(this).parent().parent().parent().attr('id');
					$(this).prop("name", optionID + '[' + parentID + '][' + listID + ']');
					
				});
			}
		});	
	});

	$('#k2t_export_button').on('click', function(){
		var answer = prompt("Please enter name of your backup", "Backup Name");;// confirm("Click OK to backup your current saved options.");
		
		if (answer != null){
			
			$current_advance_backup_id = jQuery(this).attr('for');
			$current_advance_backup_desc = answer; // jQuery(this).attr('descript');
			$current_advance_backup_data = jQuery( "#" + $current_advance_backup_id).attr('value');
			
			var data = {
			
				action: 'k2t_add_advance_option',
				advance_id: $current_advance_backup_id,
				backup_name: answer,
				data: $current_advance_backup_data
				
			};
			jQuery(".k2t_waiting_spin").fadeIn();
			jQuery(".advance_backup_options_popup_content").fadeOut();
			jQuery.post(ajaxurl, data, function(response) {
				jQuery(".k2t_waiting_spin").fadeOut();		
				jQuery(".advance_backup_options_popup_content").fadeIn();	
				//check nonce
				if(response==-1){ //failed
								
					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}
							
				else {
							
					alert('Backup Success!');
					
				}
							
			});
			return false;
		}
		return false;
	});
	
	// ADVANCE IMPORT
	jQuery(".k2t_import_button").on('click',function(){
		
		/* Load All Import */
		jQuery(".advance_backup_option_popup").fadeIn();
		$current_advance_backup_id = jQuery(this).attr('for');
		var data = {
			action: 'k2t_load_advance_option',
			advance_id: $current_advance_backup_id,
		};
		jQuery(".k2t_waiting_spin").fadeIn();
		jQuery(".advance_backup_options_popup_content").fadeOut();
		jQuery.post(ajaxurl, data, function(response) {
			jQuery(".k2t_waiting_spin").fadeOut();	
			jQuery(".advance_backup_options_popup_content").fadeIn();			
			//check nonce
			if(response==-1){ //failed
							
				var fail_popup = $('#of-popup-fail');
				fail_popup.fadeIn();
				window.setTimeout(function(){
					fail_popup.fadeOut();                        
				}, 2000);
			}
						
			else {
						
				jQuery('ul.k2t_advance_backup_options_feature').html(response);
				/* Bind Backup Item Click */
					jQuery("ul.k2t_advance_backup_options_feature li").bind('click',function(){
						jQuery("ul.k2t_advance_backup_options_feature li").removeClass("active");
						jQuery(this).addClass("active");
					});
					/* Save Action */
					
					/* SAVE FILE */
					jQuery("ul.advance_backup_options_list_feature li .download_backup").bind('click',function(){
						
					});
					
					/* Delete Action */
					jQuery(".advance_backup_options_list_feature li .dashicons_item").bind('click',function(){
						jQuery("ul.k2t_advance_backup_options_feature li").removeClass("active");
						jQuery(this).parent().addClass("active");
						var $current_elelement = jQuery(this).parent().parent();
						var advance_id = jQuery("ul.k2t_advance_backup_options_feature li.active").attr("for");
						var $backup_id = jQuery("ul.k2t_advance_backup_options_feature li.active").attr("backup-id");
						var data1 = jQuery("ul.k2t_advance_backup_options_feature li.active").attr("data");
						var answer_delete = confirm("Click OK to delete your current selected.");
						if (answer_delete){
							if( typeof advance_id !== "undefined" ){
								var data = {
									action: 'k2t_delete_advance_option',
									backup_id: $backup_id,
									advance_id : advance_id,
									data : data1
								};
								jQuery(".k2t_waiting_spin").fadeIn();
								jQuery(".advance_backup_options_popup_content").fadeOut();
								jQuery.post(ajaxurl, data, function(response) {
									jQuery(".k2t_waiting_spin").fadeOut();	
									jQuery(".advance_backup_options_popup_content").fadeIn();			
									//check nonce
									if(response==-1){ //failed
													
										var fail_popup = $('#of-popup-fail');
										fail_popup.fadeIn();
										window.setTimeout(function(){
											fail_popup.fadeOut();                        
										}, 2000);
									}
												
									else {
										alert("Deleted!");
										$current_elelement.find("[backup-id='" + $backup_id + "']").remove();
									}
												
								});
							}
						}
						
					});
					
				/* End Bind  Backup Item Click */
			}
						
		});
		
		return false;
	});
	
	/* BACKUP CLOSE */
	jQuery(".k2t_advance_backup_option_popup_control_close").on('click',function(){
	
		jQuery(this).parent().parent().fadeOut();
	
	});
	/* BACKUP CANCEL */
	jQuery(".advance_backup_option_popup_control_cancel").on('click',function(){
	
		jQuery(this).parent().parent().parent().parent().fadeOut();
	
	});
	/* BACKUP SAVE */
	jQuery(".advance_backup_option_popup_control_backup").on('click',function(){
		
		var advance_id = jQuery("ul.k2t_advance_backup_options_feature li.active").attr("for");
		var data1 = jQuery("ul.k2t_advance_backup_options_feature li.active").attr("data");
		var answer = confirm("Click OK to backup your current saved options.");	
		if (answer){
			if( typeof advance_id !== "undefined" ){
				var data = {
					action: 'k2t_backup_advance_option',
					advance_id : $current_advance_backup_id,
					data : data1
				};
				jQuery(".k2t_waiting_spin").fadeIn();
				jQuery(".advance_backup_options_popup_content").fadeOut();
				jQuery.post(ajaxurl, data, function(response) {
								
					//check nonce
					if(response==-1){ //failed
									
						var fail_popup = $('#of-popup-fail');
						fail_popup.fadeIn();
						window.setTimeout(function(){
							fail_popup.fadeOut();                        
						}, 2000);
					}
								
					else {
						jQuery(".k2t_waiting_spin").fadeOut();
						jQuery(".advance_backup_options_popup_content").fadeIn();
						window.setTimeout(function(){
							location.reload();                        
						}, 1000);
					}
								
				});
			}
		}
		return false;
	});

	jQuery(".advance_backup_option_popup_control_upload_file").on('click',function(){
		jQuery(".abop_control_file_upload").val('');
		jQuery(".abop_control_file_upload").trigger("click");
	});

	jQuery(".abop_control_file_upload").change(function (e) {

		jQuery(".notice_popup").css('display','block');
		var file = jQuery(this)[0].files[0];
		var data = '';
		if (file) {
			// create reader
			var reader = new FileReader();
			reader.readAsText(file);
			reader.onload = function(e) {
				// browser completed reading file - display it
				//var data;
				data = e.target.result;
				jQuery(".notice_popup").attr('data',data);
			};
		}
		
		
		jQuery(".advance_backup_options_popup_content").css('display','none');


	});
	jQuery(".notice_popup_choise_cancel").on('click',function(){
		jQuery(".notice_popup").css('display','none');
		jQuery(".advance_backup_options_popup_content").css('display','block');
		jQuery(".notice_popup").attr('data','');
	})

	/*

	Backup 

	*/

	jQuery(".notice_popup_choise_accept").on('click',function(){
		jQuery(".notice_popup").css('display','none');
		jQuery(".advance_backup_options_popup_content").css('display','block');
		var data_backup = '';
		//jQuery.get(jQuery(this).parent().attr('data'), function(data) { alert(data);data_backup = data; });

		data_backup = jQuery(this).parent().attr('data');

		var backup_type = jQuery(".notice_popup_choise").val();
		/*
		Back Up Now
		*/
		var data = {
			action: 'k2t_backup_from_file',
			data_backup : data_backup,
			backup_type : backup_type
		};
		jQuery(".k2t_waiting_spin").fadeIn();
		jQuery(".advance_backup_options_popup_content").fadeOut();
		jQuery.post(ajaxurl, data, function(response) {
			jQuery(".k2t_waiting_spin").fadeOut();
			jQuery(".advance_backup_options_popup_content").fadeIn();	

			//check nonce
			if(response==-1){ //failed
							
				var fail_popup = $('#of-popup-fail');
				fail_popup.fadeIn();
				window.setTimeout(function(){
						location.reload();                     
					}, 1000);
			}
						
			else {
				alert(response);
				window.setTimeout(function(){
						location.reload();                        
					}, 1000);
			}
						
		});
		/*
		End Back
		*/
	});
	

	/*
	ISOTOPE FILETER
	*/


	jQuery(".k2t-theme-versions").isotope({ 
		itemSelector: '.theme-ver'
	});
	jQuery(".oneclickinstall a").click(function(){

		jQuery(".k2t-theme-versions").isotope({ 
		itemSelector: '.theme-ver'
	});

	});
	jQuery('.versions-filters a').click(function(){
		var selector = jQuery(this).attr('data-filter');
		jQuery('.versions-filters a').removeClass('active');
		if(!jQuery(this).hasClass('active')) {
			jQuery(this).addClass('active');
		}
		jQuery(".k2t-theme-versions").isotope({ filter: selector });
	
		return false;
	});

	/****************************************************/
	/* Import XML data */
	/****************************************************/

	/* Close Button and clear all attr */
	jQuery(".k2t_advance_backup_data_popup_control_close,.advance_backup_data_popup_control_cancel").on('click',function(){
		jQuery(this).parent().parent().fadeOut();
		jQuery(".advance_backup_data_popup_step_1").css("display","block");
		jQuery(".advance_backup_data_popup_step_2").css("display","none");
		jQuery(".advance_backup_data_popup_control_start").css("display","block");
		jQuery(".advance_backup_data_popup_control_cancel").css("display","none");
		jQuery(".process_percent_container").css("display","none");
		jQuery(".advance_backup_data_popup_content_heading").removeAttr("import_type");
		jQuery(".advance_backup_data_popup_content_heading").removeAttr("data-ver");
		jQuery(".advance_backup_data_popup_content_heading").removeAttr("data-home_id");
		jQuery(".advance_backup_data_popup_content_heading").removeAttr("data-type_name");
	});
	/* Import basic demo button */
	var importBtn = jQuery('#k2t_install_demo_pages');
	jQuery('#k2t_install_demo_pages').on("click",function(e){
			e.preventDefault();
			var style = jQuery('#demo_data_style').val();			
			jQuery(".advance_backup_data_popup").fadeIn();
			jQuery(".advance_backup_data_popup_content_heading").attr("import_type","basic_content");
	});
	/* Import version demo button */	
	jQuery('.install-ver').click(function(e) {
		var current_button = jQuery(this);
		e.preventDefault();
		//jQuery('.ver-install-result').html('');	
		jQuery(".advance_backup_data_popup").fadeIn();
		jQuery(".advance_backup_data_popup_content_heading").attr("import_type","ver_content");
		jQuery(".advance_backup_data_popup_content_heading").attr("data-ver",current_button.attr('data-ver'));
		jQuery(".advance_backup_data_popup_content_heading").attr("data-home_id",current_button.attr('data-home_id'));
		jQuery(".advance_backup_data_popup_content_heading").attr("data-type_name",current_button.attr('data-type_name'));
	});
	/* Btn Start Click */
	jQuery(".advance_backup_data_popup_control_start").on("click",function(){
		if(jQuery("#agree_backup_args").is(":checked")){
			jQuery(".advance_backup_data_popup_step_1").css("display","none");
			jQuery(".advance_backup_data_popup_step_2").css("display","block");
			jQuery(".advance_backup_data_popup_control_start").css("display","none");
			jQuery(".advance_backup_data_popup_control_cancel").css("display","block");
			jQuery(".process_percent_container").css("display","block");
			var enable_drop_old_data = 0;
			if(jQuery("#drop_all_old_data").is(":checked")){ 
				enable_drop_old_data = 1;
			}
			/*			
			Start Install :			
			*/
			
			installing_proccess = 0;
			//jQuery("#process_backup_data").css("display","block");
			jQuery("#process_install_active_plugin").css("display","block").html('<i class="dashicons dashicons-update" style=""></i> Checking missing plugin requirement before active');						
			jQuery("#process_backup_data").html('<i class="dashicons dashicons-update" style=""></i> Start Backup Data');
			data =  {
					'action':'k2t_backup_tables',
					enable_drop_old_data:enable_drop_old_data
			};
			jQuery.post(ajaxurl, data, function(response) {
				jQuery(".process_percent_container .process_percent").attr('current_percent','10').css("width","10%").html("<span>Installing... 10%</span>");
				importBtn.after('<div id floatingCirclesG" class="loading"><div class="f_circleG" id="frotateG_01"></div><div class="f_circleG" id="frotateG_02"></div><div class="f_circleG" id="frotateG_03"></div><div class="f_circleG" id="frotateG_04"></div><div class="f_circleG" id="frotateG_05"></div><div class="f_circleG" id="frotateG_06"></div><div class="f_circleG" id="frotateG_07"></div><div class="f_circleG" id="frotateG_08"></div></div>');
				importBtn.text('Sussessfuly Install Data').removeClass('disabled').removeAttr('disabled').bind('click');					
				//	Install Missing Plugin 
				//	Get Plugin Dir for deteach Plugin Not Installed
				jQuery("#process_install_active_plugin").css("display","block").html('<i class="dashicons dashicons-update" style=""></i> Checking missing plugin requirement before active');						
				jQuery.get(home_url + '/wp-admin/plugins.php', function( data ) {					
					//Call Ajax Active Plugin For Get List Plugin Not Installed						
					data_install_plugin =  {
						'action':'k2t_active_plugin'
					};
					jQuery.post(ajaxurl, data_install_plugin, function(response){
						var pl = jQuery.parseJSON(response);
						var current_plugin = 0;
						if(pl.length > 0 ){
							loop_active_plugin(current_plugin,pl);
						}else{
							jQuery("#process_install_active_plugin").css("display","block").html('<i class="dashicons dashicons-yes" style=""></i> Plugin were actived');
							loop_active_plugin_callback();
						}
					});
				})
			});
			/*
			Finish Install 
			*/
		}else{
			alert("Your need agree behind infomation before import data!!!");
			return false;
		}
	});

	/* Repeat Loop Active Pluugin */
	function loop_active_plugin(current_plugin,pl){
		jQuery("#process_install_active_plugin").css("display","block");
		jQuery("#process_install_active_plugin").html('<i class="dashicons dashicons-update" style=""></i> Install Plugin ' + pl[current_plugin]["name"] + " Success");
		var plugin_source_temp =	"&plugin_source=" +  pl[current_plugin]['source'];
		if(pl[current_plugin]['source'] == ""){

			plugin_source_temp  = "&plugin_source=repo";
		}
		$.ajax({
			async: false,
			type: 'GET',
			url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl[current_plugin]["slug"] + '&plugin_name=' + pl[current_plugin]["name"].replace(" ", "%20")  + plugin_source_temp + '&tgmpa-install=install-plugin&tgmpa-nonce=' + pl[current_plugin]["install_nonce"],
			success: function( data ) {
				jQuery("#process_install_active_plugin").html('<i class="dashicons dashicons-update" style=""></i> Active Plugin ' + pl[current_plugin]["name"] + ' Success');
				$.ajax({
					async: false,
					type: 'GET',
					url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl[current_plugin]["slug"] + '&plugin_name=' + pl[current_plugin]["name"].replace(" ", "%20") + plugin_source_temp + '&tgmpa-activate=activate-plugin&tgmpa-nonce=' + pl[current_plugin]["activate_nonce"],
					success: function( data ) {
						if(('redirect' in pl[current_plugin]) && pl[current_plugin]['redirect'] == true ){
							console.log(pl[current_plugin]['redirect']);
							$.ajax({
								async: false,
								type: 'GET',
								url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&tgmpa-nonce=' + pl[current_plugin]["install_nonce"],
								success: function (data) {

									current_plugin++;
									jQuery(".process_percent_container .process_percent").attr('current_percent','10').css("width","10%").html("<span>Installing... 10%</span>");
									if(current_plugin < pl.length){
										loop_active_plugin(current_plugin,pl);
									}else{

										jQuery(".process_percent_container .process_percent").attr('current_percent','20').css("width","20%").html("<span>Installing... 20%</span>");
										//alert("Success Install Plugins");
										jQuery("#process_install_active_plugin").html('<i class="dashicons dashicons-yes" style=""></i> Installed All Plugin');

										loop_active_plugin_callback();
									}
								}
							});

						}else {
							current_plugin++;
							jQuery(".process_percent_container .process_percent").attr('current_percent','10').css("width","10%").html("<span>Installing... 10%</span>");
							if(current_plugin < pl.length){
								loop_active_plugin(current_plugin,pl);
							}else{

								jQuery(".process_percent_container .process_percent").attr('current_percent','20').css("width","20%").html("<span>Installing... 20%</span>");
								//alert("Success Install Plugins");
								jQuery("#process_install_active_plugin").html('<i class="dashicons dashicons-yes" style=""></i> Installed All Plugin');

								loop_active_plugin_callback();
							}
						}
					}
				});
			}
		});
	}



	/*
	Loop Active Plugin Call Back
	*/
	function loop_active_plugin_callback(){
		/*
				INSTALL BACKUP
		*/
		installing_proccess = 1;
		
		// Start Threat

		jQuery(".process_percent_container .process_percent").attr('current_percent','20').css("width","40%").html("<span>Installing... 20%</span>");
		var enable_drop_old_data = 0;
		if(jQuery("#drop_all_old_data").is(":checked")){ 
			enable_drop_old_data = 1;
		}
			/*			
			Start Install :			
			*/
		var import_type = jQuery(".advance_backup_data_popup_content_heading").attr("import_type");

		var data =  {
			action:'k2t_import_data',
			enable_drop_old_data:enable_drop_old_data
		};

		if(import_type == "basic_content"){
			data = {
				action:'k2t_import_data',
				enable_drop_old_data : enable_drop_old_data
			}
		}else if(import_type == "ver_content"){
			var version = jQuery(".advance_backup_data_popup_content_heading").attr('data-ver');
			var home_id = jQuery(".advance_backup_data_popup_content_heading").attr('data-home_id');
			var type_name = jQuery(".advance_backup_data_popup_content_heading").attr('data-type_name');
			data =  {
				action:'k2t_install_version',
				ver: version,
				home_id: home_id,
				type_name: type_name,
				enable_drop_old_data : enable_drop_old_data
			};
		}

		jQuery.post(ajaxurl, data, function(response){
					// Backup k2t_backup_database;

					/*
						Start Backup Database
					*/
					var version = jQuery(".advance_backup_data_popup_content_heading").attr('data-ver');
					var home_id = jQuery(".advance_backup_data_popup_content_heading").attr('data-home_id');
					var type_name = jQuery(".advance_backup_data_popup_content_heading").attr('data-type_name');

					jQuery("#process_backup_widget").css("display","block").html('<i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup Theme Widget Done!');
					jQuery("#process_backup_theme_options").css("display","block").html('<i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup Theme Options Done!');
					jQuery("#process_upload_database").css("display","block").html('<i class="dashicons dashicons-update" style="color: #056b16;margin-right:5px;"></i>Uploading Database!');
					jQuery(".process_percent_container .process_percent").attr('current_percent','40').css("width","40%").html("<span>Installing... 40%</span>");
					data1 =  {
						action:'k2t_backup_database',
						ver: version,
						home_id: home_id,
						type_name: type_name
					};

					$.ajax({
						async: false,
						type: 'POST',
						url: ajaxurl,
						data: data1,
						success: function (response) {
							console.log(response);

							//Backup k2t_import_asset
							var version = jQuery(".advance_backup_data_popup_content_heading").attr('data-ver');
							var home_id = jQuery(".advance_backup_data_popup_content_heading").attr('data-home_id');
							var type_name = jQuery(".advance_backup_data_popup_content_heading").attr('data-type_name');

							jQuery("#process_upload_asset").css("display", "block").html('<i class="dashicons dashicons-update" style="color: #056b16;margin-right:5px;"></i>Uploading Asset!');
							jQuery("#process_upload_database").css("display", "block").html('<i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup Database Done');
							jQuery(".process_percent_container .process_percent").attr('current_percent', '60').css("width", "60%").html("<span>Installing... 60%</span>");
							data2 = {
								action: 'k2t_import_asset',
								ver: version,
								home_id: home_id,
								type_name: type_name,
							}


							/*
							 Start Upload All Asset
							 */
							jQuery.post(ajaxurl, data2, function (response) {

								installing_proccess = 0;
								jQuery("#process_upload_asset").css("display", "block").html('<i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup Asset Done!');
								jQuery("#process_backup_posts").css("display", "block").html('<i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup All Data Done!');
								jQuery("#process_reconfig_setting").css("display", "block").html('<i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Waiting Reconfig setting and clear cache...');
								/* Clear Cache */
								jQuery.get(home_url + "/wp-admin/upgrade.php?step=1&backto=%2Flincoln%2Fwp-admin%2Fthemes.php%3Fpage%3Doptionsframework", function () {
								});
								/* reset permalink */
								jQuery.get(home_url + "/wp-admin/options-permalink.php", function () {
								});
								jQuery(".process_percent_container .process_percent").attr('current_percent', '90').css("width", "90%").html("<span>Installing... 90%</span>");
								jQuery.post(ajaxurl, {action: 'k2t_clear_cache'}, function (response) {
									jQuery("#process_reconfig_setting").css("display", "block").html('<i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Reconfig setting and clear cache...');
									jQuery("#proces_done").css("display", "block");
									jQuery(".process_percent_container .process_percent").attr('current_percent', '100').css("width", "100%").html("<span>Installing... 100%</span>");
									alert("Sussessfuly Install Data");
									window.setTimeout(function () {
										location.reload();
									}, 1000);
								})
							});
						}
					});
					
				
				
			});
			
	}
	/* End Repeat Loop Plugin*/

	/* Get Cache Proccess */
	get_cache_proccess();
	function get_cache_proccess(){
	}

	/* End*/

	/****************************************************/
	/* End Import XML data */
	/****************************************************/


	/**	Ajax Backup & Restore MOD */
	//backup button
	$('#of_backup_button').live('click', function(){
	
		var answer = confirm("Click OK to backup your current saved options.")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'backup_options',
				security: nonce
			};
						
			$.post(ajaxurl, data, function(response) {
							
				//check nonce
				if(response==-1){ //failed
								
					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}
							
				else {
							
					var success_popup = $('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
							
			});
			
		}
		
	return false;
					
	}); 
	
	//restore button
	$('#of_restore_button').live('click', function(){
	
		var answer = confirm("'Warning: All of your current options will be replaced with the data from your last backup! Proceed?")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'restore_options',
				security: nonce
			};
						
			$.post(ajaxurl, data, function(response) {
			
				//check nonce
				if(response==-1){ //failed
								
					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}
							
				else {
							
					var success_popup = $('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}	
						
			});
	
		}
	
	return false;
					
	});
	
	/**	Ajax Transfer (Import/Export) Option */
	$('#of_import_button').live('click', function(){
	
		var answer = confirm("Click OK to import options.")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
			
			var import_data = $('#export_data').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'import_options',
				security: nonce,
				data: import_data
			};
						
			$.post(ajaxurl, data, function(response) {
				var fail_popup = $('#of-popup-fail');
				var success_popup = $('#of-popup-save');
				
				//check nonce
				if(response==-1){ //failed
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}		
				else 
				{
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
							
			});
			
		}
		
	return false;
					
	});

	/**	Ajax Transfer (Import/Export) Option */
	$('#of_import_button_widgets').live('click', function(){
	
		var answer = confirm("Click OK to import widgets.")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
			
			var import_data = $('#export_data').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'import_options_widgets',
				security: nonce,
				data: import_data
			};
						
			$.post(ajaxurl, data, function(response) {
				var fail_popup = $('#of-popup-fail');
				var success_popup = $('#of-popup-save');

				//check nonce
				if(response==-1){ //failed
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}		
				else 
				{
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
							
			});
			
		}
		
	return false;
					
	});

	$('#setting-error-tgmpa').prependTo( '#of_container' );
	
	/** AJAX Save Options */
	$('#of_save').live('click',function() {
			
		var nonce = $('#security').val();
					
		$('.ajax-loading-img').fadeIn();
		
		//get serialized data from all our option fields			
		var serializedReturn = $('#of_form :input[name][name!="security"][name!="of_reset"]').serialize();

		$('#of_form :input[type=checkbox]').each(function() {     
			if (!this.checked) {
				serializedReturn += '&'+this.name+'=0';
			}
		});

		/* Modify Data Header Options Before Save  */
		var data_header_option = jQuery("#header-advance-import").attr("value");
		data_header_option_arr = jQuery.parseJSON( jQuery.base64.atob( data_header_option ) );
		var newarray = [];
		parse_str ( serializedReturn , newarray );
		newarray = convArrToObj( newarray );
		jQuery.each(data_header_option_arr , function( i,v ){
			
			jQuery.each( newarray , function( inew,vnew ){
				if( i == inew &&  data_header_option_arr[i] != newarray[inew] ){
						data_header_option_arr[i] = newarray[inew];
				}

			})
			
		});
		data_header_option_arr = jQuery.base64.btoa( JSON.stringify( data_header_option_arr ) );
		jQuery("#header-advance-import").attr("value",data_header_option_arr);
		/* End Modify Data Header Options  Before Save */

		var data = {
			type: 'save',
			action: 'of_ajax_post_action',
			security: nonce,
			data: serializedReturn
		};		
		$.post(ajaxurl, data, function(response) {
			var success = $('#of-popup-save');
			var fail = $('#of-popup-fail');
			var loading = $('.ajax-loading-img');
			loading.fadeOut();  
						
			if (response==1) {
				success.fadeIn();
			} else { 
				fail.fadeIn();
			}
						
			window.setTimeout(function(){
				success.fadeOut(); 
				fail.fadeOut();				
			}, 2000);
		});
			
	return false; 
					
	});   
	
	
	/* AJAX Options Reset */	
	$('#of_reset').click(function() {
		
		//confirm reset
		var answer = confirm("Click OK to reset. All settings will be lost and replaced with default settings!");
		
		//ajax reset
		if (answer){
			
			var nonce = $('#security').val();
						
			$('.ajax-reset-loading-img').fadeIn();
							
			var data = {
			
				type: 'reset',
				action: 'of_ajax_post_action',
				security: nonce,
			};
						
			$.post(ajaxurl, data, function(response) {
				var success = $('#of-popup-reset');
				var fail = $('#of-popup-fail');
				var loading = $('.ajax-reset-loading-img');
				loading.fadeOut();  
							
				if (response==1)
				{
					success.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				} 
				else 
				{ 
					fail.fadeIn();
					window.setTimeout(function(){
						fail.fadeOut();				
					}, 2000);
				}
							

			});
			
		}
			
	return false;
		
	});


	/**	Tipsy @since v1.3 */
	if (jQuery().tipsy) {
		$('.tooltip, .typography-size, .typography-height, .typography-face, .typography-style, .of-typography-color').tipsy({
			fade: true,
			gravity: 's',
			opacity: 0.7,
		});
	}
	
	
	/**
	  * JQuery UI Slider function
	  * Dependencies 	 : jquery, jquery-ui-slider
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 03.17.2013
	  */
	jQuery('.smof_sliderui').each(function() {
		
		var obj   = jQuery(this);
		var sId   = "#" + obj.data('id');
		var val   = parseInt(obj.data('val'));
		var min   = parseInt(obj.data('min'));
		var max   = parseInt(obj.data('max'));
		var step  = parseInt(obj.data('step'));
		
		//slider init
		obj.slider({
			value: val,
			min: min,
			max: max,
			step: step,
			range: "min",
			slide: function( event, ui ) {
				jQuery(sId).val( ui.value );
			}
		});
		
	});


	/**
	  * Switch
	  * Dependencies 	 : jquery
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 03.17.2013
	  */
	jQuery( ".cb-enable" ).click( function(){
		var parent = $(this).parents( '.switch-options' );
		jQuery( '.cb-disable', parent ).removeClass( 'selected' );
		jQuery( this ).addClass( 'selected' );
		jQuery( '.main_checkbox', parent ).attr( 'checked', true );
		jQuery( '.main_checkbox', parent ).val( '1' );
		
		//fold/unfold related options
		var obj = jQuery( this );
		var $fold='.f_' + obj.data( 'id' );
		jQuery( $fold ).slideDown( 'normal', "swing" );
	});
	jQuery( ".cb-disable" ).click( function(){
		var parent = $( this ).parents( '.switch-options' );
		jQuery( '.cb-enable', parent ).removeClass( 'selected' );
		jQuery( this ).addClass( 'selected' );
		jQuery( '.main_checkbox', parent ).attr( 'checked', false );
		jQuery( '.main_checkbox', parent ).val( '0' );
		
		//fold/unfold related options
		var obj = jQuery( this );
		var $fold='.f_' + obj.data( 'id' );
		jQuery( $fold ).slideUp( 'normal', "swing" );
	});
	//disable text select(for modern chrome, safari and firefox is done via CSS)
	if ( ( $.browser.msie && $.browser.version < 10 ) || $.browser.opera ) { 
		$( '.cb-enable span, .cb-disable span' ).find().attr( 'unselectable', 'on' );
	}
	
	
	/**
	  * Google Fonts
	  * Dependencies 	 : google.com, jquery
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 03.17.2013
	  */
	function GoogleFontSelect( slctr, mainID ){
		
		var _selected = $(slctr).val(); 						//get current value - selected and saved
		var _linkclass = 'style_link_'+ mainID;
		var _previewer = mainID +'_ggf_previewer';
		
		if( _selected ){ //if var exists and isset

			$('.'+ _previewer ).fadeIn();
			
			//Check if selected is not equal with "Select a font" and execute the script.
			if ( _selected !== 'none' && _selected !== 'Select a font' ) {
				
				//remove other elements crested in <head>
				$( '.'+ _linkclass ).remove();
				
				//replace spaces with "+" sign
				var the_font = _selected.replace(/\s+/g, '+');
				
				//add reference to google font family
				$('head').append('<link href="http://fonts.googleapis.com/css?family='+ the_font +'" rel="stylesheet" type="text/css" class="'+ _linkclass +'">');
				
				//show in the preview box the font
				$('.'+ _previewer ).css('font-family', _selected +', sans-serif' );
				
			}else{
				
				//if selected is not a font remove style "font-family" at preview box
				$('.'+ _previewer ).css('font-family', '' );
				$('.'+ _previewer ).fadeOut();
				
			}
		
		}
	
	}
	
	//init for each element
	jQuery( '.google_font_select' ).each(function(){ 
		var mainID = jQuery(this).attr('id');
		GoogleFontSelect( this, mainID );
	});
	
	//init when value is changed
	jQuery( '.google_font_select' ).change(function(){ 
		var mainID = jQuery(this).attr('id');
		GoogleFontSelect( this, mainID );
	});

	// Select on/off
	jQuery( '.select_wrapper.logicstic select' ).each(function(){
		var mainID = jQuery(this).attr('id');
		var mainVal = jQuery(this).val();
		jQuery( '.' + mainID ).addClass( 'hide' );
		jQuery( '.' + mainID + '.' + mainVal ).removeClass( 'hide' );
	});
	jQuery( '.select_wrapper.logicstic select' ).change(function(){
		var mainID = jQuery(this).attr('id');
		var mainVal = jQuery(this).val();
		jQuery( '.' + mainID ).fadeOut();
		jQuery( '.' + mainID + '.' + mainVal ).fadeIn();
	});

	// Switch on/off
	jQuery( '.switch-options.logicstic' ).each(function(){
		var mainID = jQuery( 'input', this ).attr('id');
		var mainVal = 'switch-' + jQuery( "input[type='checkbox']:checked", this ).val();
		jQuery( '.' + mainID ).addClass( 'hide' );
		jQuery( '.' + mainID + '.' + mainVal ).removeClass( 'hide' );
	});
	
	jQuery( '.switch-options.logicstic > label' ).click(function(){
		var parent = jQuery(this).parent();
		var mainID = jQuery( 'input', parent ).attr('id');
		var mainVal = 'switch-' + jQuery( " input[type='checkbox']:checked", parent ).val();
		jQuery( '.' + mainID ).fadeOut();
		jQuery( '.' + mainID + '.' + mainVal ).fadeIn();
	});

	refresh_advance_hidden_list();
	
	function refresh_advance_hidden_list(){

		jQuery( '.has_hidden_option_array' ).each(function(){

			var check_feild_hide = 0 ;

			var field_type ='';
			
			/*
			Get Type Of Feild
			*/

			if(jQuery(this).hasClass("select"))	{
				// SELECT
				check_feild_hide = jQuery(this).parent().parent().parent().parent().hasClass( 'hide' );

				field_type	= "select";

			}else if(jQuery(this).hasClass("switch-options"))
			{
				// SWITCH
				check_feild_hide = jQuery(this).parent().parent().parent().hasClass( 'hide' );

				field_type	= "switch";

			}

			/*
			End Get Type Of Feild
			*/

			//alert(field_type);
			if (!check_feild_hide) {			

				data_hidden_option_str = jQuery(this).attr('data-hidden-option-array');
				
				/*
				Get value Of Data
				*/

				var data_hidden_option_array = jQuery.parseJSON( jQuery.base64.atob( data_hidden_option_str ) );
				
				/*
				Hide All
				*/

				jQuery.each(data_hidden_option_array,function(k,v){					
					jQuery.each(v,function(){
						jQuery( "#section-" + this ).addClass( 'hide' );
					});		
				});

				/*
				Advance Display
				*/


				if( field_type == "switch" ){

				/*

				Case Switch

				*/
				var value = jQuery( this ).val();
				
				jQuery( this ).find( 'label' ).each(function(){				
					if (jQuery(this).attr( "class" ) ==  "cb-disable selected" ) {					
						jQuery.each(data_hidden_option_array,function(k,v){							
							/* 
							Value When Disable
							*/	
							if(k == 0 )
							{
								jQuery.each(v,function(){
									//jQuery("#section-"+ this).addClass( 'hide' );
									jQuery("#section-"+ this).removeClass( 'hide' );
								});
							}
						});
					} else if (jQuery(this).attr("class") == "cb-enable selected") {
						jQuery.each(data_hidden_option_array,function(k,v){
							/* 
							Value When Enable
							*/							
							if(k == 1 )
							{
								jQuery.each(v,function(){
									//jQuery("#section-"+ this).addClass( 'block' );
									jQuery("#section-"+ this).removeClass( 'hide' );
								});
							}
						});
					}					
				});		

				/*

				Case Switch

				*/
				}else if( field_type == "select" ){

					var value = jQuery( this ).val();
					jQuery.each(data_hidden_option_array,function(k,v){							
						/* 
						Get Value And Set display
						*/	
						if(k == value )
						{
							jQuery.each(v,function(){
								//jQuery("#section-"+ this).addClass( 'hide' );
								jQuery("#section-"+ this).removeClass( 'hide' );
							});
						}
					});

				}

			}else {
				
				data_hidden_option_str = jQuery(this).attr('data-hidden-option-array');				
				/*				
				If No value				
				*/				
				var data_hidden_option_array = jQuery.parseJSON( jQuery.base64.atob( data_hidden_option_str ) );				
					
					jQuery.each(data_hidden_option_array,function(k,v){					
					
						jQuery.each(v,function(){
					
							jQuery("#section-"+ this).addClass( 'hide' );
					
						});						
					
					});
			}
			
		});
		
	}

	
	/*
	On Click
	*/
	jQuery( '.switch-options.has_hidden_option_array > label' ).on('click',function(){
		refresh_advance_hidden_list();
	});

	/*
	On Click
	*/
	jQuery( '.select.has_hidden_option_array' ).on('click',function(){
		refresh_advance_hidden_list();
	});

	/*
	
	End Advance Display For Theme Options 
	
	*/
	
	var social_array =  ['facebook' ,'twitter' ,'google-plus' ,'linkedin' ,'tumblr' ,'pinterest' ,'youtube' ,'skype' ,'instagram' ,'delicious' ,'reddit' ,'stumbleupon' ,'wordpress' ,'joomla' ,'blogger' ,'vimeo' ,'yahoo' ,'flickr' ,'picasa' ,'deviantart' ,'github' ,'stackoverflow' ,'xing' ,'flattr' ,'foursquare' ,'paypal' ,'yelp' ,'soundcloud' ,'lastfm' ,'lanyrd' ,'dribbble' ,'forrst' ,'steam' ,'behance' ,'mixi' ,'weibo' ,'renren' ,'evernote' ,'dropbox' ,'bitbucket' ,'trello' ,'vk' ,'home' ,'envelope-alt' ,'rss'];
	
	var output = '';

	jQuery.each(social_array,function(){

		var current_id = this;
		jQuery("#section-social-" + current_id + " #social-" + current_id).bind('change',function(){

				if(jQuery(this).val() != "")
				{
					jQuery(".header_options_social_list_popup_" + current_id ).css('display','block');

					/*

					Upgdae Array In Header Options 
					
					*/

				}else{

					jQuery(".header_options_social_list_popup_" + current_id ).css('display','none');

				}

		})

	});
	
	/**
	  * Media Uploader
	  * Dependencies 	 : jquery, wp media uploader
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 05.28.2013
	  */
	function optionsframework_add_file(event, selector) {
	
		var upload = $(".uploaded-file"), frame;
		var $el = $(this);

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( frame ) {
			frame.open();
			return;
		}

		// Create the media frame.
		frame = wp.media({
			// Set the title of the modal.
			title: $el.data('choose'),

			// Customize the submit button.
			button: {
				// Set the text of the button.
				text: $el.data('update'),
				// Tell the button not to close the modal, since we're
				// going to refresh the page when the image is selected.
				close: false
			}
		});

		// When an image is selected, run a callback.
		frame.on( 'select', function() {
			// Grab the selected attachment.
			var attachment = frame.state().get('selection').first();
			
			frame.close();
			selector.find('.upload').val(attachment.attributes.url);
			
			if ( attachment.attributes.type == 'image' ) {
				selector.find('.screenshot').empty().hide().append('<img class="of-option-image" src="' + attachment.attributes.url + '">').slideDown('fast');
			}
			selector.find('.media_upload_button').unbind();
			selector.find('.remove-image').show().removeClass('hide');//show "Remove" button
			selector.find('.of-background-properties').slideDown();
			optionsframework_file_bindings();
		});

		// Finally, open the modal.
		frame.open();
	}
	
	function optionsframework_remove_file(selector) {
		selector.find('.remove-image').hide().addClass('hide');//hide "Remove" button
		selector.find('.upload').val('');
		selector.find('.of-background-properties').hide();
		selector.find('.screenshot').slideUp();
		selector.find('.remove-file').unbind();
		// We don't display the upload button if .upload-notice is present
		// This means the user doesn't have the WordPress 3.5 Media Library Support
		if ( $('.section-upload .upload-notice').length > 0 ) {
			$('.media_upload_button').remove();
		}
		optionsframework_file_bindings();
	}
	
	function optionsframework_file_bindings() {
		$('.remove-image, .remove-file').on('click', function() {
			optionsframework_remove_file( $(this).parents('.section-upload, .section-media, .slide_body') );
		});
		
		$('.media_upload_button').unbind('click').click( function( event ) {
			optionsframework_add_file(event, $(this).parents('.section-upload, .section-media, .slide_body'));
		});
	}
	
	optionsframework_file_bindings();

}); //end doc ready

jQuery.fn.removeClassPrefix = function(prefix) {
	this.each(function(i, el) {
		var classes = el.className.split(" ").filter(function(c) {
			return c.lastIndexOf(prefix, 0) !== 0;
		});
		el.className = jQuery.trim(classes.join(" "));
	});
	return this;
};


/*!
 * jquery.base64.js 0.1 - https://github.com/yckart/jquery.base64.js
 * Makes Base64 en & -decoding simpler as it is.
 *
 * Based upon: https://gist.github.com/Yaffle/1284012
 *
 * Copyright (c) 2012 Yannick Albert (http://yckart.com)
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
 * 2013/02/10
 * Added By Vthanh
 * Added Date : 18/1/2015
 * For HEDER OPTION
 **/
;(function($) {

	var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
		a256 = '',
		r64 = [256],
		r256 = [256],
		i = 0;

	var UTF8 = {

		/**
		 * Encode multi-byte Unicode string into utf-8 multiple single-byte characters
		 * (BMP / basic multilingual plane only)
		 *
		 * Chars in range U+0080 - U+07FF are encoded in 2 chars, U+0800 - U+FFFF in 3 chars
		 *
		 * @param {String} strUni Unicode string to be encoded as UTF-8
		 * @returns {String} encoded string
		 */
		encode: function(strUni) {
			// use regular expressions & String.replace callback function for better efficiency
			// than procedural approaches
			var strUtf = strUni.replace(/[\u0080-\u07ff]/g, // U+0080 - U+07FF => 2 bytes 110yyyyy, 10zzzzzz
			function(c) {
				var cc = c.charCodeAt(0);
				return String.fromCharCode(0xc0 | cc >> 6, 0x80 | cc & 0x3f);
			})
			.replace(/[\u0800-\uffff]/g, // U+0800 - U+FFFF => 3 bytes 1110xxxx, 10yyyyyy, 10zzzzzz
			function(c) {
				var cc = c.charCodeAt(0);
				return String.fromCharCode(0xe0 | cc >> 12, 0x80 | cc >> 6 & 0x3F, 0x80 | cc & 0x3f);
			});
			return strUtf;
		},

		/**
		 * Decode utf-8 encoded string back into multi-byte Unicode characters
		 *
		 * @param {String} strUtf UTF-8 string to be decoded back to Unicode
		 * @returns {String} decoded string
		 */
		decode: function(strUtf) {
			// note: decode 3-byte chars first as decoded 2-byte strings could appear to be 3-byte char!
			var strUni = strUtf.replace(/[\u00e0-\u00ef][\u0080-\u00bf][\u0080-\u00bf]/g, // 3-byte chars
			function(c) { // (note parentheses for precence)
				var cc = ((c.charCodeAt(0) & 0x0f) << 12) | ((c.charCodeAt(1) & 0x3f) << 6) | (c.charCodeAt(2) & 0x3f);
				return String.fromCharCode(cc);
			})
			.replace(/[\u00c0-\u00df][\u0080-\u00bf]/g, // 2-byte chars
			function(c) { // (note parentheses for precence)
				var cc = (c.charCodeAt(0) & 0x1f) << 6 | c.charCodeAt(1) & 0x3f;
				return String.fromCharCode(cc);
			});
			return strUni;
		}
	};

	while(i < 256) {
		var c = String.fromCharCode(i);
		a256 += c;
		r256[i] = i;
		r64[i] = b64.indexOf(c);
		++i;
	}

	function code(s, discard, alpha, beta, w1, w2) {
		s = String(s);
		var buffer = 0,
			i = 0,
			length = s.length,
			result = '',
			bitsInBuffer = 0;

		while(i < length) {
			var c = s.charCodeAt(i);
			c = c < 256 ? alpha[c] : -1;

			buffer = (buffer << w1) + c;
			bitsInBuffer += w1;

			while(bitsInBuffer >= w2) {
				bitsInBuffer -= w2;
				var tmp = buffer >> bitsInBuffer;
				result += beta.charAt(tmp);
				buffer ^= tmp << bitsInBuffer;
			}
			++i;
		}
		if(!discard && bitsInBuffer > 0) result += beta.charAt(buffer << (w2 - bitsInBuffer));
		return result;
	}

	var Plugin = $.base64 = function(dir, input, encode) {
			return input ? Plugin[dir](input, encode) : dir ? null : this;
		};

	Plugin.btoa = Plugin.encode = function(plain, utf8encode) {
		plain = Plugin.raw === false || Plugin.utf8encode || utf8encode ? UTF8.encode(plain) : plain;
		plain = code(plain, false, r256, b64, 8, 6);
		return plain + '===='.slice((plain.length % 4) || 4);
	};

	Plugin.atob = Plugin.decode = function(coded, utf8decode) {
		coded = String(coded).split('=');
		var i = coded.length;
		do {--i;
			coded[i] = code(coded[i], true, r64, a256, 6, 8);
		} while (i > 0);
		coded = coded.join('');
		return Plugin.raw === false || Plugin.utf8decode || utf8decode ? UTF8.decode(coded) : coded;
	};
}(jQuery));
function stripslashes(str) {
  //       discuss at: http://phpjs.org/functions/stripslashes/
  //      original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //      improved by: Ates Goral (http://magnetiq.com)
  //      improved by: marrtins
  //      improved by: rezna
  //         fixed by: Mick@el
  //      bugfixed by: Onno Marsman
  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
  //         input by: Rick Waldron
  //         input by: Brant Messenger (http://www.brantmessenger.com/)
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  //        example 1: stripslashes('Kevin\'s code');
  //        returns 1: "Kevin's code"
  //        example 2: stripslashes('Kevin\\\'s code');
  //        returns 2: "Kevin\'s code"

  return (str + '')
	.replace(/\\(.?)/g, function(s, n1) {
	  switch (n1) {
		case '\\':
		  return '\\';
		case '0':
		  return '\u0000';
		case '':
		  return '';
		default:
		  return n1;
	  }
	});
}
function parse_str(str, array) {
  //       discuss at: http://phpjs.org/functions/parse_str/
  //      original by: Cagri Ekin
  //      improved by: Michael White (http://getsprink.com)
  //      improved by: Jack
  //      improved by: Brett Zamir (http://brett-zamir.me)
  //      bugfixed by: Onno Marsman
  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
  //      bugfixed by: stag019
  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
  //      bugfixed by: MIO_KODUKI (http://mio-koduki.blogspot.com/)
  // reimplemented by: stag019
  //         input by: Dreamer
  //         input by: Zaide (http://zaidesthings.com/)
  //         input by: David Pesta (http://davidpesta.com/)
  //         input by: jeicquest
  //             note: When no argument is specified, will put variables in global scope.
  //             note: When a particular argument has been passed, and the returned value is different parse_str of PHP. For example, a=b=c&d====c
  //             test: skip
  //        example 1: var arr = {};
  //        example 1: parse_str('first=foo&second=bar', arr);
  //        example 1: $result = arr
  //        returns 1: { first: 'foo', second: 'bar' }
  //        example 2: var arr = {};
  //        example 2: parse_str('str_a=Jack+and+Jill+didn%27t+see+the+well.', arr);
  //        example 2: $result = arr
  //        returns 2: { str_a: "Jack and Jill didn't see the well." }
  //        example 3: var abc = {3:'a'};
  //        example 3: parse_str('abc[a][b]["c"]=def&abc[q]=t+5');
  //        returns 3: {"3":"a","a":{"b":{"c":"def"}},"q":"t 5"}

  var strArr = String(str)
	.replace(/^&/, '')
	.replace(/&$/, '')
	.split('&'),
	sal = strArr.length,
	i, j, ct, p, lastObj, obj, lastIter, undef, chr, tmp, key, value,
	postLeftBracketPos, keys, keysLen,
	fixStr = function(str) {
	  return decodeURIComponent(str.replace(/\+/g, '%20'));
	};

  if (!array) {
	array = this.window;
  }

  for (i = 0; i < sal; i++) {
	tmp = strArr[i].split('=');
	key = fixStr(tmp[0]);
	value = (tmp.length < 2) ? '' : fixStr(tmp[1]);

	while (key.charAt(0) === ' ') {
	  key = key.slice(1);
	}
	if (key.indexOf('\x00') > -1) {
	  key = key.slice(0, key.indexOf('\x00'));
	}
	if (key && key.charAt(0) !== '[') {
	  keys = [];
	  postLeftBracketPos = 0;
	  for (j = 0; j < key.length; j++) {
		if (key.charAt(j) === '[' && !postLeftBracketPos) {
		  postLeftBracketPos = j + 1;
		} else if (key.charAt(j) === ']') {
		  if (postLeftBracketPos) {
			if (!keys.length) {
			  keys.push(key.slice(0, postLeftBracketPos - 1));
			}
			keys.push(key.substr(postLeftBracketPos, j - postLeftBracketPos));
			postLeftBracketPos = 0;
			if (key.charAt(j + 1) !== '[') {
			  break;
			}
		  }
		}
	  }
	  if (!keys.length) {
		keys = [key];
	  }
	  for (j = 0; j < keys[0].length; j++) {
		chr = keys[0].charAt(j);
		if (chr === ' ' || chr === '.' || chr === '[') {
		  keys[0] = keys[0].substr(0, j) + '_' + keys[0].substr(j + 1);
		}
		if (chr === '[') {
		  break;
		}
	  }

	  obj = array;
	  for (j = 0, keysLen = keys.length; j < keysLen; j++) {
		key = keys[j].replace(/^['"]/, '')
		  .replace(/['"]$/, '');
		lastIter = j !== keys.length - 1;
		lastObj = obj;
		if ((key !== '' && key !== ' ') || j === 0) {
		  if (obj[key] === undef) {
			obj[key] = {};
		  }
		  obj = obj[key];
		} else { // To insert new dimension
		  ct = -1;
		  for (p in obj) {
			if (obj.hasOwnProperty(p)) {
			  if (+p > ct && p.match(/^\d+$/g)) {
				ct = +p;
			  }
			}
		  }
		  key = ct + 1;
		}
	  }
	  lastObj[key] = value;
	}
  }
}
// Convert array to object
var convArrToObj = function(array){
	var thisEleObj = new Object();
	if(typeof array == "object"){
		for(var i in array){
			var thisEle = convArrToObj(array[i]);
			thisEleObj[i] = thisEle;
		}
	}else {
		thisEleObj = array;
	}
	return thisEleObj;
}
/**
 * Script for vc icon and menu icon.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

jQuery.noConflict();

jQuery(function() {

	/*  [ Insert Action ]
	- - - - - - - - - - - - - - - - - - - - */
	var insertIcons = jQuery( '#k2ticon-generator-insert' );
	var modalIcons  = jQuery( '#k2ticon-generator-wrap , #k2ticon-generator-overlay' );

	insertIcons.on( 'click',function() {
		var id = modalIcons.attr( 'for' ).replace(' ', '-');
		current_value = insertIcons.attr( 'current-value' );
		if( current_value.indexOf('zmdi-') != -1 ){
			jQuery( '#' + id ).val( 'zmdi ' + insertIcons.attr( 'current-value' ) );
		}
		else{
			jQuery( '#' + id ).val( insertIcons.attr( 'current-value' ) );
		}
		
		modalIcons.hide();

		insertIcons.attr( 'current-value', '' );

		jQuery( '#' + id ).trigger( 'change' );

		jQuery( '#' + id ).css( 'width', '283px' );

		jQuery( '[remove-for="' + id + '"]' ).removeAttr( 'style' );

		jQuery( '[rel-icon="' + id + '"]' ).show();
	});

	jQuery('.k2t-add-icon').each(function(){
		var parent = jQuery(this).parent();
		jQuery(this).on('click',function(){
			modalIcons.show();
			modalIcons.attr( "for",jQuery( this ).attr( "for" ) );
		});

		jQuery(".k2t-receive-icon", parent).on('change',function(){
			jQuery( "[rel-icon='" + jQuery(this).attr("id") + "']").html("<i class='" + jQuery(this).val() + "'></i>");
		});									
		/*
		Remove Icon
		*/
		jQuery(".k2t-remove-icon", parent).on('click',function(){
			current_id = jQuery(this).attr('remove-for');
			jQuery("#" + current_id ).val('');
			jQuery("#" + current_id ).trigger('change');
			jQuery(this).css("display","none");
			jQuery("[rel-icon='" + current_id + "']").css("display","none");
			jQuery("#" + current_id ).css("width","352px");
			return false;
		});
	});

	/*  [ Select icon ]
	- - - - - - - - - - - - - - - - - - - - */
	jQuery( '.k2ticon-generator-icon-select ul li' ).on( 'click', function() {
		insertIcons.attr( 'current-value',jQuery( this ).children( 'label' ).attr( 'for' ) );
	});

	/*  [ Close modal ]
	- - - - - - - - - - - - - - - - - - - - */
	jQuery( '#k2ticon-generator-close' ).on( 'click', function() {
		modalIcons.hide();
	});

	/*  [ Icon pack select ]
	- - - - - - - - - - - - - - - - - - - - */
	jQuery( '#k2ticon-generator-select-pack' ).change( function() {
		var selectedIcons = jQuery(this).val();
		var listIcons     = jQuery( '.k2ticon-generator-icon-select ul' );
		
		if ( selectedIcons == 'fontawesome-icons-list' ) {
			listIcons.hide();
			jQuery( 'ul.fontawesome-icon-list' ).show();
		} 
		if ( selectedIcons == 'line-icons-list' ) {
			listIcons.hide();
			jQuery( 'ul.line-icon-list' ).show();
		}
	});

	jQuery( '#k2ticon-generator-close-html' ).on( 'click', function() {
		jQuery( '#k2ticon-shortcode-html' ).hide();
	});
});
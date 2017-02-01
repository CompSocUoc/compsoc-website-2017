
jQuery.noConflict();

jQuery(document).ready(function($){

	// install, uninstall plugin
   	
	install();

	// tab 

	$('.nav-tab-wrapper a').on('click',function(){
		if ( ! $(this).hasClass('active') ) {
			$('#tabs-container .active').removeClass('active');
			$(this).addClass('active');
			$('.tab-content .active').removeClass('active');
			$( $(this).attr('href') ).addClass('active');
			return false;
		};
	});

	/*  [ Performs a smooth page scroll to an anchor ]
	- - - - - - - - - - - - - - - - - - - - */
	$( '.anchor' ).click( function() {
		$('a:not(.anchor)[href="' + $(this).attr('href') + '"]').each(function(){
			$(this).trigger('click');
		});

		if ( location.pathname.replace( /^\//, '' ) == this.pathname.replace( /^\//, '' ) && location.hostname == this.hostname ) {
			var target = $( this.hash );

			var adminBar = $( '#wpadminbar' ).outerHeight();
			target = target.length ? target : $( '[name=' + this.hash.slice( 1 ) + ']' );
			if ( target.length ) {
				$( 'html,body' ).animate( {
					scrollTop: target.offset().top - adminBar - 100 + "px"
				}, 800 );
				return false;
			}
		}
	} );

	// nav-tab

	$('.nav-tab').on('click',function(){
		if( $(this).attr('href') == '#demos' ) {
			$('.versions-filters li:first-child a').trigger('click');
		}
	});

	// func

	function install(){
		$('.plugin-install').on('click',function(){
			var installing;

			var action = $(this).hasClass('install') ? 'install' : 'uninstall';

			if ( confirm( 'Do you want ' + action + ' plugin: ' + $(this).attr('data-plugin').replace('_', ' ') ) ){ 
				$( this ).hide();

				var $pr = $(this).closest('.plugin-item');

				$pr.find('.spinner').addClass('is-active');

				var pl = Array();
				pl['source']			= $pr.attr('data-source');
				pl['file']				= $pr.attr('data-file');
				pl['slug']				= $pr.attr('data-slug');
				pl['install_nonce']		= $pr.attr('data-install_nonce');
				pl['uninstall_nonce']	= $pr.attr('data-uninstall_nonce');
				pl['name']				= $pr.attr('data-name');
				pl['activate_nonce']	= $pr.attr('data-activate_nonce');

				if ( action == 'install' ) ajax_tgmpa_install( pl, $pr );
				else ajax_uninstall_plugin( pl, $pr );

			};
		});
	}

	/* Install plugin */ 

	function ajax_tgmpa_install( pl, $pr ){
		console.log(pl);

		var plugin_source_temp = ( pl['source'] != '' ) ? "&plugin_source=" +  pl['source'] : "&plugin_source=repo" ;
		console.log( home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20")  + plugin_source_temp + '&tgmpa-install=install-plugin&tgmpa-nonce=' + pl["install_nonce"] );
		console.log( home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20") + plugin_source_temp + '&tgmpa-activate=activate-plugin&tgmpa-nonce=' + pl["activate_nonce"] );
		$.ajax({
			async: false,
			type: 'GET',
			url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20")  + plugin_source_temp + '&tgmpa-install=install-plugin&tgmpa-nonce=' + pl["install_nonce"],
			success: function( data ) {
				$.ajax({
					async: false,
					type: 'GET',	
					url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20") + plugin_source_temp + '&tgmpa-activate=activate-plugin&tgmpa-nonce=' + pl["activate_nonce"],
					success: function( data ) {
						$.ajax({
							async: false,
							type: 'GET',
							//url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&tgmpa-nonce=' + pl["install_nonce"],
							success: function (data) {
								$pr.find('.spinner').removeClass('is-active');
								$pr.find('button:not(.install)').show();
							}
						});
					}
				});
			}
		});
	}

	/* Uninstall plugin */

	function ajax_uninstall_plugin( pl, $pr ){
		console.log(pl['uninstall_nonce']);
		console.log(pl['file']);
		console.log(pl['slug']);
		$.ajax({
			url: ajaxurl,
			data: {
				'action' : 	'lincoln_uninstall_plugin',
				'slug' 	 :  pl['slug'],
				'nonce'  :  pl['uninstall_nonce'],
				'file'	 :  pl['file'],
			},
			success:function(data) {
				// This outputs the result of the ajax request
				$pr.find('.spinner').removeClass('is-active');
				$pr.find('.install').show();
			},
			error: function(errorThrown){
			    console.log(errorThrown);
			}
		});	
	}

}); 
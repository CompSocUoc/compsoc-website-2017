/* Shortcode register buttons */
/* ----------------------------------------------------- */
/* This file for register button insert teacher shortcode to TinyMCE
/* ----------------------------------------------------- */
(function() {
	tinymce.create('tinymce.plugins.k_teacher_button', {
		init : function(ed, url) {
			title = 'k_teacher_button';
			tinymce.plugins.k_teacher_button.theurl = url;
			ed.addButton('k_teacher_button', {
				title	:	'K-Teacher shortcode',
				icon	:	' fa fa-group',
				type	:	'menubutton',
				/* List Button */
				menu: [
					/* --- K Teacher --- */   
					{	
						text: 'Teacher Listing',
						value: 'Teacher Listing',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Teacher Listing',
								body: [
								{type	:	'textbox', name	:	'title', label					:	'Title', value: 'Teachers listing'},
								{type	:	'listbox', name	:	'filter', label					:	'Filter turn on', values: [{text: 'True', value: 'true'},{text: 'False', value: 'false'}], value: 'true'},
								{type	:	'listbox', name	:	'layout', label					:	'Layout', values: [{text: 'Grid', value: 'grid'},{text: 'Listing', value: 'listing'}], value: 'grid'},				
								{type	:	'listbox', name	:	'column', label					:	'Columns', values: [{text: '5 Columns', value: '5'},{text: '4 Columns', value: '4'},{text: '3 Columns', value: '3'},{text: '2 Columns', value: '2'}], value: '5'},
								{type	:	'listbox', name	:	'style', label					:	'Style', values: [{text: 'Style hover 1', value: 'hover-1'},{text: 'Style hover 2', value: 'hover-2'},]},
								],
								onsubmit: function( e ) {
									ed.insertContent( '[k_teacher_listing title="'+ e.data.title +'" filter="'+ e.data.filter +'" column="'+ e.data.column +'" layout="'+ e.data.layout +'" style="'+ e.data.style +'" /]');
								}
							});
						}
					}

				]
			});

		},
		createControl : function(n, cm) {
			return null;
		}
	});

	tinymce.PluginManager.add('k_teacher_button', tinymce.plugins.k_teacher_button);

})();
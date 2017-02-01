/* Shortcode register buttons */
/* ----------------------------------------------------- */
/* This file for register button insert course shortcode to TinyMCE
/* ----------------------------------------------------- */
(function() {
	tinymce.create('tinymce.plugins.k_course_button', {
		init : function(ed, url) {
			title = 'k_course_button';
			tinymce.plugins.k_course_button.theurl = url;
			ed.addButton('k_course_button', {
				title	:	'K-Course shortcode',
				icon	:	' fa fa-leanpub',
				type	:	'menubutton',
				/* List Button */
				menu: [
					/* --- K Course --- */   
					{	
						text: 'Course Listing',
						value: 'Course Listing',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Course Listing',
								body: [
								{type	:	'textbox', name	:	'title', label					:	'Title', value: 'Courses listing'},
								{type	:	'listbox', name	:	'filter', label					:	'Filter turn on', values: [{text: 'True', value: 'true'},{text: 'False', value: 'false'}], value: 'true'},
								{type	:	'listbox', name	:	'layout', label					:	'Layout', values: [{text: 'Grid', value: 'grid'},{text: 'Listing', value: 'listing'}], value: 'grid'},				
								{type	:	'listbox', name	:	'column', label					:	'Columns', values: [{text: '5 Columns', value: '5'},{text: '4 Columns', value: '4'},{text: '3 Columns', value: '3'},{text: '2 Columns', value: '2'}], value: '5'},
								{type	:	'listbox', name	:	'style', label					:	'Style', values: [{text: 'Style hover 1', value: 'hover-1'},{text: 'Style hover 2', value: 'hover-2'},]},
								],
								onsubmit: function( e ) {
									ed.insertContent( '[k_course_listing title="'+ e.data.title +'" filter="'+ e.data.filter +'" column="'+ e.data.column +'" layout="'+ e.data.layout +'" style="'+ e.data.style +'" /]');
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

	tinymce.PluginManager.add('k_course_button', tinymce.plugins.k_course_button);

})();
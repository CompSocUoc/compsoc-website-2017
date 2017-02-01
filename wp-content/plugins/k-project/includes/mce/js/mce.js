/* ----------------------------------------------------- */
/* This file for register button insert project shortcode to TinyMCE
/* ----------------------------------------------------- */
(function() {
	tinymce.create('tinymce.plugins.k2t_pre_project_button', {
		init : function(ed, url) {
			title = 'k2t_pre_project_button';
			tinymce.plugins.k2t_pre_project_button.theurl = url;
			ed.addButton('k2t_pre_project_button', {
				title	:	'project shortcode',
				icon	:	' fa fa-suitcase',
				type	:	'menubutton',
				/* List Button */
				menu: [
					/* --- project --- */   
					{	
						text: 'project',
						value: 'project',
						onclick: function() {
							ed.windowManager.open( {
								title: 'K2t project',
								body: [
								{type	:	'textbox', name	:	'title', label					:	'Project title'},
								{type	:	'listbox', name	:	'filter', label					:	'Filter turn on', values: [{text: 'True', value: 'true'},{text: 'False', value: 'false'}], value: 'true'},				
								{type	:	'listbox', name	:	'filter_align', label			:	'Filter align', values: [{text: 'Left', value: 'left'},{text: 'Center', value: 'center'},{text: 'Right', value: 'right'}], value: 'center'},
								{type	:	'textbox', name	:	'number', label					:	'Number of projects'},
								{type	:	'listbox', name	:	'column', label					:	'Columns', values: [{text: '2 columns', value: '2'},{text: '3 columns', value: '3'},{text: '4 columns', value: '4'},{text: '5 columns', value: '5'},], value: '3'},
								{type	:	'listbox', name	:	'style', label					:	'project style', values: [{text: 'Text Grid', value: 'text-grid'},{text: 'Text Masonry', value: 'text-masonry'},]},
								{type	:	'listbox', name	:	'child_style', label			:	'project child style', values: [{text: 'None', value: 'none'},{text: 'Masonry free style', value: 'masonry_free_style'},]},
								{type	:	'listbox', name	:	'text_align', label				:	'Text Align', values: [{text: 'Center', value: 'center'},{text: 'Left', value: 'left'},{text: 'Right', value: 'right'},]},
								{type	:	'listbox', name	:	'padding', label				:	'Padding', values: [{text: 'Yes', value: 'true'},{text: 'No', value: 'false'},]},
								],
								onsubmit: function( e ) {
									ed.insertContent( '[k2t-project title="'+ e.data.title +'" filter="'+ e.data.filter +'" filter_align="'+ e.data.filter_align +'" number="'+ e.data.number + '" column="'+ e.data.column +'" style="'+ e.data.style +'" child_style="'+ e.data.child_style +'" text_align="'+ e.data.text_align +'" padding="'+ e.data.padding +'" /]');
								}
							});
							}
					},
					
				],
			});

		},
		createControl : function(n, cm) {
			return null;
		}
	});

	tinymce.PluginManager.add('k2t_pre_project_button', tinymce.plugins.k2t_pre_project_button);

})();
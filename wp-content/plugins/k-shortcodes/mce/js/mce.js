/**
 * This file for register button insert shortcode to TinyMCE.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */
 
(function() {
	tinymce.create('tinymce.plugins.k2t_pre_shortcodes_button', {
		init : function(ed, url) {
			title = 'k2t_pre_shortcodes_button';
			tinymce.plugins.k2t_pre_shortcodes_button.theurl = url;
			ed.addButton('k2t_pre_shortcodes_button', {
				title	:	'Select Shortcode',
				icon	:	' fa fa-cubes',
				type : 'menubutton',
				/* List Button */
				menu: [
					/* -----------Accordions-----------	*/
					{
						text: 'Accordion',
						value: 'Accordion',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Accordion',
								body: [
								{type : 'listbox', name : 'style', label						:	'Style', 'values': [{text: 'Style 1', value: '1'}, {text: 'Style 2', value: '2'}, {text: 'Style 3', value: '3'}]},
								{type : 'textbox', name : 'number_toggle', label				:	'Number of accordions (Numeric value only)', value : '3'},
								],
								onsubmit: function(e){
									var i = 0; 
									var content_accordion = '';
									while (i < e.data.number_toggle) {
										content_accordion += '[toggle title="Title here" icon="" open="false" acc_content="Content Here"][/toggle]<br class="nc"/>';
										i++;
									}
									ed.insertContent( '[accordion]<br class="nc"/>'+ content_accordion +'[/accordion]');
								}
							});
						}
					},	// Accordion
					
					/* --- Animation --- */   
					{	
						text: 'Animation',
						value: 'Animation',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Animation',
								body: [
								{type : 'listbox', name : 'anm_name', label						:	'Effect', 'values': [{text: 'Bounce', value: 'bounce'},{text: 'Flash', value: 'flash'},{text: 'Pulse', value: 'pulse'},{text: 'RubberBand', value: 'rubberBand'},{text: 'Shake', value: 'shake'},{text: 'Swing', value: 'swing'},{text: 'Tada', value: 'tada'},{text: 'Wobble', value: 'wobble'},{text: 'BounceIn', value: 'bounceIn'},{text: 'BounceInDown', value: 'bounceInDown'},{text: 'BounceInLeft', value: 'bounceInLeft'},{text: 'BounceInRight', value: 'bounceInRight'},{text: 'BounceInUp', value: 'bounceInUp'},{text: 'FadeIn', value: 'fadeIn'},{text: 'FadeInDown', value: 'fadeInDown'},{text: 'FadeInDownBig', value: 'fadeInDownBig'},{text: 'FadeInLeft', value: 'fadeInLeft'},{text: 'FadeInLeftBig', value: 'fadeInLeftBig'},{text: 'FadeInRight', value: 'fadeInRight'},{text: 'FadeInRightBig', value: 'fadeInRightBig'},{text: 'FadeInUp', value: 'fadeInUp'},{text: 'FadeInUpBig', value: 'fadeInUpBig'},{text: 'Flip', value: 'flip'},{text: 'FlipInX', value: 'flipInX'},{text: 'FlipInY', value: 'flipInY'},{text: 'LightSpeedIn', value: 'lightSpeedIn'},{text: 'RotateIn', value: 'rotateIn'},{text: 'RotateInDownLeft', value: 'rotateInDownLeft'},{text: 'RotateInDownRight', value: 'rotateInDownRight'},{text: 'RotateInUpLeft', value: 'rotateInUpLeft'},{text: 'RotateInUpRight', value: 'rotateInUpRight'},{text: 'RollIn', value: 'rollIn'},{text: 'ZoomIn', value: 'zoomIn'},{text: 'ZoomInDown', value: 'zoomInDown'},{text: 'ZoomInLeft', value: 'zoomInLeft'},{text: 'ZoomInRight', value: 'zoomInRight'},{text: 'ZoomInUp', value: 'zoomInUp'}]},
								{type : 'textbox', name : 'anm_delay', label					:	'Delay (Numeric value only, 1000 = 1second)', value: '1000'},
								],
								onsubmit: function( e ) {
									content = ed.selection.getContent();
									ed.insertContent( '[animation anm_name="'+ e.data.anm_name +'" anm_delay="'+ e.data.anm_delay +'"]'+ content +'[/animation]');
								}
							});
							}
					},
					
					/* --- Brands --- */   
					{	
						text: 'Brands',
						value: 'Brands',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Brands',
								body: [
								{type : 'textbox', name : 'number_brands', label				: 	'Number of brands (Numeric value only)', value : '6'},
								{type : 'listbox', name : 'column', label						: 	'Number of Columns', 'values': [{text: '1', value: '1'},{text: '2', value: '2'},{text: '3', value: '3'},{text: '4', value: '4'},{text: '5', value: '5'},{text: '6', value: '6'},{text: '7', value: '7'},{text: '8', value: '8'}], value : '4',},
								{type : 'listbox', name : 'padding', label						: 	'Padding', 'values': [{text: 'False', value: 'false'},{text: 'True', value: 'true'}]},
								{type : 'listbox', name : 'grayscale', label					: 	'Grayscale', 'values': [{text: 'False', value: 'false'},{text: 'True', value: 'true'}]},
								],
								onsubmit: function(e){
									var i = 0; 
									var content_brands = '';
									while (i < e.data.number_brands) {
										content_brands += '[brand title="Brand title" tooltip="false" link="URL image here"][/brand]<br class="nc"/>';
										i++;
									}
									ed.insertContent( '[brands column="'+ e.data.column +'" padding="'+ e.data.padding +'" grayscale="'+ e.data.grayscale +'"]<br class="nc"/>'+content_brands+'[/brands]');
								}
							});
						}
					},
					
					/* -----------Button-----------	*/
					{
						text: 'Button',
						value: 'Button',
						menu: [
							/* --- Button --- */  
							{	
								text: 'Button',
								value: 'Button',
								onclick: function() {
									ed.windowManager.open( {
										title: 'Button',
										body: [
										{type : 'textbox', name : 'title', label				:	'Button Text',},
										{type : 'textbox', name : 'link', label					:	'link',},
										{type : 'listbox', name : 'target', label				:	'Link Target', 'values': [{text: 'Blank', value: '_blank'}, {text: 'Self', value: '_self'}]},
										{type : 'textbox', name : 'icon', label					:	'Icon',},
										{type : 'listbox', name : 'icon_position', label		:	'Icon Position', 'values': [{text: 'Right', value: 'right'},{text: 'Left', value: 'left'}]},
										{type : 'listbox', name : 'size', label					:	'Size', 'values': [{text: 'Small', value: 'small'},{text: 'Medium', value: 'medium'},{text: 'Large', value: 'large'}], value : 'medium',},
										{type : 'listbox', name : 'align', label				:	'Align', 'values': [{text: 'Left', value: 'left'},{text: 'Right', value: 'right'},{text: 'Center', value: 'center'}]},
										{type : 'listbox', name : 'button_style', label			:	'Style', 'values': [{text: 'Dark Grey', value: 'dark_grey'},{text: 'Orange', value: 'orange'},{text: 'Dark Blue', value: 'dark_blue'},{text: 'Dark Red', value: 'dark_red'},{text: 'Light Grey', value: 'light_grey'},{text: 'Light Blue', value: 'light_blue'},{text: 'Green', value: 'green'},{text: 'Custom', value: 'custom'}]},
										{type : 'listbox', name : 'fullwidth', label			:	'Full Width', 'values': [{text: 'False', value: 'false'},{text: 'True', value: 'true'}]},
										{type : 'textbox', name : 'color', label				:	'Button Background Color',},
										{type : 'textbox', name : 'text_color', label			:	'Button Text Color',},
										{type : 'textbox', name : 'hover_bg_color', label		:	'Background Hover Color',},
										{type : 'textbox', name : 'hover_text_color', label		:	'Text Hover Color',},
										{type : 'textbox', name : 'border_color', label			:	'Button border Color',},
										{type : 'textbox', name : 'border_width', label			:	'Button border width',},
										{type : 'textbox', name : 'hover_border_color', label	:	'Border Hover Color',},
										{type : 'textbox', name : 'radius', label				:	'Button radius',},
										{type : 'listbox', name : 'pill', label					:	'Pill', 'values': [{text: 'False', value: 'false'},{text: 'True', value: 'true'}]},
										{type : 'listbox', name : 'd3', label					:	'3D', 'values': [{text: 'False', value: 'false'},{text: 'True', value: 'true'}]},
										],
										onsubmit: function( e ) {
											content = ed.selection.getContent();
											ed.insertContent( '[button title="'+ e.data.title +'" link="'+ e.data.link +'" target="'+ e.data.target +'" icon="'+ e.data.icon +'" icon_position="'+ e.data.icon_position +'" size="'+ e.data.size +'" align="'+ e.data.align +' button_style="'+ e.data.button_style +'" fullwidth="'+ e.data.fullwidth +'" color="'+ e.data.color +'" text_color="'+ e.data.text_color +'" hover_bg_color="'+ e.data.hover_bg_color +'" hover_text_color="'+ e.data.hover_text_color +'" border_color="'+ e.data.border_color +'" border_width="'+ e.data.border_width +'" hover_border_color="'+ e.data.hover_border_color +'" radius="'+ e.data.radius +'" pill="'+ e.data.pill +'" d3="'+ e.data.d3 +'"]'+ content +'[/button]<br class="nc"/>');
										}
									});
									}      
							},
							
							/* --- Circle Button --- */  
							{	
								text: 'Circle Button',
								value: 'Circle Button',
								onclick: function() {
									ed.windowManager.open( {
										title: 'Circle Button',
										body: [
										{type : 'textbox', name : 'name', label					:	'Button Name',},
										{type : 'textbox', name : 'link', label					:	'Link To',},
										{type : 'textbox', name : 'icon_hover', label			:	'Icon Hover',},
										{type : 'textbox', name : 'background_color', label		:	'Button Color',}
										],
										onsubmit: function( e ) {
											ed.insertContent( '[circle_button name="'+ e.data.name +'" link="'+ e.data.link +'" icon_hover="'+ e.data.icon_hover +'" background_color="'+ e.data.background_color +'" /]<br class="nc"/>');
										}
									});
									}      
							},
						], // Button
					},	// Button
					
					/* --- Dropcap --- */  
					{	
						text: 'Dropcap',
						value: 'Dropcap',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Dropcap',
								body: [
								{type : 'listbox', name : 'style_dropcap', label				: 	'Dropcap Style', 'values': [{text: 'Style 1', value: '1'},{text: 'Style 2', value: '2'},{text: 'Style 3', value: '3'}]},
								{type : 'textbox', name : 'css', label							: 	'Custom CSS',}
								],
								onsubmit: function( e ) {
									content = ed.selection.getContent();
									ed.insertContent( '[dropcap style="'+ e.data.style_dropcap +'" css="'+ e.data.css +'"]'+content+'[/dropcap]<br class="nc"/>');
								}
							});
							}      
					},

					/* --- Google Map --- */   
					{
						text: 'Google map',
						value: 'Google map',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Google map',
								body: [
								{type : 'textbox', name : 'z', label							: 	'Zoom level (between 0-20)', value: '15'},
								{type : 'textbox', name : 'lat', label							: 	'Latitude', value : '0'},
								{type : 'textbox', name : 'lon', label							: 	'Longitude', value : '0'},
								{type : 'textbox', name : 'w', label							: 	'Width (unit is pixel, default 600)',},
								{type : 'textbox', name : 'h', label							: 	'Height (unit is pixel, default 400)',},
								{type : 'textbox', name : 'address', label						: 	'Address',},
								{type : 'listbox', name : 'marker', label						: 	'Marker', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'textbox', name : 'markerimage', label					: 	'Marker Image URL (to change default Marker)',},
								{type : 'listbox', name : 'traffic', label						: 	'Show Traffic', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'listbox', name : 'draggable', label					: 	'Draggable', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'listbox', name : 'infowindowdefault', label			: 	'Show Info Map', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'textbox', name : 'infowindow', label					: 	'Content Info Map (Strong, br are accepted)',},
								{type : 'listbox', name : 'hidecontrols', label					: 	'Hide Control', 'values': [{text: 'False', value: 'false'},{text: 'True', value: 'true'}]},
								{type : 'listbox', name : 'scrollwheel', label					: 	'Scroll wheel zooming', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'listbox', name : 'maptype', label						: 	'Map Type', 'values': [{text: 'ROADMAP', value: 'ROADMAP'},{text: 'SATELLITE', value: 'SATELLITE'},{text: 'HYBRID', value: 'HYBRID'}, {text: 'TERRAIN', value: 'TERRAIN'}]},
								{type : 'listbox', name : 'mapstype', label						: 	'Map style', 'values': [{text: 'None', value: ''}, {text: 'Subtle Grayscale', value: 'grayscale'}, {text: 'Blue water', value: 'blue_water'}, {text: 'Pale Dawn', value: 'pale_dawn'}, {text: 'Shades of Grey', value: 'shades_of_grey'}]},
								{type : 'textbox', name : 'color_map', label					: 	'Map Color (Check code color: http://colorpicker.com/)',}
								],
								onsubmit: function( e ) {
									content = ed.selection.getContent();
									ed.insertContent( '[google_map z="'+e.data.z+'" lat="'+e.data.lat+'" lon="'+e.data.lon+'" w="'+e.data.w+'" h="'+e.data.h+'" address="'+e.data.address_map+'" marker="'+e.data.marker_map+'" markerimage="'+e.data.markerimage+'" traffic="'+e.data.traffic+'" draggable="'+e.data.draggable+'" infowindowdefault="'+e.data.infowindowdefault+'" infowindow="'+e.data.infowindow+'" hidecontrols="'+e.data.hidecontrols+'" scrollwheel="'+e.data.scrollwheel+'" maptype="'+e.data.maptype+'" mapstype="'+e.data.mapstype+'" color="'+e.data.color_map+'"/]');
								}
							});
							}      
					},
					
					/* -----------Heading-----------	*/
					{
						text: 'Heading',
						value: 'Heading',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Heading',
								body: [
								{type : 'textbox', name : 'content', label						:	'Title',},
								{type : 'textbox', name : 'subtitle', label						: 	'Content Subtitle', multiline: true, minWidth: 300, minHeight: 60},
								{type : 'listbox', name : 'h', label 							:	'Headi	ng Tag', 'values': [{text: 'H1', value: 'h1'},{text: 'H2', value: 'h2'},{text: 'H3', value: 'h3'},{text: 'H4', value: 'h4'},{text: 'H5', value: 'h5'},{text: 'H6', value: 'h6'}, {text: 'Custom', value: 'custom'}], value: 'h2'},
								{type : 'listbox', name : 'align', label 						:	'Align', 'values': [{text: 'Left', value: 'left'},{text: 'Center', value: 'center'},{text: 'Right', value: 'right'}]},
								{type : 'textbox', name : 'font', label 						:	'Us Google Font',},
								{type : 'textbox', name : 'font_size', label 					:	'Custom Font Size',},
								{type : 'listbox', name : 'border', label		 				: 	'H	as border', 'values': [{text: 'True', value: 'true'}, {text: 'False', value: 'false'}]},
								{type : 'listbox', name : 'border_style', label		 			: 	'Border Style', 'values': [{text: 'Short Line', value: 'short_line'}, {text: 'Bottom Icon', value: 'bottom_icon'}, {text: 'Heading', value: 'heading'}, {text: 'Boxed Heading', value: 'boxed_heading'}, {text: 'Bottom Border', value: 'bottom_border'}, {text: 'Line Through', value: 'line_through'}, {text: 'Double Line', value: 'double_line'}, {text: 'Dotted Line', value: 'three_dotted'}, {text: 'Fat Line', value: 'fat_line'}]},
								{type : 'textbox', name : 'icon', label 						:	'Icon',}
								],
								onsubmit: function( e ) {
									content = ed.selection.getContent();
									ed.insertContent( '[heading content="'+ e.data.content +'" subtitle="'+ e.data.subtitle +'" h="'+ e.data.h +'" align="'+ e.data.align +'" font="'+ e.data.font +'" font_size="'+ e.data.font_size +'" border="'+ e.data.border +'" border_style="'+ e.data.border_style +'" icon="'+ e.data.icon +'"][/heading]<br class="nc"/>');
								}
							});
						}
					},/* Heading */
					
					/* -----------Helper shortcodes-----------	*/
					{
						text: 'Helper shortcodes',
						value: 'Helper shortcodes',
						menu: [
							/* --- Align --- */   
							{	
								text: 'Align',
								value: 'Align',
								onclick: function() {
									ed.windowManager.open( {
										title: 'Align',
										body: [
										{type : 'listbox', name : 'align', label				:	'Align', 'values': [{text: 'Left', value: 'left'},{text: 'Center', value: 'center'},{text: 'Right', value: 'right'}]},
										],
										onsubmit: function( e ) {
											content = ed.selection.getContent();
											if(!content){ content = 'Content Here';} else { content = content;}
											ed.insertContent( '[align align="'+e.data.align+'"]'+content+'[/align]');
										}
									});
									}      
							},
							
							/* --- Blockquote --- */   
							{	
								text: 'Blockquote',
								value: 'Blockquote',
								onclick: function() {
									ed.windowManager.open( {
										title: 'Blockquote',
										body: [
										{type : 'listbox', name : 'style', label				:	'Style', 'values': [{text: 'Style 1', value: '1'},{text: 'Style 2', value: '2'}]},
										{type : 'listbox', name : 'align', label				:	'Align', 'values': [{text: 'Left', value: 'left'},{text: 'Center', value: 'center'},{text: 'Right', value: 'right'}]},
										{type : 'textbox', name : 'author', label				:	'Author Name',},
										{type : 'textbox', name : 'link_author', label			:	'Author Link',},
										{type : 'textbox', name : 'content', label				:	'Content', multiline: true, minWidth: 300, minHeight: 60},
										],
										onsubmit: function( e ) {
											content = ed.selection.getContent();
											ed.insertContent( '[blockquote style="'+e.data.style+'" align="'+e.data.align+'" author="'+e.data.author+'" link_author="'+e.data.link_author+'" content="'+e.data.content+'"][/blockquote]');
										}
									});
								}      
							},
							
							/* --- Br --- */   
							{	
								text: 'Break',
								value: 'Break',
								onclick: function() {
									ed.insertContent( '[br /]');
								}
							},
							
							/* --- Clear --- */   
							{	
								text: 'Clear',
								value: 'Clear',
								onclick: function() {
									ed.insertContent( '[clear /]');
								}
							},
							
							/* --- Container --- */   
							{	
								text: 'Container',
								value: 'Container',
								onclick: function() {
									content = ed.selection.getContent();
									if(!content){ content = 'Content Here';} else { content = content;}
									ed.insertContent( '[container]'+content+'[/container]');
								}
							},
							
							/* --- CountDown --- */   
							{	
								text: 'CountDown',
								value: 'CountDown',
								onclick: function() {
									ed.windowManager.open( {
										title: 'CountDown',
										body: [
										{type : 'listbox', name : 'style', label				:	'Countdown Style', 'values': [{text: 'Square', value: 'square'}, {text: 'Square Fill Color', value: 'square-fill'}, {text: 'Circle', value: 'circle'}, {text: 'Circle Fill Color', value: 'circle-fill'}, {text: 'Solid', value: 'solid'}]},
										{type : 'textbox', name : 'time', label					:	'Time(the time in this format: YYYY-MM-DD-HH-MM-SS)', value : '0000-00-00-00-00-00',},
										{type : 'textbox', name : 'year', label					:	'The word "Year(s)" in your language',},
										{type : 'textbox', name : 'month', label				:	'The word "Month(s)" in your language'},
										{type : 'textbox', name : 'day', label					:	'The word "Day(s)" in your language'},
										{type : 'textbox', name : 'hour', label					:	'The word "Hour(s)" in your language'},
										{type : 'textbox', name : 'minute', label				:	'The word "Minute(s)" in your language'},
										{type : 'textbox', name : 'second', label				:	'The word "Second(s)" in your language'},
										{type : 'textbox', name : 'fontsize', label				:	'Font Size(Numeric value only, unit is pixel)'},
										{type : 'listbox', name : 'align', label				:	'Align', 'values': [{text: 'Left', value: 'left'},{text: 'Right', value: 'right'},{text: 'Center', value: 'center'}]},
										{type : 'textbox', name : 'background_color', label		:	'Background Color'},
										{type : 'textbox', name : 'text_color', label			:	'Text Color'},
										],
										onsubmit: function( e ) {
											content = ed.selection.getContent();
											ed.insertContent( '[countdown time="'+ e.data.time +'" year="'+ e.data.year +'" month="'+ e.data.month +'" day="'+ e.data.day +'" hour="'+ e.data.hour +'" minute="'+ e.data.minute +'" second="'+ e.data.second +'" fontsize="'+ e.data.fontsize +'" align="'+ e.data.align +'" background_color="'+ e.data.background_color +'" text_color="'+ e.data.text_color +'" /]');
										}
									});
								}
							},
							
							/* --- Embed --- */   
							{	
								text: 'Embed',
								value: 'Embed',
								onclick: function() {
									ed.windowManager.open( {
										title: 'Embed',
										body: [
											{type : 'textbox', name : 'width', label			:	'Width (numeric value only, unit is px)',},
											{type : 'textbox', name : 'content', label			:	'URL or embed code',},
										],
										onsubmit: function( e ) {
											ed.insertContent( '[k2t_embed width="'+ e.data.width +'" content="'+ e.data.content +'" /]');
										}
									});
									}      
							},
							
							/* --- Highlight --- */   
							{	
								text: 'Highlight',
								value: 'Highlight',
								onclick: function() {
									ed.windowManager.open( {
										title: 'Highlight',
										body: [
										{type : 'textbox', name : 'color', label				:	'Color',},
										{type : 'textbox', name : 'text_color', label			:	'Text Color',},
										{type : 'listbox', name : 'style', label				:	'Style', 'values': [{text: '1', value: '1'},{text: '2', value: '2'}]},
										],
										onsubmit: function( e ) {
											content = ed.selection.getContent();
											if(!content){ content = 'Content Here';} else { content = content;}
											ed.insertContent( '[highlight text_color="'+e.data.text_color+'" color="'+e.data.color+'" style="'+e.data.style+'"]'+content+'[/highlight]');
										}
									});
									}      
							},
							
							/* --- Section --- */   
							{	
								text: 'Section',
								value: 'Section',
								onclick: function() {
									ed.windowManager.open( {
										title: 'Section',
										body: [
										{type : 'textbox', name : 'id', label					:	'ID',},
										{type : 'textbox', name : 'padding_top', label			:	'Top Padding (Numeric value only, unit is pixel)',},
										{type : 'textbox', name : 'padding_bottom', label		:	'Bottom Padding (Numeric value only, unit is pixel)',},
										{type : 'textbox', name : 'padding_left', label			:	'Left Padding (Numeric value only, unit is pixel)',},
										{type : 'textbox', name : 'padding_right', label		:	'Right Padding (Numeric value only, unit is pixel)',},
										],
										onsubmit: function( e ) {
											content = ed.selection.getContent();
											if(!content){ content = 'Content Here';} else { content = content;}
											ed.insertContent( '[section id="'+e.data.id+'" padding_top="'+e.data.padding_top+'" padding_bottom="'+e.data.padding_bottom+'" padding_left="'+e.data.padding_left+'" padding_right="'+e.data.padding_right+'"]'+content+'[/section]');
										}
									});
								}      
							},
							
							/* --- Spacer --- */   
							{	
								text: 'Spacer',
								value: 'Spacer',
								onclick: function() {
									ed.insertContent( '[spacer height="" /]');
								}
							},
							
						], // Helper shortcodes
					},	// Helper shortcodes
					
					/* --- Icon box --- */   
					{	
						text: 'Icon box',
						value: 'Icon box',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Icon box',
								body: [
								{type : 'listbox', name : 'layout', label						:	'Layout', 'values': [{text: '1', value: '1'},{text: '2', value: '2'},{text: '3', value: '3'},]},
								{type : 'textbox', name : 'title', label						:	'Title'},
								{type : 'textbox', name : 'subtitle', label						:	'Sub Title'},
								{type : 'textbox', name : 'fontsize', label						:	'Title Font Size'},
								{type : 'textbox', name : 'color', label						:	'Title Color'},
								{type : 'listbox', name : 'text_transform', label				:	'Text Transform', 'values': [{text: 'Inherit', value: 'inherit'},{text: 'Uppercase', value: 'uppercase'},{text: 'Lowercase', value: 'lowercase'}, {text: 'Initial', value: 'initial'}, {text: 'Capitalize', value: 'capitalize'}]},
								{type : 'listbox', name : 'icon_type', label					:	'Icon Type', 'values': [{text: 'Icon Fonts', value: 'icon_fonts'},{text: 'Graphics', value: 'graphics'}]},
								{type : 'textbox', name : 'graphic', label						:	'Graphic url'},
								{type : 'listbox', name : 'icon_hover', label					:	'Enable hover effect', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'textbox', name : 'icon', label							:	'Icon'},
								{type : 'textbox', name : 'icon_font_size', label				:	'Icon size'},
								{type : 'textbox', name : 'icon_color', label					:	'Icon Color'},
								{type : 'textbox', name : 'icon_background', label				:	'Icon Background'},
								{type : 'textbox', name : 'icon_border_color', label			:	'Icon Border Color'},
								{type : 'listbox', name : 'icon_border_style', label			:	'Icon Background', 'values': [{text: 'Solid', value: 'solid'},{text: 'Dashed', value: 'dashed'}]},
								{type : 'textbox', name : 'icon_border_width', label			:	'Icon Border Width'},
								{type : 'textbox', name : 'icon_border_radius', label			:	'Icon Border Radius'},
								{type : 'listbox', name : 'align', label						:	'Align', values: [{text: 'Left', value: 'left'}, {text: 'Center', value: 'center'}, {text: 'Right', value: 'right'}]},
								{type : 'textbox', name : 'link', label							:	'Link To'},
								{type : 'textbox', name : 'link_text', label					:	'Link Text', value : 'Learn more &rarr;',},
								{type : 'textbox', name : 'content', label						:	'Content'},
								{type : 'textbox', name : 'box_background_color', label			:	'Box background Color'},
								{type : 'listbox', name : 'box_border', label					:	'Box Border', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'textbox', name : 'box_border_color', label				:	'Box Border Color'},
								],
								onsubmit: function( e ) {
									content = ed.selection.getContent();
									ed.insertContent( '[iconbox layout="'+ e.data.layout +'" title="'+ e.data.title +'" subtitle="'+e.data.subtitle +'" fontsize="'+e.data.fontsize +'" color="'+e.data.color +'" text_transform="'+e.data.text_transform +'" icon_type="'+e.data.icon_type +'" graphic="'+e.data.graphic +'" icon_hover="'+e.data.icon_hover +'" icon="'+ e.data.icon +'" icon_font_size="'+ e.data.icon_font_size +'" icon_color="'+ e.data.icon_color +'" icon_background="'+ e.data.icon_background +'" icon_border_color="'+ e.data.icon_border_color +'" icon_border_style="'+ e.data.icon_border_style +'" icon_border_width="'+ e.data.icon_border_width +'" icon_border_radius="'+ e.data.icon_border_radius +'" align="'+ e.data.align +'" link="'+ e.data.link +'" link_text="'+ e.data.link_text +'" content="'+ e.data.content +'" box_background_color="'+ e.data.box_background_color +'" box_border="'+ e.data.box_border +'" box_border_color="'+ e.data.box_border_color +'" /]');
								}
							});
						}      
					},
					
					/* -----------List shortcodes-----------	*/
					{
						text: 'List shortcodes',
						value: 'List shortcodes',
						menu: [
							/* --- Icon List --- */   
							{	
								text: 'Icon List',
								value: 'Icon List',
								onclick: function() {
									ed.windowManager.open( {
										title: 'Icon List',
										body: [
										{type : 'textbox', name : 'icon', label					:	'Icon',  value: 'checkmark'},
										{type : 'textbox', name : 'color', label				:	'Color'},
										{type : 'textbox', name : 'number_iconlist', label		:	'Number of lists/rows (numeric value only)', value : '4',}
										],
										onsubmit: function( e ) {
											var i = 0; 
											var content_iconlists = "";
											while (i < e.data.number_iconlist) {
												content_iconlists += '[li title="Title Here" icon="Icon Here"][/li]<br class="nc"/>';
												i++;
											}
											ed.insertContent( '[iconlist icon="'+ e.data.icon +'" color="'+ e.data.color +'"]<br class="nc"/>'+content_iconlists+'[/iconlist]');
										}
									});
								}
							},
						], // List shortcodes
					},	// List shortcodes
					
					/* --- Member --- */   
					{	
						text: 'Member',
						value: 'Member',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Member',
								body: [
								{type : 'listbox', name : 'style', label						:	'Style', 'values': [{text: 'Style 1', value: '1'}, {text: 'Style 2', value: '2'}, {text: 'Style 3', value: '3'}, {text: 'Style 4', value: '4'}]},
								{type : 'textbox', name : 'image', label						:	'Member Avatar'},
								{type : 'textbox', name : 'name', label							:	'Member Name'},
								{type : 'textbox', name : 'role', label							:	'Role'},
								{type : 'textbox', name : 'facebook', label						:	'Facebook URL'},
								{type : 'textbox', name : 'twitter', label						:	'Twitter URL'},
								{type : 'textbox', name : 'skype', label						:	'Skype'},
								{type : 'textbox', name : 'pinterest', label					:	'Pinterest URL'},
								{type : 'textbox', name : 'instagram', label					:	'Instagram'},
								{type : 'textbox', name : 'dribbble', label						:	'Dribbble URL'},
								{type : 'textbox', name : 'google_plus', label					:	'Google Plus URL'},
								{type : 'textbox', name : 'content', label						:	'Member Info', multiline: true, minWidth: 300, minHeight: 60},
								],
								onsubmit: function( e ) {
									content = ed.selection.getContent();
									ed.insertContent( '[member style="'+ e.data.style +'" image="'+ e.data.image +'" name="'+ e.data.name +'" role="'+ e.data.role +'" facebook="'+ e.data.facebook +'" twitter="'+ e.data.twitter +'" skype="'+ e.data.skype +'" pinterest="'+ e.data.pinterest +'" instagram="'+ e.data.instagram +'"  dribbble="'+ e.data.dribbble +'" google_plus="'+ e.data.google_plus +'" content="'+ e.data.content +'" /]');
								}
							});
							}
					},
					
					/* --- Pricing --- */  
					{	
						text: 'Pricing',
						value: 'Pricing',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Pricing',
								body: [
								{type : 'listbox', name : 'number_pricing', label				:	'Number of pricing columns (numeric value only)', 'values': [{text: '1', value: '1'},{text: '2', value: '2'},{text: '3', value: '3'},{text: '4', value: '4'},{text: '5', value: '5'}]},
								{type : 'listbox', name : 'separated', label					:	'Separated', 'values': [{text: 'False', value: 'false'}, {text: 'True', value: 'true'}]},
								],
								onsubmit: function( e ) {
									var i = 0; 
									var content_pricing = "";
									while (i < e.data.number_pricing) {
										content_pricing += '[pricing_column title="" price="" old_price="" price_per="" unit="$" link="" link_text="" target="_self" featured="false" featured_list="false" color="" pricing_content="Content here" /]<br class="nc"/>';
										i++;
									}
									ed.insertContent( '[pricing separated="'+ e.data.separated +'"]<br class="nc"/>'+ content_pricing +'[/pricing]<br class="nc"/>');
								}
							});
							}      
					},
					
					/* --- Progress --- */   
					{
						text: 'Progress',
						value: 'Progress',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Progress',
								body: [
								{type : 'textbox', name : 'percent', label						:	'Percent (numeric value only, between 1-100)', value: '90'},
								{type : 'textbox', name : 'color', label						:	'Color',},
								{type : 'textbox', name : 'background_color', label				:	'Background Color',},
								{type : 'textbox', name : 'text_color', label					:	'Text Color',},
								{type : 'textbox', name : 'title', 	label						:	'Title',},
								{type : 'textbox', name : 'height', label						:	'Height (numeric value only, unit is px)',},
								{type : 'listbox', name : 'striped', label						:	'Striped', 'values': [{text: 'False', value: 'false'},{text: 'True', value: 'true'}]},
								],
								onsubmit: function( e ) {
									ed.insertContent( '[progress percent="'+ e.data.percent +'" color="'+ e.data.color +'" background_color="'+ e.data.background_color +'" text_color="'+ e.data.text_color +'" title="'+ e.data.title +'" height="'+ e.data.height +'" striped="'+ e.data.striped +'" /]');
								}
							});
							}      
					},
					
					/* --- Content Slider --- */  
					{	
						text: 'Content Slider',
						value: 'Content Slider',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Content Slider',
								body: [
								{type : 'textbox', name : 'number_content', label				: 	'Number of slides', value : '3'},
								{type : 'listbox', name : 'auto', label							: 	'Auto slide', 'values': [{text: 'False', value: 'false'},{text: 'True', value: 'true'}]},
								{type : 'textbox', name : 'auto_time', label					: 	'Auto time (Numeric value only, 1000 =  1second)', value: '5000'},
								{type : 'textbox', name : 'speed', label						: 	'Speed (Numeric value only, 1000 = 1second)', value: '500'},
								{type : 'listbox', name : 'pager', label						: 	'Pagination', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'listbox', name : 'navi', label							: 	'Navigation', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'listbox', name : 'touch', label						: 	'Touch', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'listbox', name : 'mousewheel', label					: 	'Mousewheel', 'values': [{text: 'False', value: 'false'},{text: 'True', value: 'true'}]},
								{type : 'listbox', name : 'loop', label							: 	'Loop', 'values': [{text: 'True', value: 'true'},{text: 'False', value: 'false'}]},
								{type : 'listbox', name : 'keyboard', label						: 	'Keyboard navigation', 'values': [{text: 'False', value: 'false'},{text: 'True', value: 'true'}]},
								],
								onsubmit: function( e ) {
									var i = 0; 
									var content_content_slider = '';
									while (i < e.data.number_content) {
										content_content_slider += '[slide]Content Here[/slide]<br class="nc"/>';
										i++;
									}
									ed.insertContent( '[content_slider auto="'+e.data.auto+'" auto_time="'+e.data.auto_time+'" speed="'+e.data.speed+'" pager="'+e.data.pager+'" navi="'+e.data.navi+'" touch="'+e.data.touch+'" mousewheel="'+e.data.mousewheel+'" loop="'+e.data.loop+'" keyboard="'+e.data.keyboard+'"]<br class="nc"/>'+content_content_slider+'[/content_slider]<br class="nc"/>');
								}
							});
						}      
					},
					
					/* --- Testimonial --- */  
					{	
						text: 'Testimonial',
						value: 'Testimonial',
						onclick: function() {
							ed.windowManager.open( {
								title: 'Testimonial',
								body: [
								{type : 'listbox', name : 'style', label						:	'Style', 'values': [{text: 'Style 1', value: '1'}, {text: 'Style 2', value: '2'}, {text: 'Style 3', value: '3'}]},
								{type : 'textbox', name : 'image', label						:	'Image URL',},
								{type : 'listbox', name : 'align', label						:	'Avatar Position', 'values': [{text: 'Left', value: 'left'}, {text: 'Right', value: 'right'}]},
								{type : 'textbox', name : 'name', label							:	'Name',},
								{type : 'textbox', name : 'position', label						:	'Position',},
								{type : 'textbox', name : 'link_name', label					:	'Link to',},
								{type : 'listbox', name : 'target', label						:	'Target Link', 'values': [{text: '_blank', value: '_blank'},{text: '_self', value: '_self'}]},
								{type : 'textbox', name : 'content', label						:	'content', multiline: true, minWidth: 300, minHeight: 60},
								],
								onsubmit: function( e ) {
									content = ed.selection.getContent();
									ed.insertContent( '[testimonial style="'+ e.data.style +'" image="'+ e.data.image +'" align="'+ e.data.align +'" name="'+e.data.name+'" position="'+ e.data.position +'" link_name="'+ e.data.link_name +'" target="'+e.data.target +'" content="'+ e.data.content +' /]<br class="nc"/>');
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

	tinymce.PluginManager.add('k2t_pre_shortcodes_button', tinymce.plugins.k2t_pre_shortcodes_button);

})();
var $ = jQuery;

// Load detail single portfolio by ajax and enable popup
function k2t_load_single_project(popup_id, project_id){
	var $ = jQuery;
	$.ajax({
		type: "GET",
		url: ajax_object.ajaxurl,
		dataType: 'html',
		data: ({ action: 'k2t_load_single_project_ajax', id: project_id}),
		success: function(data){
			$('#'+popup_id+' .surface').html( data );
		}			
	});
}


jQuery(document).ready(function($) {
	$(document).on('click','#publish', function(event) {
		event.preventDefault();
		var section_array = new Array();
		var post_id = $('#post_ID').val();
		
		//extension_data = 
		$('.row-container .section-container').each(function(){
			var column_array = new Array();
			$(this).find('.dx-columns').each(function(){ 
				
				extension_data = {};
				// To add extension custom data
				$(this).trigger('extension_data');
				
				column_item = {
								"column_name" 	 	  : $(this).find('.dx-section-name').html(),
								"column_size" 	 	  : $(this).find('.dx-column-part').html(),
								"col_class" 	 	  : $(this).find('.dx-col-classes').html(),
								"column_view" 	 	  : $(this).data('view'),
								"column_indx" 	 	  : $(this).data('indx'),
								"column_class" 	  	  : $(this).attr('data-class'),
								"column_padding" 	  : $(this).attr('data-padding'),
								"column_padding_type" : $(this).attr('data-padding_type'),
								"column_background"	  : $(this).attr('data-background'),
								"column_boder" 	  	  : $(this).attr('data-boder'),
								"column_alert" 	  	  : $(this).attr('data-alert'),
								"column_alert_ids" 	  : $(this).attr('data-alert-ids'),
								"column_data" 	 	  : $(this).find('.hidden').html(),
								"dialog_data" 	 	  : $(this).find('.hidden-dialog').html(),
								"extension_data"	  : extension_data
							};	
				
				column_array.push(column_item);
			});

			section_item = {
								"section_order"   		: $(this).data('section'),
								"section_name"	  		: $(this).find('.dx-column-name').html(),
								"section_classes" 		: $(this).find('.dx-section-classes').html(),
								"section_select_class"  : $(this).find('.dx-select-section-class').val(),
								"column_array"	  		: column_array
							};
			section_array.push(section_item);
		});
		
		var data =  {	
						post_id				: post_id,
						action				: 'dx_single_template',
						template_data 		: JSON.stringify(section_array),
					}
		
		jQuery.post(ajaxurl,data,function(response) {
			
			//if ( jQuery(document).find(".wp-editor-area").length ) {
				//jQuery(document).find(".wp-editor-area").val(response);
			//}
			//tinyMCE.get('content').setContent(response);
			
			jQuery('form#post').append('<input type="hidden" name="publish" value="Publish" /> ');
			jQuery('form#post').submit();
		});
	});
});									
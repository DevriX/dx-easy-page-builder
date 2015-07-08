jQuery(document).ready(function($) {
	
	// Access Element 
	jQuery(document).on("click",".dx-setting-column",function(){
		var data = $(this).parents('div[data-view]').data('view');
		$(this).data_element_access(data);
	});

	jQuery(document).on("click",".dx-element-setting", function(event){
		
		var current_element = $(this).parent('div').find('.dx-contact-form-right-ele');
		
		jQuery(".dx-contactform-attribute-name").val(current_element.attr('name'));
		jQuery(".dx-contactform-attribute-id").val(current_element.attr('id'));
		jQuery(".dx-contactform-attribute-class").val(jQuery.trim(current_element.attr('class').replace('dx-contact-form-right-ele', '')));
		jQuery(".dx-contactform-attribute-placeholder").val(current_element.attr('placeholder'));
		jQuery(".dx-contactform-attribute-maxlength").val(current_element.attr('maxlength'));
		
	  	jQuery('#dx-contactform-attributes').dialog({
			width:500,
			height:350,
			buttons: {
		        'Save': function() {
							jQuery( this ).dialog( "close" );
							
							var name 		= jQuery(".dx-contactform-attribute-name").val();
							var id 			= jQuery(".dx-contactform-attribute-id").val();
							var clas 		= jQuery(".dx-contactform-attribute-class").val();
							var placeholder = jQuery(".dx-contactform-attribute-placeholder").val();
							var maxlength 	= jQuery(".dx-contactform-attribute-maxlength").val();
							
							current_element.attr('name',name);
							current_element.attr('id',id);
							current_element.addClass(clas);
							current_element.attr('placeholder',placeholder);
							current_element.attr('maxlength',maxlength);
		    		    }
					}
		});
	});
	
	
});
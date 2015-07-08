jQuery(document).ready(function($) {
	
	// Edit row 
	$.fn.edit_rowname = function(action){ 
		 

		// Change name of Column
		if(action.action === 'edit'){ 
			var parent_div = $(this).parents('.dx-control-wrapper');
			
			if(action.input === 'section') {
				var input_val = parent_div.find('.dx-column-name').html();
				parent_div.find('.dx-column-name').html("<input type='text' value='"+input_val+"'>");
				parent_div.find('.dx-edit-section-btn-ok').show();
			}
			else if(action.input === 'class') {
				var input_val = parent_div.find('.dx-section-classes').html();
				parent_div.find('.dx-section-classes').html("<input type='text' value='"+input_val+"'>");
				parent_div.find('.dx-edit-classes-btn-ok').show();
			}
			else {
				
				parent_div = $(this).parents('.dx-columns');
				
				var input_val = parent_div.find('.dx-col-classes').html();
				parent_div.find('.dx-col-classes').html("<input type='text' value='"+input_val+"'>");
				parent_div.find('.dx-edit-col-classes-btn-ok').show();
			}
			
			$(this).hide();
		}
		// Set name of column
		if(action.action === 'setval'){
			var parent_div = $(this).parents('.dx-control-wrapper');
			
			if(action.input === 'section') {
				var input_val = parent_div.find('.dx-column-name input').val();
				parent_div.find('.dx-column-name').html(input_val);
				parent_div.find('.dx-edit-section-btn').show();
			}
			else if(action.input === 'class') {
				var input_val = parent_div.find('.dx-section-classes input').val();
				parent_div.find('.dx-section-classes').html(input_val);
				parent_div.find('.dx-edit-classes-btn').show();
			}
			else {
				
				parent_div = $(this).parents('.dx-columns');
				
				var input_val = parent_div.find('.dx-col-classes input').val();
				parent_div.find('.dx-col-classes').html(input_val);
				parent_div.find('.dx-edit-col-classes-btn').show();
			}
			
			$(this).hide();
			return false;
		}
	}

	// Change column width
	$.fn.changecolumnwidth = function(action){
		var parent 	 = $(this).parents('.dx-columns');
	 	var old_size = parent.find('.dx-column-part').html();	
		var column   = $(this).parent(); 
		// Decrease size of column
		if(action.action === 'decrease'){
			var new_size = old_size-1;
		 	if(new_size>2)
		 	{
		 		column.removeClass('dx-col-'+old_size)
		 			  .addClass('dx-col-'+new_size);
		 		parent.find('.dx-column-part').html(new_size);
			 }
		}
		if(action.action === 'increase'){
			var new_size = parseInt(old_size)+1;
		 	if(new_size < 13)
		 	{
		 		column.removeClass('dx-col-'+old_size)
		 		      .addClass('dx-col-'+new_size);
		 		parent.find('.dx-column-part').html(new_size);
			 }
		}
	}
	// Initialize Editor
	 $.fn.dx_epb_init_tiny_mce = function dx_epb_init_tiny_mce(editor_indx) {
	 	
		jQuery(document).find('#'+editor_indx).each(function(index) {
		
			var editor_id = editor_indx;
			
			tinymce.execCommand("mceRemoveEditor", false, editor_id);
			tinymce.execCommand("mceAddEditor", false, editor_id);
			
			jQuery(this).closest('#dx-custombox-dialog').find('.wp-switch-editor').removeAttr("onclick");
			jQuery(this).closest('#dx-custombox-dialog').find('.switch-tmce').click(function() {
				
				//var content = jQuery('#dx-custombox-dialog').find('.dx_epb_custom_hidden').html();
				
				var content = jQuery('#'+editor_id).val();
				
				jQuery(this).closest('#dx-custombox-dialog').find('.wp-editor-wrap').removeClass('html-active').addClass('tmce-active');
				tinyMCE.execCommand("mceAddEditor", false, editor_id);
				
				jQuery('#'+editor_id+'_ifr').contents().find("#tinymce").empty();
				jQuery('#'+editor_id+'_ifr').contents().find("#tinymce").css('white-space','pre-wrap');
				jQuery('#'+editor_id+'_ifr').contents().find("#tinymce").html(content);
			});
			
			jQuery(this).closest('#dx-custombox-dialog').find('.switch-html').click(function() {
				
				var content = jQuery('#'+editor_id+'_ifr').contents().find("#tinymce").html();
				
				var hiddendiv = jQuery('#dx-custombox-dialog');
				var check	  = hiddendiv.find('.dx_epb_custom_hidden').length;
								
				if(!check) {
		      		hiddendiv.append('<div class="dx_epb_custom_hidden">' + content + '</div>');
				}
		      	else{
		       		hiddendiv.find('.dx_epb_custom_hidden').html(content);
		      	}
				
				jQuery(this).closest('#dx-custombox-dialog').find('.wp-editor-wrap').removeClass('tmce-active').addClass('html-active');
				tinyMCE.execCommand("mceRemoveEditor", false, editor_id);
				
				jQuery('#'+editor_id).val(content);
			});
		});
	}
	// Initialize On load page
	$.fn.init_comp = function(){
		// Clone html while drop.
		
		$(".row-container .dx-droppable").droppable({
	        accept: '.top-wrapper .dx-draggable, .dx-columns',
	        drop: function(event, ui) {
	        	var data_type = $(ui.helper[0]).data('type');
	        	var content = $(ui.helper[0]).html();
	        	
	        	if(data_type!=undefined){
		        	var col_id = 0;
					$('.row-container .dx-columns').each(function(){
					  var check = $(this).attr('data-indx');
					  if(parseInt(check)>parseInt(col_id)) col_id = check;
					});
					
					col_id++;
		        	
		            $(this).append(
									'<div class="dx-columns dx-col-12" data-view="'+data_type+'" data-indx="'+col_id+'">'+
										'<i class="fa fa-arrows-alt dx-move-column js-move-column" title="Move Element"></i>'+
										'<span class="dx-section-name">'+content+'</span>'+
										'<i class="fa fa-arrow-left js-decrease-column-width" title="Decrease Element Width"></i>'+
										'<span class="dx-column-part">12</span>'+
										'<span>/</span>'+
										'<span class="dx-column-full">12</span>'+
										'<i class="fa fa-arrow-right js-increase-column-width" title="Increase Element Width"></i>'+
										'<i class="fa fa-close pull-right dx-remove-column js-remove-column" title="Remove Element"></i>'+
										'<i class="fa fa-cog pull-right dx-setting-column js-setting-column" title="Element Setting"></i>'+
										'<i class="fa fa-copy pull-right js-copy-column" title="Copy Element"></i>'+
										'<i class="fa fa-align-justify pull-right"><span class="small-column-properties"><i class="fa fa-copy js-copy-column" title="Copy Element"></i><i class="fa fa-cog dx-setting-column js-setting-column" title="Element Setting"></i><i class="fa fa-close dx-remove-column js-remove-column" title="Remove Element"></i></span><div id="triangle-down"></div></i>'+
										'<button class="js-edit-col-classes-btn-ok dx-edit-col-classes-btn-ok pull-right">OK</button><i class="js-edit-col-classes-btn dx-edit-col-classes-btn fa fa-pencil pull-right" title="Edit Classes"></i><span class="dx-col-classes pull-right">Column Classes</span>'+
									'</div>'
										);
										
										$(".dx-columns").draggable({
										 	helper: 'clone',
									        cursor: 'move'
									    });
	        	}
	        	else{
	        		$(ui.draggable).appendTo(this);
	        		
	        	}

	        }/*,
	        over: function(event, ui) {
            	var data_types = $(ui.helper[0]).data('type');
	        	if(data_types==undefined){
	        		ui.draggable.remove();
	        	}
        	}*/
	    });
	    
	    
	    
		// Initialize default pagebuilder
		
		var post_id = $('#post_ID').val();
		var data =  {	
						post_id				: post_id,
						action				: 'dx_get_editor_type',
					}
		
		jQuery.post(ajaxurl,data,function(response) {
			if(response=='devrix') {
				$('#wp-content-wrap').removeClass('tmce-active html-active');
				$('#wp-content-wrap').addClass('epb-active');
		
				$('.mce-tinymce, #ed_toolbar, #content').hide();
			} else {
				$('#wp-content-wrap').removeClass('epb-active html-active');
				$('#wp-content-wrap').addClass('tmce-active');
			}
		});
		
		// Initialize Draggable Shortcode element
		$(".shortcode-btn .dx-draggable").draggable({
	        helper: 'clone',
	        cursor: 'move'
	    });

	    $(document).find(".dx-columns").draggable({
		 	helper: 'clone',
	        cursor: 'move'
	    });

		// Initialize Droppable Zone
	    $(".dx-columns-wrapper .dx-droppable").sortable();
	}

	// function for call each element
	$.fn.data_element_access = function(action){ 
		
		 $(this).trigger('extension_hook', action );
		// Filter content to access element
		if(action === 'custom_text'){
			var parentDiv 	= jQuery(this).parents('.dx-columns');
			var indx 		= parentDiv.data('indx');
			var editor_indx = 'editorid' + indx;
			
			var data =  {	
						action				: 'dx_load_editor',
						editor_indx			: editor_indx
					}
	 	 	$.ajax({    //create an ajax request to load_page.php
		        type: "GET",
		        url: ajaxurl,             
		        dataType: "html", 
		        data: data,
		        success: function(response){      
		        	        var contentdata = "";
				            $("#dx-custombox-dialog .editor-wrapper").html(response); 
			           		$(document).dx_epb_init_tiny_mce(editor_indx);    
			           		if(parentDiv.find('.hidden').length){
			           			contentdata = parentDiv.find('.hidden').html();
			           		}
			           		
							tinyMCE.get(editor_indx).setContent(contentdata);	
						}
			});
			
			jQuery('#dx-custombox-dialog-classes').val(parentDiv.data('class'));
			jQuery('#dx-custombox-dialog-padding').val(parentDiv.data('padding'));
			jQuery('#dx-custombox-dialog-padding-type').val(parentDiv.data('padding_type'));
			jQuery('#dx-custombox-dialog-background').val(parentDiv.data('background'));
			jQuery('#dx-custombox-dialog-border').val(parentDiv.data('boder'));
			
			jQuery('#dx-custombox-dialog').dialog({
			  width: 1200,
			  height: 550,
			  close: function(ev, ui) {
			  	
			  	    jQuery(this).dialog('close');
					
					$(document).dx_epb_init_tiny_mce(editor_indx); 
					
					response = tinyMCE.get(editor_indx).getContent();
					
			   },
			  buttons: {
			    'Save': function () {
			    	
					response = jQuery('#'+editor_indx+'_ifr').contents().find("#tinymce").html();
					
					if(response===undefined){
						response = jQuery('#'+editor_indx).val();
					}
					
					$(document).dx_epb_init_tiny_mce(editor_indx);
					
					parentDiv.attr('data-class',jQuery('#dx-custombox-dialog-classes').val());
					parentDiv.attr('data-padding',jQuery('#dx-custombox-dialog-padding').val());
					parentDiv.attr('data-padding_type',jQuery('#dx-custombox-dialog-padding-type option:selected').text());
					parentDiv.attr('data-background',jQuery('#dx-custombox-dialog-background').val());
					parentDiv.attr('data-boder',jQuery('#dx-custombox-dialog-border').val());
					
					var check = parentDiv.find('.hidden').length;
					if (!check){
						parentDiv.append('<div class="hidden">' + response + '</div>');
					}else{
						parentDiv.find('.hidden').html(response);
					}
					
					jQuery(this).dialog('close');
			    },
			    Cancel: function () { 
			    	jQuery(this).dialog('close');
					
					$(document).dx_epb_init_tiny_mce(editor_indx); 
					
					response = tinyMCE.get(editor_indx).getContent();
			    }
			  }
			});
		}

		if(action === 'testimonial'){
			var parentDiv = $(this).parents('.dx-columns');
	
			jQuery('.testimonials-wrapper').html(parentDiv.find('.hidden').html());
			
			//Make Sortable Testimonial Table
			jQuery( '.testimonials-wrapper #sortable-table' ).sortable();
			
			//Select All Testimonial
		    jQuery('.testimonials-wrapper .dx-select-all-testimonial').click(function(event) {  //on click
		        if(this.checked) { // check select status
		            jQuery('.testimonials-wrapper .dx-select-testimonial').each(function() { //loop through each checkbox
		                this.checked = true;  //select all checkboxes with class "dx-select-testimonial"              
		            });
		        }else{
		            jQuery('.testimonials-wrapper .dx-select-testimonial').each(function() { //loop through each checkbox
		                this.checked = false; //deselect all checkboxes with class "dx-select-testimonial"                      
		            });        
		        }
		    });
			
		  	jQuery('#dx-testimonialbox-dialog').dialog({
				width:1200,
				height:550,
				close: function( event, ui ) {
			    	jQuery( this ).dialog( "destroy" );
			 	},
				buttons: {
			        'Save': function() {
								jQuery( this ).dialog( "destroy" );
								
								var testimonial_table = jQuery(this).find('.testimonials-wrapper').html();
								
								var check_dialog = parentDiv.find('.hidden').length;
								
								if(!check_dialog){
									parentDiv.append('<div class="hidden"></div>');
									parentDiv.find('.hidden').html(testimonial_table);
								}
								else{
									parentDiv.find('.hidden').html(testimonial_table);
								}
			    		    }
						}
			});
		}

		if(action === 'contact'){
			
			var parentDiv = $(this).parent('.dx-columns');
			jQuery('.dx-droppable-form').empty();
			jQuery('.dx-droppable-form').html(parentDiv.find('.hidden-dialog').html());
			jQuery('#dx-contactform-dialog').dialog({
				width:1200,
				height:550,
				close: function( event, ui ) {
			    	jQuery( this ).dialog( "destroy" );
			 	},
				buttons: {
			        'Save': function() {
								jQuery( this ).dialog( "destroy" );
								var dialog_form = jQuery(this).find('.dx-droppable-form').html();
								var check_dialog = parentDiv.find('.hidden-dialog').length;
								if(!check_dialog){
									parentDiv.append('<div class="hidden-dialog"></div>');
									parentDiv.find('.hidden-dialog').html(dialog_form);
								}
								else{
									parentDiv.find('.hidden-dialog').html(dialog_form);
								}
								var check = parentDiv.find('.hidden').length;
								if(!check){
									parentDiv.append('<div class="hidden"><form class="epb-public-form"></form></div>');
								}
								else{
									parentDiv.find('.epb-public-form').empty();
								}
								jQuery(this).find('.form-wrapper input, .form-wrapper textarea').clone().appendTo(parentDiv.find('.epb-public-form'));
								parentDiv.find('.epb-public-form').removeClass('dx-contact-form-right-ele').after("<br />");
								parentDiv.find('.epb-public-form *').remove('dx-contact-form-right-ele');
			    		    }
						}
			});
		}

		if(action === 'blog'){
			jQuery('#dx-blog-dialog').dialog({
				  width: 1200,
				  height: 550,
				  close: function( event, ui ) {
					  jQuery( this ).dialog( "destroy" );
				  },
				  buttons: {
				    'Save': function () {
						jQuery(this).dialog('destroy');
				    }
				}
			});
		}
		
		if(action === 'custom_textarea'){
			var parentDiv 	= jQuery(this).parents('.dx-columns');
			if(parentDiv.find('.hidden').length){
				jQuery('#dx-custom-textarea-dialog textarea').val(parentDiv.find('.hidden').html());
			}
			jQuery('#dx-custom-textarea-dialog').dialog({
				  width: 700,
				  height: 400,
				  close: function( event, ui ) {
					  jQuery( this ).dialog( "destroy" );
				  },
				  buttons: {
				    'Save': function () {
				    	
				    	var content = jQuery('#dx-custom-textarea-dialog textarea').val();
				    	
				    	var check = parentDiv.find('.hidden').length;
								
						if(!check) {
				      		parentDiv.append('<div class="hidden">' + content + '</div>');
						}
				      	else{
				       		parentDiv.find('.hidden').html(content);
				      	}
				    	
						jQuery(this).dialog('destroy');
				    }
				}
			});
		}
		
		if(action === 'article'){
			var parentDiv 	= jQuery(this).parents('.dx-columns');
			
			if(parentDiv.find('.hidden').length){
				jQuery('#dx-article-dialog select').val(parentDiv.find('.hidden').html());
			}
			
			jQuery('#dx-article-dialog').dialog({
				  width: 500,
				  height: 200,
				  close: function( event, ui ) {
					  jQuery( this ).dialog( "destroy" );
				  },
				  buttons: {
				    'Save': function () {
				    	var content = $(document).find('select[name="dx_article"] option:selected').val();
				    	var check	= parentDiv.find('.hidden').length;
								
						if(!check) {
				      		parentDiv.append('<div class="hidden">' + content + '</div>');
						}
				      	else{
				       		parentDiv.find('.hidden').html(content);
				      	}
				    	
						jQuery(this).dialog('destroy');
				    }
				}
			});
		}
		
		if(action === 'alert'){
			var parentDiv 	= jQuery(this).parents('.dx-columns');
			
			jQuery('#dx-alert-content').val(parentDiv.find('.hidden').html());
			jQuery('#dx-alert-type').val(parentDiv.attr('data-alert'));
			jQuery('#dx-alert-ids').val(parentDiv.attr('data-alert-ids'));
			
			if(parentDiv.attr('data-alert')=='On Click'){
				
				jQuery('.dx-alert-ids-wrap').show();
			}
			
			jQuery('#dx-alert').dialog({
				  width: 1200,
				  height: 350,
				  close: function( event, ui ) {
					  jQuery( this ).dialog( "destroy" );
				  },
				  buttons: {
				    'Save': function () {
				    	
				    	var content = jQuery('#dx-alert-content').val();
				    	parentDiv.attr('data-alert',jQuery('#dx-alert-type').val());
				    	parentDiv.attr('data-alert-ids',jQuery('#dx-alert-ids').val());
				    	
				    	var check	= parentDiv.find('.hidden').length;
								
						if(!check) {
				      		parentDiv.append('<div class="hidden">' + content + '</div>');
						}
				      	else{
				       		parentDiv.find('.hidden').html(content);
				      	}
				    	
						jQuery(this).dialog('destroy');
				    }
				}
			});
		}
	}
});
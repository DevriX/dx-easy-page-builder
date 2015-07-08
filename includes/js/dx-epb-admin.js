jQuery(document).ready(function($) {
	//tinyMCE.triggerSave();
	
	$('.wp-editor-tabs').prepend('<button type="button" id="content-depb" class="js-switch-depb wp-switch-editor switch-depb" onclick="switchEditors.switchto(this);">DevriX Page Builder</button>')
	$epb_editor = $('.dx-epb-content-editor').html();
	$('.dx-epb-content-editor').remove();
	$('#wp-content-editor-container').append("<div class='wp-page-builder-editor'>"+ $epb_editor + "</div>");
	$(document).init_comp();
	
	$('.wp-switch-editor').click( function(event) {
		
		var edir = $(this);
		
		if($(this).hasClass('switch-depb')){
			
			if($(document).find('#dx-devrix-hidden').length){} else{
				
				jQuery('#dx-confirm-devrix-dialog').dialog({
					width:350,
					height:170,
					close: function( event, ui ) {
				    	jQuery( this ).dialog( "destroy" );
				 	},
					buttons: {
						'Ok': function () {
							jQuery(this).dialog('close');
							
							
							$('#wp-content-wrap').removeClass('html-active tmce-active');
							$('.mce-tinymce, #ed_toolbar, #content').hide();
							$('#wp-content-wrap').addClass('epb-active');
							$('.wp-page-builder-editor').show();
							//$('#content-depb').show();
							
							
							$('.wp-editor-container').append('<input type="hidden" name="dx-save-hidden" id="dx-devrix-hidden" value="devrix">');
							$('.wp-editor-container #dx-other-hidden').remove();
							
							var post_id = $('#post_ID').val();
					
							var data =  {	
									post_id				: post_id,
									editor				: 'devrix',
									action				: 'dx_save_editor_type',
								}
							jQuery.post(ajaxurl,data);
							
							return false;
						},
						'Cancel': function () {
							jQuery(this).dialog('close');
						},
					}
				});
			}
			
		}else {
			
			if($('#wp-content-wrap').hasClass('epb-active')){
				$('.mce-tinymce, #content').hide();
			}
			
			if($(document).find('#dx-other-hidden').length){} else{
				
				if($('.mce-tinymce').is(':hidden') && $('#content').is(':hidden')){
					
					jQuery('#dx-confirm-other-dialog').dialog({
						width:360,
						height:170,
						close: function( event, ui ) {
					    	jQuery( this ).dialog( "destroy" );
					 	},
						buttons: {
							'Ok': function () {
								jQuery(this).dialog('close');
								
								$('#wp-content-wrap').removeClass('epb-active');
								$('.wp-page-builder-editor').hide();
								$('#ed_toolbar').show();
								
								if(edir.hasClass('switch-tmce')){
									$('#wp-content-wrap').addClass('tmce-active');
									$('.mce-tinymce').show();
								}
								if(edir.hasClass('switch-html')){
									$('#wp-content-wrap').addClass('html-active');
									
									$('#content').show();
								}
								
								$('.wp-editor-container').append('<input type="hidden" name="dx-save-hidden" id="dx-other-hidden" value="other">');
								$('.wp-editor-container #dx-devrix-hidden').remove();
								
								var post_id = $('#post_ID').val();
								
								var datas =  {	
										post_id				: post_id,
										editor				: 'other',
										action				: 'dx_save_editor_type',
									}
								jQuery.post(ajaxurl,datas);
								
								return false;
							},
							'Cancel': function () {
								jQuery(this).dialog('close');
							},
						}
					});
				}
			}
		}
	});
	
	//Add Element js
	$('.section-blue').click(function(event) {
		$('.top-wrapper').addClass('active');
	});
	$('.section-close').click(function(event) {
		$('.top-wrapper').removeClass('active');
	});
	
	$('.section-blue-dialog').click(function(event) {
		$(this).parents('.top-wrapper-dialog').addClass('active');
	});
	$('.section-close-dialog').click(function(event) {
		$(this).parents('.top-wrapper-dialog').removeClass('active');
	});
	
	// Add new section row in page builder
	$('.section-btn').click(function(event) {
		
		var row_id = 0;
		$('.section-container').each(function(){
		  var checked = $(this).data('section');
		  if(parseInt(checked) > parseInt(row_id)) row_id = checked;
		});
		row_id++;
		
		$('.row-container').append('<div class="section-container" data-section="'+row_id+'"><div class="dx-control-wrapper"><i class="fa fa-arrows-alt dx-move-section js-move-section" title="Move Section"></i><span class="dx-column-name">Section Name</span><i class="js-edit-section-btn dx-edit-section-btn fa fa-pencil" title="Rename Section"></i><button class="js-edit-section-btn-ok dx-edit-section-btn-ok">OK</button><i class="js-delete-section-btn fa fa-close dx-row-close pull-right" title="Delete Section"></i><span class="js-toggle-section dx-section-settings pull-right">Toggle</span><button class="js-edit-classes-btn-ok dx-edit-classes-btn-ok pull-right">OK</button><i class="js-edit-classes-btn dx-edit-classes-btn fa fa-pencil pull-right" title="Edit Classes"></i><span class="dx-section-classes pull-right">Section Classes</span><select class="dx-select-section-class pull-right"><option value="">Select Class</option></select></div><div class="dx-columns-wrapper"><div class="dx-droppable"></div></div></div>');
		
		var data =  {	
						action				: 'dx_get_section_classes_ajax',
					}
		jQuery.post(ajaxurl,data,function(response) {
			
			$(document).find('div[data-section="'+row_id+'"] select').append(response);
		});
		
		$(".row-container .dx-droppable").droppable({
	        accept: '.top-wrapper .dx-draggable, .dx-columns',
	        drop: function(event, ui) {
	        	var data_type = $(ui.helper[0]).data('type');
	        	var content = $(ui.helper[0]).html();
	        	
	        	if(data_type!=undefined){
		        	var testimonial_length = $('div[data-view="testimonial"]').length;
		        	
		        	var col_id = 0;
					$('.row-container .dx-columns').each(function(){
					  var check = $(this).attr('data-indx');
					  if(parseInt(check)>parseInt(col_id)) col_id = check;
					});
					
					col_id++;
					
		        	if(data_type!='testimonial' || testimonial_length==0) {
		        		
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
		        	}
		        	else {
		        		
		        		var hidden_testimonial = $('div[data-view="testimonial"] .hidden').html();
		        		
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
										'<div class="hidden">'+hidden_testimonial+'</div>'+
									'</div>'
										);
		        	}
		        	
		        	$(".dx-columns").draggable({
					 	helper: 'clone',
				        cursor: 'move'
				    });
	        	}
	        	else
	        	{
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
	    
	    $(".shortcode-btn .dx-draggable").draggable({
	        helper: 'clone',
	        cursor: 'move'
	    });
	    
	    $(document).find(".dx-columns").draggable({
		 	helper: 'clone',
	        cursor: 'move'
	    });
	    
	    $(".dx-columns-wrapper .dx-droppable").sortable();

	});
	
	
	// Add new section row in page builder dialog
	$('.section-dialog-btn').click(function(event) {
		
		var row_id = 0;
		$('.section-container').each(function(){
		  var checked = $(this).data('section');
		  if(parseInt(checked)>parseInt(row_id)) row_id = checked;
		});
		row_id++;
		
		$(this).parents('#dx-epb-dialog').find('.row-container-dialog').append('<div class="section-container" data-section="'+row_id+'"><div class="dx-control-wrapper"><i class="fa fa-arrows-alt dx-move-section js-move-section" title="Move Section"></i><span class="dx-column-name">Section Name</span><i class="js-edit-section-btn dx-edit-section-btn fa fa-pencil" title="Rename Section"></i><button class="js-edit-section-btn-ok dx-edit-section-btn-ok">OK</button><i class="js-delete-section-btn fa fa-close dx-row-close pull-right" title="Delete Section"></i><span class="js-toggle-section dx-section-settings pull-right">Toggle</span><button class="js-edit-classes-btn-ok dx-edit-classes-btn-ok pull-right">OK</button><i class="js-edit-classes-btn dx-edit-classes-btn fa fa-pencil pull-right" title="Edit Classes"></i><span class="dx-section-classes pull-right">Section Classes</span><select class="dx-select-section-class pull-right"><option>Select Class</option></select></div><div class="dx-columns-wrapper"><div class="dx-droppable"></div></div></div>');
		
		var data =  {	
						action				: 'dx_get_section_classes_ajax',
					}
		jQuery.post(ajaxurl,data,function(response) {
			
			$(document).find('div[data-section="'+row_id+'"] select').append(response);
		});
		
		$(".row-container-dialog .dx-droppable").droppable({
	        accept: '.top-wrapper-dialog .dx-draggable, .dx-columns',
	        drop: function(event, ui) {
	        	var data_type = $(ui.helper[0]).data('type');
	        	var content = $(ui.helper[0]).html();
	        	
	        	if(data_type!=undefined){
		        	var testimonial_length = $('div[data-view="testimonial"]').length;
					
					var col_id = 0;
					$('.row-container-dialog .dx-columns:last').each(function(){
					  var check = $(this).attr('data-indx');
					  if(parseInt(check)>parseInt(col_id)) col_id = check;
					});
					
					col_id++;
					
		        	if(data_type!='testimonial' || testimonial_length==0) {
		        		
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
		        	}
		        	else {
		        		
		        		var hidden_testimonial = $('div[data-view="testimonial"] .hidden').html();
		        		
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
										'<div class="hidden">'+hidden_testimonial+'</div>'+
									'</div>'
										);
		        	}
	        	}
	        	else
	        	{
	        		$(ui.draggable).appendTo(this);
	        	}
	        }
	    });
	    
	    $(".shortcode-btn .dx-draggable").draggable({
	        helper: 'clone',
	        cursor: 'move'
	    });
	    
	    $(".dx-columns").draggable({
		 	helper: 'clone',
	        cursor: 'move'
	    });

	    $(".dx-columns-wrapper .dx-droppable").sortable();

	});

	// Sortable row
	$('.page-template-area .row-container, .page-template-area .row-container-dialog').sortable({
		handle: ".dx-move-section",
		cancel: ".dx-row-close"
    });
	
	//Column Sortable 
	$(".dx-columns-wrapper .dx-droppable").sortable();

    $(document).on('click','.dx-edit-section-btn',function(){
    	$(this).edit_rowname({action : 'edit', input:'section'});
    });
    $(document).on('click','.dx-edit-section-btn-ok',function(event){
    	event.preventDefault();
	    $(this).edit_rowname({action : 'setval', input:'section'});
	});
	
	$(document).on('click','.dx-edit-classes-btn',function(){
    	$(this).edit_rowname({action : 'edit', input:'class'});
    });
    $(document).on('click','.dx-edit-classes-btn-ok',function(event){
    	event.preventDefault();
	    $(this).edit_rowname({action : 'setval', input:'class'});
	});
	
	$(document).on('click','.dx-edit-col-classes-btn',function(){
    	$(this).edit_rowname({action : 'edit', input:'col-class'});
    });
    $(document).on('click','.dx-edit-col-classes-btn-ok',function(event){
    	event.preventDefault();
	    $(this).edit_rowname({action : 'setval', input:'col-class'});
	});

	// Add column in builder
	$(document).on('click', '.dx-section-settings', function(event) {
		var parent = $(this).parents('.section-container');
		parent.find('.dx-columns-wrapper').slideToggle();
	});
	
	 //Decrease width of element
	 $(document).on('click','.fa-arrow-left',function(event){
	 	$(this).changecolumnwidth({action:"decrease"})
	 });
	  //Increase width of element
	 $(document).on('click','.fa-arrow-right',function(event){
	 	$(this).changecolumnwidth({action:"increase"})
	 });
	 $(".shortcode-btn .dx-draggable").draggable({
	        helper: 'clone',
	        cursor: 'move'
	 });
	 
	//Dialog option toggles
	$(document).on('click', '#dx-custombox-dialog .option-wrapper-attributes', function(event) {
		$('#dx-custombox-dialog .option-attributes').slideToggle();
	});
	
	$(document).on('click', '#dx-custombox-dialog .option-wrapper-layout', function(event) {
		$('#dx-custombox-dialog .option-layout').slideToggle();
	});
	
	$(document).on('click', '#dx-custombox-dialog .option-wrapper-design', function(event) {
		$('#dx-custombox-dialog .option-design').slideToggle();
	});
	
	$(document).on('click', '#dx-testimonialbox-dialog h4', function(event) {
		$('#dx-testimonialbox-dialog .option-wrapper-inner').slideToggle();
	});
	
	$(document).on('click', '#dx-contactform-dialog .option-wrapper-elements', function(event) {
		$('#dx-contactform-dialog .option-elements').slideToggle();
	});
	
	$(document).on('click', '#dx-contactform-dialog .option-wrapper-css', function(event) {
		$('#dx-contactform-dialog .option-css').slideToggle();
	});
	
	$(document).on('click', '#dx-alert h4', function(event) {
		$('#dx-alert .option-wrapper-inner').slideToggle();
	});
	
	//Dialog option color picker
	$('.dx-custombox-dialog-color').wpColorPicker();
	
	//Select All Testimonial
	$(document).on('click', '.dx-select-all-testimonial', function(event) {
        if(this.checked) { // check select status
        	
        	$(this).attr("checked", "checked");
        	
            $('.dx-select-testimonial').each(function() { //loop through each checkbox
                this.checked = true;
                $(this).attr("checked", "checked");              
            });
        }else{
        	
        	$(this).removeAttr("checked");
        	
            $('.dx-select-testimonial').each(function() { //loop through each checkbox
                this.checked = false;
                $(this).removeAttr("checked");
            });        
        }
    });
    
    $(document).on('click', '.dx-select-testimonial', function(event) {
    	
    	if(this.checked){
    		$(this).attr("checked", "checked");
    	}
    	else {
    		$(this).removeAttr("checked");
    	}
    });
    
    //Add Testimonial
	$(document).on('click', '#dx-add-testimonial', function(event) {
		
		var author_image 		= $('.dx-testimonial-add-author-image').val();
		var author_name 		= $('.dx-testimonial-add-author-name').val();
		var about_author 		= $('.dx-testimonial-add-about-author').val();
		var testimonial_content = $('.dx-testimonial-add-testimonial-content').val();
		
		if(!author_image) {
			$('.dx-testimonial-empty-image').show();
		}
		else {
			$('.dx-testimonial-empty-image').hide();
		}
		if(!author_name) {
			$('.dx-testimonial-empty-name').show();
		}
		else {
			$('.dx-testimonial-empty-name').hide();
		}
		if(!about_author) {
			$('.dx-testimonial-empty-about').show();
		}
		else {
			$('.dx-testimonial-empty-about').hide();
		}
		if(!testimonial_content) {
			$('.dx-testimonial-empty-content').show();
		}
		else {
			$('.dx-testimonial-empty-content').hide();
		}
		
		if( author_image && author_name && about_author && testimonial_content ) {
			$('.dx-testimonial-table tbody').append(
													'<tr>'+
														'<td class="dx-testimonial-author-image"><img src="'+author_image+'"></td>'+
														'<td class="dx-testimonial-author-name">'+author_name+'</td>'+
														'<td class="dx-testimonial-about-author">'+about_author+'</td>'+
														'<td class="dx-testimonial-content">'+testimonial_content+'</td>'+
														'<td>'+
															'<input type="checkbox" class="dx-select-testimonial">'+
														'</td>'+
														'<td class="js-edit-testimonial-td dx-edit-testimonial-td"><a class="dx-edit-testimonial">Edit</a></td>'+
														'<td class="js-delete-testimonial-td dx-delete-testimonial-td"><a class="dx-delete-testimonial">Delete</a></td>'+
													'</tr>');
													
			$('.dx-testimonial-add-author-image').val('');
			$('.dx-testimonial-add-author-name').val('');
			$('.dx-testimonial-add-about-author').val('');
			$('.dx-testimonial-add-testimonial-content').val('');
		}
	});
    
    //Edit Testimonial
    $(document).on('click', '.dx-edit-testimonial', function(event) {
    	
    	var parents = $(this).parent().parent();
    	
    	var author_image 		= parents.find('.dx-testimonial-author-image img').attr('src');
		var author_name 		= parents.find('.dx-testimonial-author-name').html();
		var about_author 		= parents.find('.dx-testimonial-about-author').html();
		var testimonial_content = parents.find('.dx-testimonial-content').html();
    	
		parents.find('.dx-testimonial-author-image').html('<input type="text" value="'+author_image+'" placeholder="Author Image" /><input type="hidden" value="'+author_image+'" />');
		parents.find('.dx-testimonial-author-name').html('<input type="text" value="'+author_name+'" placeholder="Author Name" /><input type="hidden" value="'+author_name+'" />');
		parents.find('.dx-testimonial-about-author').html('<input type="text" value="'+about_author+'" placeholder="About Author" /><input type="hidden" value="'+about_author+'" />');
		parents.find('.dx-testimonial-content').html('<textarea placeholder="Testimonial Content">'+testimonial_content+'</textarea><textarea class="dx-testimonial-content-hidden">'+testimonial_content+'</textarea>');
		parents.find('.dx-edit-testimonial-td').html('<a class="js-save-testimonial dx-save-testimonial">Save</a>');
		parents.find('.dx-delete-testimonial-td').html('<a class="js-cancel-testimonial dx-cancel-testimonial">Cancel</a>');
	});
	
	//Delete Testimonial
    $(document).on('click', '.dx-delete-testimonial', function(event) {
    	var check = confirm('Sure to delete this testimonial?');
    	
    	if(check == true) {
    		$(this).parent().parent().remove();
    	}
    });
	
	//Save Testimonial
    $(document).on('click', '.dx-save-testimonial', function(event) {
    	
    	var parents = $(this).parent().parent();
    	
    	var author_image 		= parents.find('.dx-testimonial-author-image input').val();
		var author_name 		= parents.find('.dx-testimonial-author-name input').val();
		var about_author 		= parents.find('.dx-testimonial-about-author input').val();
		var testimonial_content = parents.find('.dx-testimonial-content textarea').val();
		
		
		if(!author_image) {
			parents.find('.dx-testimonial-author-image input').addClass('dx-form-error');
		}
		else {
			parents.find('.dx-testimonial-author-image input').removeClass('dx-form-error');
		}
		if(!author_name) {
			parents.find('.dx-testimonial-author-name input').addClass('dx-form-error');
		}
		else {
			parents.find('.dx-testimonial-author-name input').removeClass('dx-form-error');
		}
		if(!about_author) {
			parents.find('.dx-testimonial-about-author input').addClass('dx-form-error');
		}
		else {
			parents.find('.dx-testimonial-about-author input').removeClass('dx-form-error');
		}
		if(!testimonial_content) {
			parents.find('.dx-testimonial-content textarea').addClass('dx-form-error');
		}
		else {
			parents.find('.dx-testimonial-content textarea').removeClass('dx-form-error');
		}
    	
		if( author_image && author_name && about_author && testimonial_content ) {
			parents.find('.dx-testimonial-author-image').html('<img src="'+author_image+'">');
			parents.find('.dx-testimonial-author-name').html(author_name);
			parents.find('.dx-testimonial-about-author').html(about_author);
			parents.find('.dx-testimonial-content').html(testimonial_content);
			parents.find('.dx-edit-testimonial-td').html('<a class="dx-edit-testimonial">Edit</a>');
			parents.find('.dx-delete-testimonial-td').html('<a class="dx-delete-testimonial">Delete</a>');
		}
	});
		
	//Cancel Testimonial
	$(document).on('click', '.dx-cancel-testimonial', function(event) {
		
		var parents = $(this).parent().parent();
		
		var author_image 		= parents.find('.dx-testimonial-author-image input[type=hidden]').val();
		var author_name 		= parents.find('.dx-testimonial-author-name input[type=hidden]').val();
		var about_author 		= parents.find('.dx-testimonial-about-author input[type=hidden]').val();
		var testimonial_content = parents.find('.dx-testimonial-content .dx-testimonial-content-hidden').val();
		
		parents.find('.dx-testimonial-author-image').html('<img src="'+author_image+'">');
		parents.find('.dx-testimonial-author-name').html(author_name);
		parents.find('.dx-testimonial-about-author').html(about_author);
		parents.find('.dx-testimonial-content').html(testimonial_content);
		parents.find('.dx-edit-testimonial-td').html('<a class="dx-edit-testimonial">Edit</a>');
		parents.find('.dx-delete-testimonial-td').html('<a class="dx-delete-testimonial">Delete</a>');
	});
	
	//Make Sortable Testimonial Table
	$( "#sortable-table" ).sortable();
	
	//contact form
	$(".dx-draggable-input, .dx-draggable-textarea").draggable({
        helper: 'clone',
        cursor: 'move'
    });
    
    //contact form droppable portion
    $(".dx-droppable-form").droppable({
        accept: '.dx-draggable-input, .dx-draggable-textarea',
        drop: function(event, ui) {

            var data_type 	= $(ui.helper[0]).data('type');
			
	        if(data_type=='textarea') {
	        	
	        	$(this).append(
								'<div>'+
									'<i class="fa fa-arrows-v dx-move-section js-move-section"></i><textarea class="dx-contact-form-right-ele" /></textarea>'+
									'<i class="fa fa-close pull-right dx-remove-element js-remove-element dx-element-textarea"></i>'+
									'<i class="fa fa-cog pull-right dx-element-setting js-element-setting dx-element-textarea"></i>'+
								'</div>'
									);
	        }
	        else {
	        	
	        	$(this).append(
								'<div data-view="'+data_type+'">'+
									'<i class="fa fa-arrows-v dx-move-section js-move-section"></i><input type="'+data_type+'" class="dx-contact-form-right-ele" />'+
									'<i class="fa fa-close pull-right dx-remove-element js-remove-element"></i>'+
									'<i class="fa fa-cog pull-right dx-element-setting js-element-setting"></i>'+
								'</div>'
									);
	        }
        }
    });
    
    //contact form remove element
    $(document).on('click', '.dx-remove-element', function(event) {
	 	event.preventDefault();
	 	var columns = $(this).parent('div');
	 	columns.remove();
	 });
	 
	 //contact form sortable
	 $(".dx-droppable-form").sortable();
	 
	 //Copy Element
	 $(document).on('click', '.row-container .fa-copy', function(event) {
	 	var columns = $(this).parent('div');
	 	
	 	var col_id = 0;
		$('.row-container .dx-columns').each(function(){
		  var check = $(this).attr('data-indx');
		  if(parseInt(check)>parseInt(col_id)) col_id = check;
		});
		
		col_id++;
	 	
	 	columns.clone().insertAfter(columns);
	 	
	 	columns.next().attr('data-indx',col_id);
	 	
	 	$(".dx-columns").draggable({
		 	helper: 'clone',
	        cursor: 'move'
	    });
	 });
	 
	 $(document).on('click', '.row-container i span .fa-copy', function(event) {
	 	var columns = $(this).parent().parent().parent();
	 	
	 	var col_id = 0;
		$('.row-container .dx-columns').each(function(){
		  var check = $(this).attr('data-indx');
		  if(parseInt(check)>parseInt(col_id)) col_id = check;
		});
		
		col_id++;
	 	
	 	columns.clone().insertAfter(columns);
	 	
	 	columns.next().attr('data-indx',col_id);
	 	
	 	$(".dx-columns").draggable({
		 	helper: 'clone',
	        cursor: 'move'
	    });
	 });
	 
	 $(document).on('click', '.row-container-dialog .fa-copy', function(event) {
	 	var columns = $(this).parent('div');
	 	
	 	var col_id = 0;
		$('.row-container-dialog .dx-columns').each(function(){
		  var check = $(this).attr('data-indx');
		  if(parseInt(check)>parseInt(col_id)) col_id = check;
		});
		
		col_id++;
	 	
	 	columns.clone().insertAfter(columns);
	 	
	 	columns.next().attr('data-indx',col_id);
	 	
	 	$(".dx-columns").draggable({
		 	helper: 'clone',
	        cursor: 'move'
	    });
	 });
	 
	 $(document).on('click', '.row-container-dialog i span .fa-copy', function(event) {
	 	var columns = $(this).parent().parent().parent();
	 	
	 	var col_id = 0;
		$('.row-container-dialog .dx-columns').each(function(){
		  var check = $(this).attr('data-indx');
		  if(parseInt(check)>parseInt(col_id)) col_id = check;
		});
		
		col_id++;
	 	
	 	columns.clone().insertAfter(columns);
	 	
	 	columns.next().attr('data-indx',col_id);
	 	
	 	$(".dx-columns").draggable({
		 	helper: 'clone',
	        cursor: 'move'
	    });
	 });
	 
	 //Delete Section
    $(document).on('click', '.dx-row-close', function(event) {
    	var check = confirm('Are you sure to delete this Section?');
    	
    	if(check == true) {
    		
    		$(this).parents('.section-container').find('div[data-view="custom_text"]').each(function() {
    			var post_id   = $('#post_ID').val();
    			var editor_id = 'editorid'+$(this).data('indx');
    			
    			var data =  {	
							post_id				: post_id,
							editor_id			: editor_id,
							action				: 'dx_delete_custom_text_meta',
						}
		
				jQuery.post(ajaxurl,data);
    		});
    		
    		$(this).parents('.section-container').remove();
    	}
    });
    
     //Delete Column
    $(document).on('click', '.dx-remove-column', function(event) {
    	var check = confirm('Are you sure to delete this Column?');
    	
    	if(check == true) {
    		
    		var parent = $(this).parent('.dx-columns');
    		
    		if(parent.data('view')=='custom_text'){
    			
    			var post_id   = $('#post_ID').val();
    			var editor_id = 'editorid'+parent.data('indx');
    			
    			var data =  {	
							post_id				: post_id,
							editor_id			: editor_id,
							action				: 'dx_delete_custom_text_meta',
						}
		
				jQuery.post(ajaxurl,data);
    		}
    		$(this).parents('.dx-columns').remove();
    	}
    });
    
    //Delete Column
    $(document).on('change', '#dx-alert-type', function(event) {
    	if($(this).val()=='On Click'){
    		$('.dx-alert-ids-wrap').show();
    	}else {
    		$('.dx-alert-ids-wrap').hide();
    	}
    });
});

/* Validate Margin in number */
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && charCode!=46 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
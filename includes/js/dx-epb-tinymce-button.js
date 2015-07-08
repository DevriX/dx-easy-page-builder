// JavaScript Document
jQuery(document).ready(function($) {
	if($('.dx-epb-epbmenu') != undefined ) {
	//Single Shortcode Start
	(function() {
	    tinymce.create('tinymce.plugins.dxeasypbicon', {
	        init : function(ed, url) { 
	            ed.addButton('dxeasypbicon', {
	                title : 'Dx Easy Page Builder',  
	                image : url+'/images/page-builder-icon.png',
	                onclick : function() {
	                  	
	                	var editor_id = jQuery('#dx-custombox-dialog textarea').attr('id');
	                	
	                	if(editor_id==null){
	                		editor_id='tinymce';
	                	}
	                	
	                	var post_id = jQuery('#post_ID').val();
	                	
	                	var editor_data =  {	
												action				: 'dx_single_template_dialog',
												editor_id			: editor_id,
												post_id				: post_id
											}
											
						jQuery.post(ajaxurl,editor_data,function(response) {
							jQuery('.row-container-dialog').html(response);
							
							
							$(".row-container-dialog .dx-droppable").droppable({
						        accept: '.top-wrapper-dialog .dx-draggable .dx-columns',
						        drop: function(event, ui) {
						        	var data_type = $(ui.helper[0]).data('type');
						        	var content = $(ui.helper[0]).html();
						        	
						        	if(data_type!=undefined){
							        	
							        	var testimonial_length = $('div[data-view="testimonial"]').length;
							        	
							        	var col_id = 0;
										$('.row-container-dialog .dx-columns').each(function(){
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
						});
	                	
	                	jQuery('#dx-epb-dialog').dialog({
							width:1200,
							height:550,
							buttons: {
						        'Save': function() {
											jQuery( this ).dialog( "close" );
											
											var section_array = new Array();
											var post_id = $('#post_ID').val();
											extension_data =  {
										  			id			: $(document).find('select[name="dx_service_post"] option:selected').val(),
										  			class_name	: $(document).find('#dx_service_class').val()
										  	};
											$('.dx-epb-dialog-editor .section-container').each(function(){
												var column_array = new Array();
												$(this).find('.dx-columns').each(function(){ 
													column_item = {
																	"column_name" 	 : $(this).find('.dx-section-name').html(),
																	"column_size" 	 : $(this).find('.dx-column-part').html(),
																	"col_class" 	 : $(this).find('.dx-col-classes').html(),
																	"column_view" 	 : $(this).data('view'),
																	"column_indx" 	 : $(this).data('indx'),
																	"column_alert" 	 : $(this).attr('data-alert'),
																	"column_alert_ids" : $(this).attr('data-alert-ids'),
																	"column_data" 	 : $(this).find('.hidden').html(),
																	"dialog_data" 	 : $(this).find('.hidden-dialog').html(),
																	"extension_data" : extension_data
																};	
													column_array.push(column_item);
												});
									
												section_item = {
																	"section_order"   : $(this).data('section'),
																	"section_name"	  : $(this).find('.dx-column-name').html(),
																	"section_classes" : $(this).find('.dx-section-classes').html(),
																	"section_select_class"  : $(this).find('.dx-select-section-class').val(),
																	"column_array"	  : column_array
																};
												section_array.push(section_item);
											});
											
											var data =  {	
												action				: 'dx_single_template_save_dialog',
												template_data 		: JSON.stringify(section_array),
												post_id				: post_id,
												editor_id			: editor_id
											}
											
											jQuery.post(ajaxurl,data,function(response) {
												
												var json_response = JSON.parse(response);
												
												ed.insertContent(json_response.data);
												
												var str = jQuery('#'+editor_id+'_ifr').contents().find("#tinymce").html();
												if(str!=null){
													var res = str.replace(json_response.old_data,'');
													jQuery('#'+editor_id+'_ifr').contents().find("#tinymce").html(res);
												}
												else {
													str = jQuery('#content_ifr').contents().find("#tinymce").html();
													var res = str.replace(json_response.old_data,'');
													jQuery('#content_ifr').contents().find("#tinymce").html(res);
												}
												
												//tinyMCE.get(editor_id).setContent(res);
												
												//var ed = tinyMCE.get(editor_id);     // get editor instance
												//var range = ed.selection.getRng().startOffset;     // get range

												//alert(range);
												
												//jQuery('#'+editor_id+'_ifr').contents().find("#tinymce").append(res);
											});
						    		    }
						    		    
									}
						});
	 				}
	            });
	        },
	        createControl : function(n, cm) {
	            return null;
	        },
	    });
	 
	    tinymce.PluginManager.add('dxeasypbicon', tinymce.plugins.dxeasypbicon);
	})();
	//Single Shortcode End
	}
});
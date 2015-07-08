<?php 

/**
* Template for page builder
*
* Handles generic Admin functionality and AJAX requests.
*
* @package DX Easy Page Builder
* @since 1.0.0
*/

global $post, $dx_epb_admin;
$element_array = $dx_epb_admin->dx_element_array();

?>
	<div class="dx-epb-content-editor">
		<div class="top-wrapper">
			<div class="dx-epb-epbmenu">
				<button type="button" class="js-section-btn section-btn btn"><i class="fa fa-bars"></i>Add New Section</button>
				<button type="button" class="btn section-blue js-section-blue"><i class="fa fa-plus"></i>Add Element</button>
				<button type="button" class="btn fa fa-times section-close js-section-close" title="Close"></button>
				<button type="button" class="btn pull-right section-support js-section-support"><i class="fa fa-life-ring"></i>Support</button>
				<button type="button" class="btn pull-right section-document js-section-document"><i class="fa fa-asterisk"></i>Documentation</button>
			</div>
			<hr>
			
			<div class="shortcode-btn">
				<?php
					$dx_epb_options = get_option( 'dx_epb_options' );
					$final_array 	= $dx_epb_admin->dx_final_element_array( $element_array );
					
					foreach( $element_array as $element_key => $element_value ){
						if( ( ! empty( $dx_epb_options ) && in_array( $element_key, $dx_epb_options ) ) 
								|| ! in_array( $element_value, $final_array ) ) {
							if( $element_key != 'custom_textarea' ) {
				?>
								<div class="js-draggable dx-draggable" data-type="<?php echo $element_key; ?>"><?php echo $element_value; ?></div>
				<?php } } } ?>	
			</div>
			
			<div class="shortcode-txt">
				To add other elements, go to the <a href="<?php echo admin_url( "options-general.php?page=dx-easy-page-builder&tab=pagebuilder_component" ); ?>">Settings Page</a>.
			</div>
			
		</div>
		<div class="page-template-area">
			<div class="row-container">
				<?php 
				
				$postdata = get_post_meta( $post->ID, '_dx_epb_pagebuilder', true ); 
				
				if( ! empty( $postdata ) ) {
				foreach( $postdata as $dx_section ) {
					?>
					<div class="section-container" data-section="<?php echo $dx_section->section_order; ?>">
						<div class="dx-control-wrapper">
							<i class="fa fa-arrows-alt dx-move-section js-move-section" title="Move Section"></i>
							<span class="dx-column-name"><?php echo $dx_section->section_name; ?></span>
							<i class="js-edit-section-btn dx-edit-section-btn fa fa-pencil" title="Rename Section"></i>
							<button class="js-edit-section-btn-ok dx-edit-section-btn-ok">OK</button>
							<i class="js-delete-section-btn fa fa-close dx-row-close pull-right" title="Delete Section"></i>
							<span class="js-toggle-section dx-section-settings pull-right">Toggle</span>
							<button class="js-edit-classes-btn-ok dx-edit-classes-btn-ok pull-right">OK</button>
							<i class="js-edit-classes-btn dx-edit-classes-btn fa fa-pencil pull-right" title="Edit Classes"></i>
							<span class="dx-section-classes pull-right"><?php echo isset($dx_section->section_classes)?$dx_section->section_classes:""; ?></span>
							<select class="dx-select-section-class pull-right">
								<option value="">Select Class</option>
							<?php
								$selected_class = isset( $dx_section->section_select_class ) ? $dx_section->section_select_class : "";
							
								$section_classes_array = $dx_epb_admin->get_section_classes();
								if( ! empty( $section_classes_array ) ) {
									foreach ( $section_classes_array as $class ) {
										if( $class == $selected_class ) {
											echo '<option value="'.$class.'" selected="selected">'.$class.'</option>';
										}
										else{
											echo '<option value="'.$class.'">'.$class.'</option>';
										}
									}
								}
							?>
							</select>
						</div>
						<div class="dx-columns-wrapper">
							<div class="dx-droppable">
								<!-- Dx Columns -->
								<?php foreach ( $dx_section->column_array as $key => $value ) { ?>
								
								<?php
								if( $value->column_view == 'custom_text' ) {
								
									$column_class 		 = isset( $value->column_class ) ? $value->column_class : '';
									$column_padding 	 = isset( $value->column_padding ) ? $value->column_padding : '';
									$column_padding_type = isset( $value->column_padding_type ) ? $value->column_padding_type : '';
									$column_background 	 = isset( $value->column_background ) ? $value->column_background : '';
									$column_boder 		 = isset( $value->column_boder ) ? $value->column_boder : '';
									
									echo '<div class="dx-columns dx-col-' . $value->column_size . '" data-view="' . $value->column_view . '" data-indx="' . $value->column_indx . '" data-class="' . $column_class . '" data-padding="' . $column_padding . '" data-padding_type="' . $column_padding_type . '" data-background="' . $column_background . '" data-boder="' . $column_boder . '">';
								
								} else if( $value->column_view == 'alert' ) {
									$column_alert_ids = isset( $value->column_alert_ids ) ? $value->column_alert_ids : '';
								?>
									<div class="dx-columns dx-col-<?php echo $value->column_size; ?>" data-view="<?php echo $value->column_view; ?>" data-indx="<?php echo $value->column_indx; ?>" data-alert="<?php echo $value->column_alert; ?>" data-alert-ids="<?php echo $column_alert_ids; ?>">
								<?php
								} else {
								?>
									<div class="dx-columns dx-col-<?php echo $value->column_size; ?>" data-view="<?php echo $value->column_view; ?>" data-indx="<?php echo $value->column_indx; ?>">
								<?php
								}
								?>
									<i class="fa fa-arrows-alt dx-move-column js-move-column" title="Move Element"></i>
									<span class="dx-section-name"><?php echo $value->column_name; ?></span>
									<i class="fa fa-arrow-left js-decrease-column-width" title="Decrease Element Width"></i>
									<span class="dx-column-part"><?php echo $value->column_size; ?></span>
									<span>/</span><span class="dx-column-full">12</span>
									<i class="fa fa-arrow-right js-increase-column-width" title="Increase Element Width"></i>
									<i class="fa fa-close pull-right dx-remove-column js-remove-column" title="Remove Element"></i>
									<i class="fa fa-cog pull-right dx-setting-column js-setting-column" title="Element Setting"></i>
									<i class="fa fa-copy pull-right js-copy-column" title="Copy Element"></i>
									<i class="fa fa-align-justify pull-right"><span class="small-column-properties"><i class="fa fa-copy js-copy-column" title="Copy Element"></i><i class="fa fa-cog dx-setting-column js-setting-column" title="Element Setting"></i><i class="fa fa-close dx-remove-column js-remove-column" title="Remove Element"></i></span><div id="triangle-down"></div></i>
									<button class="js-edit-col-classes-btn-ok dx-edit-col-classes-btn-ok pull-right">OK</button><i class="js-edit-col-classes-btn dx-edit-col-classes-btn fa fa-pencil pull-right" title="Edit Classes"></i><span class="dx-col-classes pull-right"><?php echo isset($value->col_class)?$value->col_class:''; ?></span>
									
									<?php
									if( $value->column_view == 'contact' ) {
									?>
										<div class="hidden"><?php echo isset( $value->column_data ) ? $value->column_data : "<form class='epb-public-form'></form>"; ?></div>
										<div class="hidden-dialog"><?php echo isset( $value->dialog_data ) ? $value->dialog_data : ""; ?> </div>
									<?php
									}
									if( $value->column_view == 'testimonial' ) {
									?>
										<div class="hidden"><?php echo isset( $value->column_data ) ? $value->column_data : "<table class='dx-testimonial-table'><thead><tr><th><input type='checkbox' title='Select All' class='dx-select-all-testimonial'></th><th>Author Image</th><th>Author Name</th><th>About Author</th><th>Testimonial Content</th><th>Edit</th><th>Delete</th></tr></thead><tbody id='sortable-table'></tbody></table>"; ?> </div>
									<?php
									}
									$common_output_element = array( 'alert', 'article', 'blog', 'custom_text' );
									$common_output_element = apply_filters( 'dx_common_output_element', $common_output_element );
									if( in_array( $value->column_view, $common_output_element ) ) {
									?>
										<div class="hidden"><?php echo isset( $value->column_data ) ? $value->column_data : ""; ?></div>
									<?php
									}
									// Add Hidden data
									do_action( 'add_custom_extension_' . $value->column_view, $value );
									?>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php
				}}
				?>
			</div>
		</div>
	</div>
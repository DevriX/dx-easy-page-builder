<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $dx_epb_admin;
$html = '';

if( ! empty( $data ) ) {
$postdata = $data[0];
foreach( $postdata as $dx_section ) {

	$html .= '<div class="section-container" data-section='.$dx_section->section_order.'>
		<div class="dx-control-wrapper">
			<i class="fa fa-arrows-alt dx-move-section js-move-section" title="Move Section"></i>
			<span class="dx-column-name">'.$dx_section->section_name.'</span>
			<i class="js-edit-section-btn dx-edit-section-btn fa fa-pencil" title="Rename Section"></i>
			<button class="js-edit-section-btn-ok dx-edit-section-btn-ok">OK</button>
			<i class="js-delete-section-btn fa fa-close dx-row-close pull-right" title="Delete Section"></i>
			<span class="js-toggle-section dx-section-settings pull-right">Toggle</span>
			<button class="js-edit-classes-btn-ok dx-edit-classes-btn-ok pull-right">OK</button>
			<i class="js-edit-classes-btn dx-edit-classes-btn fa fa-pencil pull-right" title="Edit Classes"></i>
			<span class="dx-section-classes pull-right">'.$dx_section->section_classes.'</span>
			<select class="dx-select-section-class pull-right">
				<option value="">Select Class</option>';
			
				$selected_class = isset( $dx_section->section_select_class ) ? $dx_section->section_select_class : "";
			
				$section_classes_array = $dx_epb_admin->get_section_classes();
				
				if( ! empty( $section_classes_array ) ) {
					foreach ( $section_classes_array as $class ) {
						if( $class == $selected_class ) {
							$html .= '<option value="'.$class.'" selected="selected">'.$class.'</option>';
						} else{
							$html .= '<option value="'.$class.'">'.$class.'</option>';
						}
					}
				}
			
			$html .= '</select>
		</div>
		<div class="dx-columns-wrapper">
			<div class="dx-droppable">';
?>			
				
<?php foreach ( $dx_section->column_array as $key => $value ) { 
		
		$col_class = isset( $value->col_class ) ? $value->col_class : '';
		
		if( $value->column_view == 'alert' ) {
			$column_alert_ids = isset( $value->column_alert_ids ) ? $value->column_alert_ids : '';
			$html .= '<div class="dx-columns dx-col-' . $value->column_size . '" data-view="' . $value->column_view . '" data-indx="' . $value->column_indx . '" data-alert="' . $value->column_alert . '" data-alert-ids="' . $column_alert_ids.'">';
		} else {
			$html .= '<div class="dx-columns dx-col-' . $value->column_size . '" data-view="' . $value->column_view . '" data-indx="' . $value->column_indx . '">';
		}
			
			$html .= '<i class="fa fa-arrows-alt dx-move-column js-move-column" title="Move Element"></i>
					<span class="dx-section-name">'.$value->column_name.'</span>
					<i class="fa fa-arrow-left js-decrease-column-width" title="Decrease Element Width"></i>
					<span class="dx-column-part">'.$value->column_size.'</span>
					<span>/</span><span class="dx-column-full">12</span>
					<i class="fa fa-arrow-right js-increase-column-width" title="Increase Element Width"></i>
					<i class="fa fa-close pull-right dx-remove-column js-remove-column" title="Remove Element"></i>
					<i class="fa fa-cog pull-right dx-setting-column js-setting-column" title="Element Setting"></i>
					<i class="fa fa-copy pull-right js-copy-column" title="Copy Element"></i>
					<i class="fa fa-align-justify pull-right"><span class="small-column-properties"><i class="fa fa-copy js-copy-column" title="Copy Element"></i><i class="fa fa-cog dx-setting-column js-setting-column" title="Element Setting"></i><i class="fa fa-close dx-remove-column js-remove-column" title="Remove Element"></i></span><div id="triangle-down"></div></i>
					<button class="js-edit-col-classes-btn-ok dx-edit-col-classes-btn-ok pull-right">OK</button><i class="js-edit-col-classes-btn dx-edit-col-classes-btn fa fa-pencil pull-right" title="Edit Classes"></i><span class="dx-col-classes pull-right">'.$col_class.'</span>';

	if( $value->column_view == 'contact' ) {

		$html .= '<div class="hidden">';
		$html .= isset( $value->column_data ) ? $value->column_data : "<form class='dx-epb-public-form'></form>";
		$html .= '</div><div class="hidden-dialog">';
		$html .= isset( $value->dialog_data ) ? $value->dialog_data : "";
		$html .= '</div>';
	}
	else if( $value->column_view == 'testimonial' ) {

		$html .= '<div class="hidden">';
		$html .= isset( $value->column_data ) ? $value->column_data : "<table class='dx-testimonial-table'><thead><tr><th><input type='checkbox' title='Select All' class='dx-select-all-testimonial'></th><th>Author Image</th><th>Author Name</th><th>About Author</th><th>Testimonial Content</th><th>Edit</th><th>Delete</th></tr></thead><tbody id='sortable-table'></tbody></table>";
		$html .= '</div>';
	}
	else {
		$html .= '<div class="hidden">';
		$html .= isset( $value->column_data ) ? $value->column_data : "";
		$html .= '</div>';
	}
		$html .= '</div>';
} 
	$html .= '</div></div></div>';
}}
?>
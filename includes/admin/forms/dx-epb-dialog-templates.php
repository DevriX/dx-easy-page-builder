<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $dx_epb_admin;
$element_array = $dx_epb_admin->dx_element_array();
?>

<!-- Custom Box Dialog HTML -->
<div id="dx-custombox-dialog" title="Custom Text">
	<div class="editor-wrapper"></div>
	<div class="option-wrapper">
		<h3>Box Options</h3>
		
		<h4 class="js-option-wrapper-attributes option-wrapper-attributes">Attributes</h4>
		<div class="option-attributes option-wrapper-inner">
			<div>
				<label>Box Classes</label><br>
				<input type="text" id="dx-custombox-dialog-classes" />
				<p class="dx-dialog-input-description">Enter Classes Seaparated by Space.</p>
			</div>
		</div>
		
		<h4 class="js-option-wrapper-layout option-wrapper-layout">Layout</h4>
		<div class="option-layout option-wrapper-inner">
			<div>
				<label>Padding</label><br>
				<input type="text" id="dx-custombox-dialog-padding" />
				<select id="dx-custombox-dialog-padding-type">
					<option value="px">px</option>
					<option value="%">%</option>
					<option value="in">in</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="em">em</option>
					<option value="ex">ex</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
				</select>
				<p class="dx-dialog-input-description">Padding around the entire Box.</p>
			</div>
		</div>
		
		<h4 class="js-option-wrapper-design option-wrapper-design">Design</h4>
		<div class="option-design option-wrapper-inner">
			<div>
				<label>Background</label><br>
				<input type="text" id="dx-custombox-dialog-background" />
				<p class="dx-dialog-input-description">Background CSS of the Box.</p>
			</div>
			<div>
				<label>Border</label><br>
				<input type="text" id="dx-custombox-dialog-border" />
				<p class="dx-dialog-input-description">Border CSS of the Box.</p>
			</div>
		</div>
	</div>
</div>
<!-- Custom Box Dialog HTML -->

<!-- Testimonial Dialog HTML -->
<div id="dx-testimonialbox-dialog" title="Testimonials">
	<div class="testimonials-wrapper">
		<table class="dx-testimonial-table">
			<thead>
				<tr>
					<th><?php _e('Author Image','dxeasypb') ?></th>
					<th><?php _e('Author Name','dxeasypb') ?></th>
					<th><?php _e('About Author','dxeasypb') ?></th>
					<th><?php _e('Testimonial Content','dxeasypb') ?></th>
					<th><?php _e('Enable','dxeasypb') ?></th>
					<th><?php _e('Edit','dxeasypb') ?></th>
					<th><?php _e('Delete','dxeasypb') ?></th>
				</tr>
			</thead>
			
			<tbody id="sortable-table">
			</tbody>
		</table>
	</div>
	<div class="option-wrapper">
		<h3>Testimonial Options</h3>
		<h4>Add Testimonial</h4>
		<div class="option-wrapper-inner">
			<div>
				<label><?php _e('Author Image','dxeasypb') ?></label><br>
				<input type="text" class="dx-testimonial-add-author-image" /><br>
				<span class="dx-testimonial-empty-image">Author Image Required.</span>
			</div>
			<div>
				<label><?php _e('Author Name','dxeasypb') ?></label><br>
				<input type="text" class="dx-testimonial-add-author-name" /><br>
				<span class="dx-testimonial-empty-name">Author Name Required.</span>
			</div>
			<div>
				<label><?php _e('About Author','dxeasypb') ?></label><br>
				<input type="text" class="dx-testimonial-add-about-author" /><br>
				<span class="dx-testimonial-empty-about">Author Details Required.</span>
			</div>
			<div>
				<label><?php _e('Testimonial Content','dxeasypb') ?></label><br>
				<textarea class="dx-testimonial-add-testimonial-content"></textarea><br>
				<span class="dx-testimonial-empty-content"><?php _e('Testimonial Content Required','dxeasypb'); ?></span>
			</div>
			<button type="button" id="dx-add-testimonial" class="js-add-testimonial ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"><span class="ui-button-text">Add</span></button>
			
		</div>
	</div>
</div>
<!-- Testimonial Dialog HTML -->

<!-- Contact Form Dialog HTML -->
<div id="dx-contactform-dialog" title="Contact Form">
	<div class="form-wrapper">
		<div class="dx-droppable-form">
		
		</div>
	</div>
	<div class="option-wrapper">
		<h3>Contact Form</h3>
		<h4 class="js-option-wrapper-elements option-wrapper-elements"><?php _e('Form Elements','dxeasypb'); ?></h4>
		<div class="option-elements option-wrapper-inner">
			<div class="js-draggable-input dx-draggable-input dx-contactform-dialog-elements" data-type="text">
				<i class="fa fa-arrows-alt js-move-section dx-move-section"></i><input type="text" placeholder="<?php _e('Input Field','dxeasypb'); ?>" />
			</div>
			
			<div class="js-draggable-textarea dx-draggable-textarea dx-contactform-dialog-elements" data-type="textarea">
				<i class="fa fa-arrows-alt js-move-section dx-move-section"></i><textarea placeholder="Textarea" /></textarea>
			</div>
			
			<div class="js-draggable-input dx-draggable-input dx-contactform-dialog-elements" data-type="file">
				<i class="fa fa-arrows-alt js-move-section dx-move-section"></i><input type="file" />
			</div>
		</div>
		
		<h4 class="js-option-wrapper-css option-wrapper-css"><?php _e('Custom CSS','dxeasypb'); ?></h4>
		<div class="option-css option-wrapper-inner">
			<div>
				<label><?php _e('CSS Styles','dxeasypb'); ?></label><br>
				<textarea></textarea><br>
				<p class="dx-dialog-input-description"><?php _e('CSS Styles, given as one per row.','dxeasypb') ?></p>
			</div>
		</div>
	</div>
</div>

<div id="dx-contactform-attributes" title="Attributes">
	<input type="text" name="name" class="dx-contactform-attribute-name" placeholder="<?php _e('Name', 'dxeasypb'); ?>" /><br />
	<input type="text" name="id" class="dx-contactform-attribute-id" placeholder="<?php _e('Id', 'dxeasypb'); ?>" /><br />
	<input type="text" name="class" class="dx-contactform-attribute-class" placeholder="<?php _e('Class', 'dxeasypb'); ?>" />
	<p class="dx-dialog-input-description"><?php _e('You can add multiple classes, each separate by space', 'dxeasypb'); ?></p><br />
	<input type="text" name="placeholder" class="dx-contactform-attribute-placeholder" placeholder="<?php _e('Placeholder', 'dxeasypb'); ?>" /><br />
	<input type="text" name="maxlength" class="dx-contactform-attribute-maxlength" placeholder="<?php _e('Max Length', 'dxeasypb'); ?>" /><br />
</div>
<!-- Contact Form Dialog HTML -->

<!-- DX Easy Page Builder Dialog HTML -->
<div id="dx-epb-dialog" title="Easy Page Builder">
	
	<div class="dx-epb-dialog-editor">
		<div class="top-wrapper-dialog">
			<div class="dx-epb-dialogmenu">
				<button type="button" class="js-section-dialog-btn section-dialog-btn btn"><i class="fa fa-bars"></i>Add New Section</button>
				<button type="button" class="btn section-blue-dialog js-section-blue-dialog"><i class="fa fa-plus"></i>Add Element</button>
				<button type="button" class="btn fa fa-times section-close-dialog js-section-close-dialog" title="Close"></button>
			</div>
			<hr>
			
			<div class="shortcode-btn">
				<?php
					$dx_epb_options = get_option( 'dx_epb_options' );
					$final_array 	= $dx_epb_admin->dx_final_element_array( $element_array );
					
					foreach( $element_array as $element_key => $element_value ) {
						if( ( ! empty( $dx_epb_options ) && in_array( $element_key, $dx_epb_options ) ) 
								|| ! in_array( $element_value, $final_array ) ) {
							if( $element_key != 'custom_text' ) {
				?>
								<div class="js-draggable dx-draggable" data-type="<?php echo $element_key; ?>"><?php echo $element_value; ?></div>
				<?php } } } ?>	
			</div>
			
		</div>
		<div class="page-template-area">
			<div class="row-container-dialog">
				
			</div>
		</div>

	</div>
</div>
<!-- DX Easy Page Builder Dialog HTML -->

<!-- Blog Dialog HTML -->
<div id="dx-blog-dialog" title="Blog">
	
</div>
<!-- Blog Dialog HTML -->

<!-- Confirm Devrix Dialog HTML -->
<div id="dx-confirm-devrix-dialog" title="Confirm">
	<p>Are you sure to move to Devrix Page Builder?</p>
</div>
<!-- Confirm Devrix Dialog HTML -->

<!-- Confirm other Dialog HTML -->
<div id="dx-confirm-other-dialog" title="Confirm">
	<p>Are you sure to move from Devrix Page Builder?</p>
</div>
<!-- Confirm other Dialog HTML -->

<!-- Custom Textarea Dialog HTML -->
<div id="dx-custom-textarea-dialog" title="Textarea">
	<textarea name="dx-custom-textarea-dialog-content" placeholder="Write Something..."></textarea>
</div>
<!-- Custom Textarea Dialog HTML -->

<!-- Article Dialog HTML -->
<div id="dx-article-dialog" title="Article">
	<?php
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'post',
		'post_status'      => 'publish'
	);
	$posts_array = get_posts( $args );
	
	echo '<label for="dx_article">Select Article to Display</label><br>';
	echo '<select name="dx_article" id="dx_article">';
	echo '<option value="">Select Article</option>';
	foreach ( $posts_array as $key => $value ) {
		echo '<option value="' . $value->ID . '">' . $value->post_title . '</option>';
	}
	echo '</select>';
	?>
</div>
<!-- Article Dialog HTML -->

<!-- Alert Dialog HTML -->
<div id="dx-alert" title="Set Alert">
	<div class="editor-wrapper">
		<textarea name="dx-alert-content" id="dx-alert-content" placeholder="Write Alert Message..."></textarea>
	</div>
	<div class="option-wrapper">
		<h4 class="js-option-wrapper-alert option-wrapper-alert">Alert Settings</h4>
		<div class="option-alert option-wrapper-inner">
			<div>
				<label for="dx-alert-type">Select Alert Type</label>
				<br>
				<select id="dx-alert-type" name="dx-alert-type">
					<option value="On Page Load">On Page Load</option>
					<option value="On Click">On Click</option>
				</select>
				<br><br>
				<div class="dx-alert-ids-wrap">
					<label for="dx-alert-ids">Ids of Element</label>
					<input type="text" name="dx-alert-ids" id="dx-alert-ids" placeholder="Enter Ids of Element">
					<br>
					<p class="dx-dialog-input-description">Enter Ids of Element, Each Seperated By Space.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Alert Dialog HTML -->

<?php do_action( 'dx_dialog_template' ); ?>
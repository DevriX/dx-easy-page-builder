<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * dxeasypb Setting Components Page
 *
 * Handle dxeasypb Setting Components
 * 
 * @package DX Easy Page Builder
 * @since 1.0.0
 */

	global $dx_epb_admin;
	$element_array = $dx_epb_admin->dx_element_array();
	
	$element_array= $dx_epb_admin->dx_default_element_array($element_array);
?>
	<!-- . begining of wrap -->
	<div class="wrap">
		<?php 
			echo screen_icon('options-general');
		?>	
		
		<!-- beginning of the plugin components form -->
		<form method="post" action="options.php">		
		
			<?php
				settings_fields( 'dx_epb_register_options' );
				$dx_epb_options = get_option( 'dx_epb_options' );
				

			?>
			<!-- beginning of the settings meta box -->	
			<div id="dx-epb-settings" class="post-box-container">
			
				<div class="metabox-holder">	
			
					<div class="meta-box-sortables ui-sortable">
			
						<div id="settings" class="postbox">	
			
							<div class="handlediv" title="<?php echo __( 'Click to toggle', 'dxeasypb' ) ?>"><br /></div>
			
								<!-- settings box title -->					
								<h3 class="hndle">					
									<span style="vertical-align: top;"><?php echo __( 'Check Compontents to Display in Post/Page', 'dxeasypb' ) ?></span>					
								</h3>
			
								<div class="inside">			

									<table class="form-table"> 
										<tbody>
											<?php foreach($element_array as $element_key => $element_value ){  ?>
												<tr>
													<th scope="row">
														<label><strong><?php echo $element_value; ?></strong></label>
													</th>
													<td>
														<input type="checkbox" name="dx_epb_options[]" value="<?php echo $element_key; ?>" <?php if(!empty($dx_epb_options) && in_array($element_key, $dx_epb_options)) { echo 'checked="checked"'; }?> />
													</td>
												 </tr>
											<?php } ?>
											
											<tr>
												<td colspan="2">
													<input type="submit" class="button-primary dx-epb-save-all-options" name="" class="" value="<?php echo __( 'Save Changes', 'dxeasypb' ) ?>" />
												</td>
											</tr>
										</tbody>
									</table>
						
							</div><!-- .inside -->
				
						</div><!-- #settings -->
			
					</div><!-- .meta-box-sortables ui-sortable -->
			
				</div><!-- .metabox-holder -->
			
			</div><!-- end of the settings meta box -->

		</form><!-- end of the plugin components form -->
	
	</div><!-- end of wrap -->
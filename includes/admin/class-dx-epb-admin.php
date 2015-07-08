<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Admin Class
 *
 * Handles generic Admin functionality and AJAX requests.
 *
 * @package DX Easy Page Builder
 * @since 1.0.0
 */
class Dx_Epb_Admin {
	
	public $scripts,$model;
	
	public function __construct() {		
	
		global $dx_epb_scripts, $dx_epb_model;
		$this->scripts 	= $dx_epb_scripts;
		$this->model 	= $dx_epb_model;
	}
	
	/**
	 * Create menu page
	 *
	 * Adding required menu pages and submenu pages
	 * to manage the plugin functionality
	 * 
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	
	public function dx_epb_add_menu_page() {
		
		
	}

	/**
	 * Register Settings
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */

	public function dx_epb_admin_init() {
		
		
		
	}
	
	/**
	 * Including Content for WP Editor
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function wp_editor_content() {
		
		include_once DX_EPB_ADMIN . '/forms/dx-epb-wp-editor.php';
	}
	
	/**
	 * Including Content for Dialogs
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_dialog() {
		
		include_once DX_EPB_ADMIN . '/forms/dx-epb-dialog-templates.php';

	}
	/**
	 * Save page builder data
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_single_template_save() {

		if( $_POST['action'] == 'dx_single_template' ) {
			$dx_post	= array();
			$post_id 	= $_POST["post_id"];
			$data 		= stripslashes( $_POST['template_data'] );

			update_post_meta( $post_id, '_dx_epb_pagebuilder', json_decode( $data ) );
			
			/**
			 * [$data Shortcode data]
			 * @var [type]
			 */
			$data = apply_filters( 'dx_generate_shortcode' , json_decode( $data ) );
			
			$new_data = trim( str_replace( '] [','][', preg_replace( '/\s+/', ' ', $data ) ) );
			
			update_post_meta( $post_id, '_dx_epb_pagebuilder_shortcode', $new_data );
			
			die;
		}
	}
	
	/**
	 * Save Custom Text Button Dialog data
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_single_template_dialog() {
		
		$post_id   = $_POST['post_id'];
		$editor_id = $_POST['editor_id'];
		
		$data = get_post_meta( $post_id, $editor_id, true );
		
		include_once DX_EPB_ADMIN . '/forms/dx-epb-open-custom-dialog.php';
		
		echo isset( $html ) ? $html : '';
		
		die;
	}
	
	/**
	 * Save Custom Text Button Dialog data
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_single_template_save_dialog() {

		if( $_POST['action'] == 'dx_single_template_save_dialog' ) {
			
			$post_id 		= $_POST["post_id"];
			$editor_id 		= $_POST["editor_id"];
			$data 			= json_decode( stripslashes( $_POST['template_data'] ) );
			$shortcode_data = apply_filters( 'dx_generate_dialog_shortcode' , $data, $editor_id );
			$shortcode_data = trim( str_replace( '] [','][', preg_replace( '/\s+/', ' ', $shortcode_data ) ) );
			$editor_data 	= array( $data, $shortcode_data );
			$old_data		= get_post_meta( $post_id, $editor_id, true );
			
			if( isset( $old_data ) && ! empty( $old_data ) ) {
				$send_data = $old_data[1];
			} else {
				$send_data = '';
			}
					
			update_post_meta( $post_id, $editor_id, $editor_data );
			
			$response 	= array( "old_data" => $send_data, "data" => $shortcode_data );
    		echo json_encode( $response );
    		die;
		}
	}

	/**
	 * Default Editor Set
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	function tinymce_default_editor( $editor ) {
	    return 'depb';
	}

	/*
	*  Generate WP-Editor
	*/
	function dx_generate_wp_editor( $content = '' ) {
		
		$editor_indx = $_GET['editor_indx'];
		
		$editor_id = $editor_indx;
		$settings  = array( 
				'textarea_name' => $editor_id, 
				'media_buttons'=> false,
				'quicktags'=> true, 
				'teeny' => false, 
				'editor_class' => 'content mycustomeditor'
		);
		
		echo wp_editor( $content, $editor_id );
		exit;
	}
	/*
	*  Generate Page Editor Content
	*/
	function dx_filter_content( $content = '' ) {
		global $post;
		
		$post_id              = $post->ID;
		$page_builder_content = get_post_meta( $post_id, '_dx_epb_pagebuilder' , true );
		$page_builder_content = apply_filters( 'dx_pagebuider_content' , $page_builder_content );
		
		return $page_builder_content;
	}

	/*
	*  Generate Page Editor Content
	*/
	function dx_prepare_content( $content = '' ){
		//$content = json_decode($content);
		
		if( ! empty( $content ) ) {
			ob_start();
			foreach( $content as $section ) {
					if( $section->section_classes == 'Section Classes' ) {
						$section_classes = '';
					} else {
						$section_classes = $section->section_classes;
					}
					
					if( $section->section_select_class == 'Select Class' ) {
						$section_select_class = '';
					} else {
						$section_select_class = $section->section_select_class;
					}
				 ?>
				[dx_section section_name="<?php echo $section->section_name; ?>" section_class="<?php echo $section_classes; ?><?php if(!empty($section_select_class)) echo " ".$section_select_class; ?>"]
				<?php if( isset( $section->column_array ) && ! empty( $section->column_array ) ): ?>
					<?php foreach( $section->column_array as $row ): 
						if( $row->col_class == 'Column Classes' ) {
							$column_class = '';
						} else {
							$column_class = $row->col_class;
						}
					?>
							[dx_row column_name="<?php echo $row->column_name; ?>" column_size="<?php echo $row->column_size; ?>" column_view="<?php echo $row->column_view; ?>" column_class="<?php echo $column_class; ?>"]
								<?php //echo isset($row->column_data)?$row->column_data:""; ?>
								<?php apply_filters( 'dx_shortcode_variety', $row ); ?>
							[/dx_row]
					<?php endforeach; ?>
				<?php endif; ?>
				[/dx_section]
				<?php
			}
			$dx_content = ob_get_clean();
			return $dx_content;
		}
		
	}
	
	/*
	*  Generate Dialog Editor Content
	*/
	function dx_prepare_dialog_content( $content = '', $editor_id ) {
		//$content = json_decode($content);
		
		if( ! empty( $content ) ) {
			ob_start();
			foreach( $content as $section ) {
					if( $section->section_classes == 'Section Classes' ) {
						$section_classes = '';
					} else{
						$section_classes = $section->section_classes;
					}
					
					if( $section->section_select_class == 'Select Class' ) {
						$section_select_class = '';
					} else {
						$section_select_class = $section->section_select_class;
					}
				 ?>
				[dx_section section_name="<?php echo $section->section_name; ?>" section_class="<?php echo $section_classes; ?><?php if(!empty($section_select_class)) echo " ".$section_select_class; ?>"]
				<?php if( isset( $section->column_array ) && ! empty( $section->column_array ) ): ?>
					<?php foreach( $section->column_array as $row ): 
						if( $row->col_class=='Column Classes' ) {
							$column_class = '';
						} else{
							$column_class = $row->col_class;
						}
					?>
							[dx_row column_name="<?php echo $row->column_name; ?>" column_size="<?php echo $row->column_size; ?>" column_view="<?php echo $row->column_view; ?>" column_class="<?php echo $column_class; ?>"]
								
								<?php apply_filters( 'dx_shortcode_dialog_variety', $row, $editor_id ); ?>
							
							[/dx_row]
					<?php endforeach; ?>
				<?php endif; ?>
				[/dx_section]
				<?php
			}
			$dx_content = ob_get_clean();
			return $dx_content;
		}
		
	}
	
	/**
	 * Generate Dialog Shortcode Variety
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_shortcode_dialog_variety( $content, $editor_id ) {
		if( ! empty( $content ) ) {
			switch ( $content->column_view ) {
				case 'testimonial':
					echo '[dx_testimonial editor_id="'.$editor_id.'" id="'.$content->column_indx.'"]';
					break;
				case 'contact':
					echo '[dx_contact_form editor_id="'.$editor_id.'" id="'.$content->column_indx.'"]';
					break;
				case 'custom_text':
					//$content = isset($content->column_data) ? $content->column_data : "";
					//$content = apply_filters('dx_content_shortcode_filter',$content);
					//echo $content;
					echo '[dx_custom editor_id="'.$editor_id.'"]';
					break;
				case 'article':
					echo '[dx_article editor_id="'.$editor_id.'" id="'.$content->column_indx.'"]';
					break;
				case 'blog':
					echo "[dx_blog]";
					break;
				case 'custom_textarea':
					echo '[dx_textarea editor_id="'.$editor_id.'" id="'.$content->column_indx.'"]';
					break;
				case 'alert':
					echo '[dx_alert editor_id="'.$editor_id.'" id="'.$content->column_indx.'"]';
					break;
				
				default:
					# code...
					break;
				}
				/**
				 * Add Custom shortcode logic and get desire output.
				 */
				 do_action( 'dx_add_custom_shortcode', $content );
			}
			return $this;
		}
	
	/**
	 * Generate Shortcode Variety
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_shortcode_variety( $content ) {
		if( ! empty( $content ) ) {
			switch ( $content->column_view ) {
				case 'testimonial':
					echo '[dx_testimonial id="'.$content->column_indx.'"]';
					break;
				case 'contact':
					echo '[dx_contact_form id="'.$content->column_indx.'"]';
					break;
				case 'custom_text':
					//$content = isset($content->column_data) ? $content->column_data : "";
					//$content = apply_filters('dx_content_shortcode_filter',$content);
					//echo $content;
					echo '[dx_custom id="'.$content->column_indx.'"]';
					break;
				case 'article':
					echo '[dx_article id="'.$content->column_indx.'"]';
					break;
				case 'blog':
					echo "[dx_blog]";
					break;
				case 'custom_textarea':
					echo '[dx_textarea id="'.$content->column_indx.'"]';
					break;
				case 'alert':
					echo '[dx_alert id="'.$content->column_indx.'"]';
					break;
					
				default:
					# code...
					break;
				}
				/**
				 * Add Custom shortcode logic and get desire output.
				 */
				 do_action( 'dx_add_custom_shortcode', $content );
			}
			return $this;
		}

	/**
	 * Add Element Array
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_element_array() {
		$dx_element_array = array();
		
		$dx_element_array['testimonial'] 	 = __('Testimonial', 'dxeasypb');
		$dx_element_array['alert'] 			 = __('Alert Window', 'dxeasypb');
		$dx_element_array['contact'] 		 = __('Contact From', 'dxeasypb');
		$dx_element_array['custom_text'] 	 = __('Custom Text', 'dxeasypb');
		$dx_element_array['article'] 		 = __('Article Box', 'dxeasypb');
		$dx_element_array['blog'] 			 = __('Blog', 'dxeasypb');
		$dx_element_array['custom_textarea'] = __('Textarea', 'dxeasypb');
		
		$dx_element_array = apply_filters( 'dx_element_filter', $dx_element_array );
				
		return $dx_element_array;
	}
	
	/**
	 * Register Easy Page Builder Button
	 *
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	function dx_tinymce_manager() {
		add_filter( 'mce_buttons', array( $this, 'dx_editor_register_button' ) );	
		add_filter( 'mce_external_plugins', array( $this, 'dx_popup_plugin' ) );
	}
	/**
	 * [dx_editor_register_button Register Button]
	 * @param  [type] $buttons [Add buttons in array]
	 * @return [type]          [Array]
	 */
	function dx_editor_register_button( $buttons ) {	
	
	 	array_push( $buttons, "|", "dxeasypbicon" );
	 	/**
	 	 * [$buttons contain tinymce extra buttons]
	 	 * @var [Array]
	 	 */
	 	$buttons = apply_filters( 'dx_custom_default_editor_button', $buttons );
	 	return $buttons;
	}
	/**
	 * [dx_popup_plugin Add WP Editor Button events]
	 * @param  [type] $plugin_array [Array Contain wp editor popup events]
	 * @return [type]               [Array]
	 */
	function dx_popup_plugin( $plugin_array ) {
	
		wp_enqueue_script( 'tinymce' );
	
		$plugin_array['dxeasypbicon'] = DX_EPB_URL . "includes/js/dx-epb-tinymce-button.js";
		/**
		 * [$plugin_array Array for set wp-editor custom button events]
		 * @var [Array]
		 */
		$plugin_array = apply_filters( 'dx_custom_default_editor_btn_event', $plugin_array );
		
		return $plugin_array;
	}

	public function dx_content_shortcode_filter( $value='' ) {
		$data = do_shortcode( $value );
		return $data;
	}
	
	public function dx_components_page() {
		
		$dx_components_page = add_options_page( 'DX Easy Page Builder', 'DX Easy Page Builder', 'manage_options', 'dx-easy-page-builder', array($this,'dx_setting_page_html'));
		
		add_action( "admin_head-$dx_components_page", array( $this->scripts, 'dx_epb_settings_scripts' ) );
	}
	
	public function dx_include_components_page() {
		include_once DX_EPB_ADMIN.'/forms/dx-epb-components.php';
	}
	
	public function dx_epb_register_options() {
		register_setting( 'dx_epb_register_options', 'dx_epb_options' );
	}
	
	/**
	 * Save Editor Type
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_save_editor_type() {
		
		$post_id 	= $_POST["post_id"];
		$editor 	= $_POST['editor'];
		
		if( $_POST['action'] == 'dx_save_editor_type' ) {
			update_post_meta( $post_id, 'editor', $editor );
		}
		die;
	}
	
	/**
	 * Get Editor Type
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_get_editor_type() {
		
		$post_id = $_POST["post_id"];
		
		$editor = get_post_meta( $post_id, 'editor', true );
		
		echo $editor;
		die;
	}
	
	public function dx_epb_save_post() {
		
		global $post;
		
		if( isset( $_POST['dx-save-hidden'] ) && ! empty( $_POST['dx-save-hidden'] ) ) {
			$editor = $_POST['dx-save-hidden'];
			update_post_meta( $post->ID, 'editor', $editor );
		}
	}
	
	/**
	 * Add menu to setting page
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_add_navbar() {
		$navbar = "";
		// Filter to add new tab in contact setting page
		$navbar = apply_filters( 'dx_add_navbar', $navbar );
		return $navbar;
	}

	/**
	 * Get Setting data
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 * @return Options Data
	 */
	public function dx_setting_page_data() {
		$option_data = get_option( 'dx_epb_options' );
		
		return $option_data;
	}
	
	/**
	 * Common form for setting page
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_setting_page_html() { 
		$dx_nav_tab = array();
		$dx_nav_tab = $this->dx_add_navbar();
		
		if( ! empty( $dx_nav_tab ) ) {
			?>
		<div class="wrap">
    
		    <h2 class="dx-epb-settings-title">
		    	<?php echo __( 'DX Easy Page Builder', 'dxeasypb' ); ?>
		    </h2>
			<div class="content dx-epb-content-section">
				<h2 class="nav-tab-wrapper dx-epb-tabs">
			<?php			
			$activetab = isset( $_GET['tab'] ) ? $_GET['tab'] : "pagebuilder_welcome";
			foreach ( $dx_nav_tab as $key => $value ) {
				$selected_tab = "";
				if( $activetab == $key ) 
					$selected_tab = 'nav-tab-active';

				$selected_tab = isset( $selected_tab ) ? $selected_tab : "";
				$dx_url       = admin_url( "options-general.php?page=dx-easy-page-builder&tab=".$key )
			?>
				<a class="nav-tab <?php echo $selected_tab;?>" href="<?php echo $dx_url;?>"><?php echo $value; ?></a>
			<?php } ?>
				</h2>
			</div>
		<?php }	?>
		<div class="dx-epb-content">			 
			<?php 
			if( ! empty( $dx_nav_tab ) ) {
				foreach ( $dx_nav_tab as $key => $value ) { 
					$selected_tab = "";
					if( $activetab == $key ) 
					$selected_tab = 'dx-tab-content-activate';
			?>
				<div class="dx-tab-content dx-epb-content-<?php echo $key." ".$selected_tab; ?>" id="<?php echo $key; ?>">
					<?php do_action( 'dx_setting_tab_'.$key ); ?>
				</div>
			<?php } }
			?>
		</div>
	</div>
		<?php
	}
	
	/* Add Welcome Tab in setting page */
	public function add_tab_welcome_nav( $navbar ) {
		$navbar['pagebuilder_welcome'] = "Welcome";
		
		return $navbar;
	}
	
	/**
	 * Include Welcome Setting Page
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_welcome_page_content() { 
		include_once DX_EPB_ADMIN . '/forms/dx-epb-welcome.php';
	}
	
	/* Add Component Tab in setting page */
	public function add_tab_component_nav( $navbar ) {
		$navbar['pagebuilder_component'] = "Easy Page Builder Components";
		
		return $navbar;
	}
	
	/**
	 * Include Component Setting Page
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_component_page_content() { 
		include_once DX_EPB_ADMIN.'/forms/dx-epb-components.php';
	}
	
	/**
	 * delete custom text element
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_delete_custom_text_meta() {
		
		if( $_POST['action'] == 'dx_delete_custom_text_meta' ){
			$post_id 	= $_POST["post_id"];
			$editor_id 	= $_POST["editor_id"];
			delete_post_meta( $post_id, $editor_id );
		}
		die;
	}
	
	public function dx_default_element_array( $element_array ) {
		$element_array = apply_filters( 'dx_filter_element_array', $element_array );
		
		return $element_array;
	}
	
	public function dx_final_element_array( $element_array ) {
		
		$default_element = array( 'Custom Text', 'Textarea' );
		$default_element = apply_filters('dx_set_default_element', $default_element );
		
		foreach( $default_element as $array ) {
			$index = array_search( $array, $element_array );
			
			if( $index !== FALSE ) {
			    unset( $element_array[$index] );
			}
		}
		
		return $element_array;
	}
	
	function get_section_classes() {
		
		$section_classes_array = array( 'demo', 'test' );
		$section_classes_array = apply_filters( 'section_classes_array', $section_classes_array );
		return $section_classes_array;
	}
	
	public function dx_get_section_classes_ajax() {
		
		if( $_POST['action'] == "dx_get_section_classes_ajax" ) {
			
			$class_array = $this->get_section_classes();
			$html = '';
			
			if( ! empty( $class_array ) ) {
				foreach( $class_array as $key=>$value ) {
					$html .= '<option value="'.$value.'">'.$value.'</option>';
				}
			}
			echo $html;
		}
		die;
	}
	
	/**
	 * Adding Hooks
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function add_hooks() {
		// Add action to load pagebuilder for post and add post.
		add_action( 'admin_footer-post.php', 		array( $this, 	'wp_editor_content' ) );
		add_action( 'admin_footer-post-new.php', 	array( $this, 	'wp_editor_content' ) );
		add_action( 'admin_footer-post.php', 		array( $this, 	'dx_dialog' ) );
		add_action( 'admin_footer-post-new.php', 	array( $this, 	'dx_dialog' ) );
		add_filter( 'wp_default_editor', 			array( $this,	'tinymce_default_editor' ) );
		add_action(	'wp_ajax_dx_single_template',   array( $this,	'dx_single_template_save') );
		add_action(	'wp_ajax_nopriv_dx_single_template',   array(   $this,	'dx_single_template_save') );
		add_action(	'wp_ajax_dx_load_editor',   	array( $this,	'dx_generate_wp_editor') );
		add_action(	'wp_ajax_nopriv_dx_load_editor',array( $this,	'dx_generate_wp_editor') );
		add_filter( 'dx_generate_shortcode', 		array( $this,   'dx_prepare_content' ) );
		add_filter( 'dx_generate_dialog_shortcode', 		array( $this,'dx_prepare_dialog_content' ), 10, 2 );
		add_filter( 'dx_shortcode_variety', 			array( $this,   'dx_shortcode_variety' ) );
		add_filter( 'dx_shortcode_dialog_variety', 			array( $this,   'dx_shortcode_dialog_variety' ), 11, 2 );
		add_filter( 'wp_default_editor', create_function('', 'return "epb";' ) );
		add_action( 'init' , array( $this, 'dx_tinymce_manager' ) );    
		add_action( 'admin_init', array($this,'dx_element_array' ) );
		add_filter( 'dx_content_shortcode_filter', array( $this, 'dx_content_shortcode_filter' ) );
		
		add_action(	'wp_ajax_dx_single_template_save_dialog',array( $this,	'dx_single_template_save_dialog') );
		add_action(	'wp_ajax_nopriv_dx_single_template_save_dialog',array(   $this,	'dx_single_template_save_dialog') );
		
		add_action(	'wp_ajax_dx_single_template_dialog',array( $this,	'dx_single_template_dialog') );
		add_action(	'wp_ajax_nopriv_dx_single_template_dialog',array(   $this,	'dx_single_template_dialog') );
		
		add_action(	'wp_ajax_dx_save_editor_type',array( $this,	'dx_save_editor_type') );
		add_action(	'wp_ajax_nopriv_dx_save_editor_type',array(   $this,	'dx_save_editor_type') );
		
		add_action(	'wp_ajax_dx_get_editor_type',array( $this,	'dx_get_editor_type') );
		add_action(	'wp_ajax_nopriv_dx_get_editor_type',array(   $this,	'dx_get_editor_type') );
		
		add_action( 'admin_menu', array( $this, 'dx_components_page' ) );
		add_action( 'admin_init', array( $this, 'dx_epb_register_options' ) );
		
		add_action( 'save_post', array( $this, 'dx_epb_save_post' ) );
		
		// Setting Welcome Page
		add_filter( 'dx_add_navbar', array( $this, 'add_tab_welcome_nav' ) );
		add_action( 'dx_setting_tab_pagebuilder_welcome', array( $this, 'dx_welcome_page_content' ) );
		
		// Setting Components Page
		add_filter( 'dx_add_navbar', array( $this, 'add_tab_component_nav' ) );
		add_action( 'dx_setting_tab_pagebuilder_component', array( $this, 'dx_component_page_content' ) );
		
		//delete custom text element
		add_action(	'wp_ajax_dx_delete_custom_text_meta',array( $this, 'dx_delete_custom_text_meta' ) );
		add_action(	'wp_ajax_nopriv_dx_delete_custom_text_meta',array( $this, 'dx_delete_custom_text_meta' ) );
		
		add_filter( 'dx_filter_element_array', array( $this, 'dx_final_element_array' ) );
		
		add_action(	'wp_ajax_dx_get_section_classes_ajax', array( $this, 'dx_get_section_classes_ajax' ) );
		add_action(	'wp_ajax_nopriv_dx_get_section_classes_ajax', array( $this, 'dx_get_section_classes_ajax' ) );
	}
}
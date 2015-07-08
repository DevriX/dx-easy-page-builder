<?php 

/**
 * Scripts Class
 *
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package DX Easy Page Builder
 * @since 1.0.0
 */
class Dx_Epb_Scripts
{
	/**
	 * [__construct Page on Load constructor ]
	 */
	function __construct()
	{
		# code...
	}

	/**
	 * Enqueuing Styles
	 *
	 * Loads the required stylesheets for displaying the theme settings page in the WordPress admin section.
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_epb_admin_styles( $hook_suffix ) {
		
		// loads the required styles for the plugin settings page
		wp_register_style( 'dx-epb-admin-new', DX_EPB_URL . 'includes/css/dx-epb-admin-new.css', array(), null );
		
		$pages_hook_suffix = array( 'post.php', 'post-new.php' );
		
		//Check pages when you needed
		if( in_array( $hook_suffix, $pages_hook_suffix ) ) {

			// Wordpress default JS enqueue.
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-dialog' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( 'jquery-ui-droppable' );
			wp_enqueue_script( 'tiny_mce' );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

			// loads the required styles for the plugin settings page
			wp_register_style( 'dx-epb-admin', DX_EPB_URL . 'includes/css/dx-epb-admin.css', array(), null );

			// Setting page CSS Enqueue
			wp_enqueue_style( 'dx-epb-admin' );
			wp_enqueue_style( 'dx-epb-admin-new' );

			// Jquery dialog CSS
			wp_register_style( 'dx-epb-jquery-ui', DX_EPB_URL . 'includes/css/jquery-ui.min.css', array(), null );
			wp_enqueue_style( 'dx-epb-jquery-ui' );
			
			// Admin Controller of action JS
			wp_register_script( 'dx-epb-admin-control', DX_EPB_URL . 'includes/js/dx-epb-control.js', array(), null );
			wp_enqueue_script( 'dx-epb-admin-control' );

			// Admin Page builder page JS
			wp_register_script( 'dx-epb-admin-js', DX_EPB_URL . 'includes/js/dx-epb-admin.js', array(), null );
			wp_enqueue_script( 'dx-epb-admin-js' );
			
			// Tinymce Button JS
			wp_register_script( 'dx-epb-tinymce-button-js', DX_EPB_URL . 'includes/js/dx-epb-tinymce-button.js', array('jquery'), null );
			wp_enqueue_script( 'dx-epb-tinymce-button-js' );
			
			// Admin Page builder create new page js
			wp_register_script( 'dx-epb-admin-new-js', DX_EPB_URL . 'includes/js/dx-epb-admin-new.js', array(), null );
			wp_enqueue_script( 'dx-epb-admin-new-js' );

			// Admin Page builder save page js
			wp_register_script( 'dx-epb-admin-save-js', DX_EPB_URL . 'includes/js/dx-epb-admin-save.js', array(), null );
			wp_enqueue_script( 'dx-epb-admin-save-js' );

			// Font Awesome font family script
			wp_register_style( 'dx-epb-admin-fontawesome', DX_EPB_URL . 'includes/css/font-awesome.min.css', array(), null );
			wp_enqueue_style( 'dx-epb-admin-fontawesome' );
			
			
		}
		
		$settings_hook_suffix = array( 'settings_page_dx-easy-page-builder' );
		
		if( in_array( $hook_suffix, $settings_hook_suffix ) ) {
			wp_enqueue_script( 'common' );
			wp_enqueue_script( 'wp-lists' );
			wp_enqueue_script( 'postbox' );
			
			// Setting page CSS Enqueue
			wp_enqueue_style( 'dx-epb-admin-new' );
		}
	}
	
	/**
	 * Public Scripts and Styles
	 *
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_epb_public_scripts() {
		
		// loads the required styles for the plugin settings page
		wp_register_style( 'dx-epb-public-style', DX_EPB_URL . 'includes/css/dx-epb-public.css', array(), null );
		wp_enqueue_style( 'dx-epb-public-style' );
	}
	
	/**
	 * Loading Additional Java Script
	 *
	 * Loads the JavaScript required for toggling the meta boxes.
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	 public function dx_epb_settings_scripts() { 

		echo '<script type="text/javascript">
				//<![CDATA[
				jQuery(document).ready( function($) {
					$(".if-js-closed").removeClass("if-js-closed").addClass("closed");
					postboxes.add_postbox_toggles( "admin_head-dx-epb-components" );
				});
				//]]>
			</script>';
	}
	
	/**
	 * [add_hooks Added Hook for page onload function call]
	 */
	public function add_hooks()
	{
		// Enqueue script
		add_action( 'admin_enqueue_scripts', array( $this, 'dx_epb_admin_styles' ) );
		
		// Enqueue Public Scripts and Styles
		add_action( 'wp_enqueue_scripts', array( $this, 'dx_epb_public_scripts' ) );
	}
}
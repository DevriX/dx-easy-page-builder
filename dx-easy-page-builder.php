<?php
/**
 * Plugin Name: DX Easy Page Builder
 * Plugin URI: http://devrix.com
 * Description: Manage Single Page as a Template.
 * Author: DevriX
 * Author URI: http://devrix.com
 * Version: 0.1
 * Text Domain: dxeasypb
 * Domain Path: /languages
 * License: GPLv2
 * 
 */

// Defines
// ....

if( !defined( 'DX_EPB_DIR' ) ) {
	define( 'DX_EPB_DIR', dirname( __FILE__ ) ); // Plugin Dir
}
if( !defined( 'DX_EPB_URL' ) ) {
	define( 'DX_EPB_URL', plugin_dir_url( __FILE__ ) ); // Plugin URL
}
if( !defined( 'DX_EPB_ADMIN' ) ) {
	define( 'DX_EPB_ADMIN', DX_EPB_DIR . '/includes/admin' ); // Admin Dir
}
if( !defined( 'DX_PREFIX_EPB' ) ) {
	define( 'DX_PREFIX_EPB', 'dx_epb' ); // Plugin Prefix
}

/**
 * Load Text Domain
 * 
 * This gets the plugin ready for translation.
 * 
 * @package DX Easy Page Builder
 * @since 1.0.0
 */
load_plugin_textdomain( 'dxeasypb', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Initialize all global variables
 * 
 * @package DX Easy Page Builder
 * @since 1.0.0
 */
global $dx_epb_scripts, $dx_epb_admin, $dx_epb_shortcodes, $dx_epb_model, $dx_epb_public;

/**
 * Includes
 *
 * Includes all the needed files for plugin
 *
 * @package DX Easy Page Builder
 * @since 1.0.0
 */
require_once( DX_EPB_DIR . '/includes/class-dx-epb-scripts.php');
$dx_epb_scripts = new Dx_Epb_Scripts();
$dx_epb_scripts->add_hooks();

//Includes Model Class File
require_once( DX_EPB_DIR . '/includes/class-dx-epb-model.php');
$dx_epb_model = new Dx_Epb_Model();

//Includes Admin Class File
require_once ( DX_EPB_ADMIN . '/class-dx-epb-admin.php');
$dx_epb_admin = new Dx_Epb_Admin();
$dx_epb_admin->add_hooks();

//Includes Public Class File
require_once ( DX_EPB_DIR . '/includes/class-dx-epb-public.php');
$dx_epb_public = new Dx_Epb_Public();
$dx_epb_public->add_hooks();

//Includes Shortcode File
require_once ( DX_EPB_DIR . '/includes/class-dx-epb-shortcodes.php');
<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Public Class
 *
 * Handles generic Public functionality.
 *
 * @package DX Easy Page Builder
 * @since 1.0.0
 */
class Dx_Epb_Public {
	
	public $scripts, $model;
	
	public function __construct() {
		global $dx_epb_scripts, $dx_epb_model;
		
		$this->scripts 	= $dx_epb_scripts;
		$this->model 	= $dx_epb_model;
	}
	/**
	 * [dx_public_content Function will filter content and do Shortcode if available]
	 * @param  [type] $content [Page Content]
	 * @return [type]          [Return Filter Content using Do Shortcode]
	 */
	public function dx_epb_public_content( $content ) {
		global $post;
		
		$editor = get_post_meta( $post->ID, 'editor', true );
		
		if( $editor == 'devrix' ) {
			$posts = get_post_meta( $post->ID, '_dx_epb_pagebuilder_shortcode', true );
			return do_shortcode( $posts );
		} else {
			return $content;
		}
	}
	
	/**
	 * Adding Hooks
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function add_hooks() {
		add_filter( 'the_content', array($this, DX_PREFIX_EPB.'_public_content' ));
		//add_action( 'init', array($this, DX_PREFIX_EPB.'_alert' ));
	}
}
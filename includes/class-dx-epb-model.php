<?php 
/**
 * Model Class
 *
 * @package DX Easy Page Builder
 * @since 1.0.0
 */
class Dx_Epb_Model {
	
	public function __construct(){
		
	}
	/**
	 * Escape Tags & Slashes
	 *
	 * Handles escapping the slashes and tags
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_epb_escape_attr( $data ){
			
	}
	
	/**
	 * Escape Tags & Slashes
	 *
	 * Handles escapping the slashes and tags
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_epb_escape_attr_line( $data ){
		
	}
	
	/**
	 * Stripslashes 
 	 * 
  	 * It will strip slashes from the content
	 *
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_epb_escape_slashes_deep( $data = array(), $flag=false, $limited = false ) {
		
		if( $flag != true ) {
			
			$data = $this->dx_epb_nohtml_kses($data);
			
		} else {
			
			if( $limited == true ) {
				$data = wp_kses_post( $data );
			}
			
		}
		$data = stripslashes_deep($data);
		return $data;
	}
	
	/**
	 * Strip Html Tags 
	 * 
	 * It will sanitize text input (strip html tags, and escape characters)
	 * 
	 * @package DX Easy Page Builder
	 * @since 1.0.0
	 */
	public function dx_epb_nohtml_kses( $data = array() ) {
		
		if ( is_array( $data ) ) {
			
			$data = array_map( array( $this, 'dx_epb_nohtml_kses' ), $data );
			
		} elseif ( is_string( $data ) ) {
			
			$data = wp_filter_nohtml_kses( $data );
		}
		
		return $data;
	}	
	
}
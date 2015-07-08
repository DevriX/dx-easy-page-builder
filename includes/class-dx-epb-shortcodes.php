<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Testimonial Shortcode
function dx_testimonial( $atts ) {
	
	extract( shortcode_atts( array(
			'editor_id' 	=> '',
			'id' 			=> ''
	), $atts ) );
	
	global $post;
	
	if( empty( $editor_id ) ) {
		
		$postdata = get_post_meta( $post->ID, '_dx_epb_pagebuilder', true );
	} else {
		$data = get_post_meta( $post->ID, $editor_id, true );
		$postdata = $data[0];
	}
	
	if( ! empty( $postdata ) ) {
		
		foreach( $postdata as $dx_section ) {
			foreach ( $dx_section->column_array as $key => $value ) {
				
				if( $value->column_view == 'testimonial' && $value->column_indx == $id ) {
					$content = isset( $value->column_data ) ? $value->column_data : "";
					
					// Building the DOM tree for the testimonials
					if( ! empty( $content ) ) {
						$testimonial='';
						
						$dom = new DOMDocument();
						$dom->loadHTML( $content );
						
						$image = $dom->getElementsByTagName('img');
						$input = $dom->getElementsByTagName('input');
						
						foreach( $image as $tag ) {
					        $testimonial[][] = $tag->getAttribute('src');
					    }
					    
					    $j=0;
					    $k=0;
					    
					    foreach( $input as $tag ) {
					    	
					    		if( $tag->getAttribute( 'checked' ) ) {
						        	$testimonial[$k][] = 'Yes';
						        }
						        else {
						        	$testimonial[$k][] = 'No';
						        }
						        $k++;
					    }
					    
					    $finder = new DomXPath( $dom );
					    
					    $div = $finder->query('//*[@class="dx-testimonial-author-name"]');
					    $k=0;
					    
					    foreach( $div as $tag ) {
					    	$testimonial[$k][] = $tag->nodeValue;
					    	$k++;
					    }
					    
					    $div = $finder->query('//*[@class="dx-testimonial-about-author"]');
					    $k=0;
					    foreach( $div as $tag ) {
					    	$testimonial[$k][] = $tag->nodeValue;
					    	$k++;
					    }
					    
					    $div = $finder->query('//*[@class="dx-testimonial-content"]');
					    $k=0;
					    foreach( $div as $tag ) {
					    	$testimonial[$k][] = $tag->nodeValue;
					    	$k++;
					    }
					    
						if( is_array( $testimonial ) && count( $testimonial[0])!=1 ) {
							foreach ( $testimonial as $key=>$value ) {
								
								if( $value[1] == 'Yes' ) {
									echo '<div class="testimonial">
										  <div class="testimonial-image-container">
										  	  <img src=' . $value[0] . '>
										  </div>
										  
										  <div class="testimonial-content-container">
										  	  <div class="testimonial-content">
										  		  <blockquote><span>' . $value[4] . '</span>
										  		  		<cite><span class="author-name">' . $value[2] . '</span> <span class="author-info">(' . $value[3] . ')</span></cite>
										  		  </blockquote>
										  	  </div>
										  </div>
									  </div>';
								}
							}
						}
					}
				}
			}
		}
	}
}
add_shortcode( 'dx_testimonial', 'dx_testimonial' );

// Contact Form Shortcode
function dx_contact_form( $atts ) {
	
	extract( shortcode_atts( array(
			'editor_id' 	=> '',
			'id' 			=> ''
	), $atts ) );
	
	global $post;
	
	if( empty( $editor_id ) ) {
		$postdata = get_post_meta( $post->ID, '_dx_epb_pagebuilder', true );
	} else {
		$data 	  = get_post_meta( $post->ID, $editor_id, true );
		$postdata = $data[0];
	}
	
	if( ! empty( $postdata ) ){
		foreach( $postdata as $dx_section ) {
			foreach ( $dx_section->column_array as $key => $value ) {
				if( $value->column_view == 'contact' && $value->column_indx == $id ) {
					echo isset( $value->column_data ) ? $value->column_data : "";
				}
			}
		}
	}
}
add_shortcode( 'dx_contact_form', 'dx_contact_form' );

// Blog Shortcode
function dx_blog() {
	// TODO: Fix the blog component
	echo "";
	// echo 'Hi, This is blog.';
}
add_shortcode( 'dx_blog', 'dx_blog' );

// Custom Shortcode
function dx_custom( $atts ) {
	
	extract( shortcode_atts( array(
			'id' 	=> ''
	), $atts ) );
	
	global $post;
	
	$postdata = get_post_meta( $post->ID, '_dx_epb_pagebuilder', true );
	
	if( ! empty( $postdata ) ) {
		foreach( $postdata as $dx_section ) {
			foreach ( $dx_section->column_array as $key => $value ) {
				if( $value->column_view=='custom_text' && $value->column_indx == $id ) {
?>
					<div <?php if( ! empty( $value->column_class ) ) echo "class=" . $value->column_class . " "; ?><?php if( ! empty( $value->column_padding ) || ! empty( $value->column_background ) || ! empty( $value->column_boder ) ) { echo 'style="'; ?><?php if( ! empty( $value->column_padding ) ) echo "padding:" . $value->column_padding . $value->column_padding_type . ";"; ?><?php if( ! empty( $value->column_background ) ) echo "background:" . $value->column_background.";"; ?><?php if(!empty($value->column_boder)) echo "border:".$value->column_boder.";"; ?><?php echo '"';} ?>>
<?php
					echo isset( $value->column_data ) ? do_shortcode( $value->column_data ) : "";
					echo '</div>';
				}
			}
		}
	}
}
add_shortcode( 'dx_custom', 'dx_custom' );

// Textarea Shortcode
function dx_textarea( $atts ) {
	
	extract( shortcode_atts( array(
			'editor_id' 	=> '',
			'id' 			=> ''
	), $atts ) );
	
	global $post;
	
	if( empty( $editor_id ) ) {
		$postdata = get_post_meta( $post->ID, '_dx_epb_pagebuilder', true );
	} else {
		$data 	  = get_post_meta( $post->ID, $editor_id, true );
		$postdata = $data[0];
	}
	
	if( ! empty( $postdata ) ) {
		foreach( $postdata as $dx_section ) {
			foreach ( $dx_section->column_array as $key => $value ) {
				if( $value->column_view == 'custom_textarea' && $value->column_indx == $id ) {
					echo isset( $value->column_data ) ? do_shortcode( $value->column_data ) : "";
				}
			}
		}
	}
}
add_shortcode( 'dx_textarea', 'dx_textarea' );

// Alert Shortcode
function dx_alert( $atts ) {
	extract( shortcode_atts( array(
			'editor_id' 	=> '',
			'id' 			=> ''
	), $atts ) );
	
	global $post;
	
	if( empty( $editor_id ) ) {
		$postdata = get_post_meta( $post->ID, '_dx_epb_pagebuilder', true );
	} else {
		$data 	  = get_post_meta( $post->ID, $editor_id, true );
		$postdata = $data[0];
	}
	
	if( ! empty( $postdata ) ) {
		foreach( $postdata as $dx_section ) {
			foreach ( $dx_section->column_array as $key => $value ) {
				if( $value->column_view == 'alert' && $value->column_indx == $id ) {
					$column_data = isset( $value->column_data ) ? $value->column_data : "";
					
					if( $value->column_alert == 'On Page Load' ) {
						echo '<script>alert("'.$column_data.'")</script>';
					}
					else if( isset( $value->column_alert_ids ) ) {
						$id_array = explode( " ", $value->column_alert_ids );
						echo '<script>';
						foreach ( $id_array as $key ) {
							echo 'jQuery(document).ready(function($) {
									$(document).find("#'.$key.'").click(function() {
										alert("'.$column_data.'");
									});
							});';
						}
						echo '</script>';
					}
				}
			}
		}
	}
}
add_shortcode( 'dx_alert', 'dx_alert' );

// Article Shortcode
function dx_article( $atts ) {
	
	extract( shortcode_atts( array(
			'editor_id' 	=> '',
			'id' 			=> ''
	), $atts ) );
	
	global $post;
	
	if( empty( $editor_id ) ) {
		$postdata = get_post_meta( $post->ID, '_dx_epb_pagebuilder', true );
	} else {
		$data 	  = get_post_meta( $post->ID, $editor_id, true );
		$postdata = $data[0];
	}
	
	if( ! empty( $postdata ) ) {
		foreach( $postdata as $dx_section ) {
			foreach ( $dx_section->column_array as $key => $value ) {
				if( $value->column_view == 'article' && $value->column_indx == $id ) {
					$article_id = isset( $value->column_data ) ? $value->column_data : "";
					if( ! empty( $article_id ) ) {
						$temp = $post;
						$post = get_post( $article_id );
						setup_postdata( $post );
						
						echo '<h1>'.$post->post_title.'</h1>';
						echo get_the_excerpt();
						
						wp_reset_postdata();
						$post = $temp;
					}
				}
			}
		}
	}
}
add_shortcode( 'dx_article', 'dx_article' );

/**
 * Wrapper Section
 * Shortcode Usage:
 * @param unknown $atts
 * @param string $content
 */
function dx_section_wrapper( $atts, $content = '' ){
extract( shortcode_atts( array(
			'section_name' 		=> '',
			'section_class' 	=> '',
		), $atts ));
ob_start();
?>
<section class="fullwidth<?php if( ! empty( $section_class ) ) {echo " " . $section_class; } ?>" data-name="<?php echo $section_name; ?>">
	<div class="row">
		<?php echo do_shortcode( $content ); ?>
	</div>
</section>
<?php $content = ob_get_clean();
	  return $content;
}
add_shortcode( 'dx_section','dx_section_wrapper' );

/**
 * Row Column
 * Shortcode Usage:
 * @param unknown $atts
 * @param string $content
 */
function dx_column_html( $atts, $content = '' ) {
extract( shortcode_atts( array(
			'column_name' 	=> '',
			'column_size' 	=> '',
			'column_view' 	=> '',
			'column_class'	=> ''
		), $atts ) );
ob_start();
?>
<div class="medium-<?php echo $column_size; ?> columns<?php if( ! empty( $column_class ) ) echo " ".$column_class; ?>" data-clname="<?php echo $column_name; ?>" data-view="<?php echo $column_view; ?>"><?php echo do_shortcode( $content ); ?></div>
<?php $content = ob_get_clean();
	  return $content;
}
add_shortcode( 'dx_row','dx_column_html' );
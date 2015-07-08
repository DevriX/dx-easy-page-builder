<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * dxeasypb Setting Welcome Page
 *
 * Handle dxeasypb Setting Welcome
 * 
 * @package DX Easy Page Builder
 * @since 1.0.0
 */
?>
<div class="wrap">
	<div class="dx-epb-welcome">
		<?php 
		$welcome = apply_filters('dx_epb_welcome_message', false);
		if( !empty($welcome) ){
			echo $welcome;
		}else{
			echo '<h2>Welcome to Dx Easy Page Builder</h2>
				  <h4>Have a Good Day!</h4>';
		}
		?>
	</div>
</div>
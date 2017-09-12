<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $pinnacle; 
?>

<div class="sliderclass">
<?php if( function_exists('putRevSlider') ) {
		if(!empty($pinnacle['rev_slider_shop'])){
			putRevSlider( $pinnacle['rev_slider_shop'] );
		}
	} ?>
</div><!--sliderclass-->
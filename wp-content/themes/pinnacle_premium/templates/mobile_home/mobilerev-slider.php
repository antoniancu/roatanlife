<?php  
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $pinnacle; 
?>
<div class="sliderclass">
<?php  if( function_exists('putRevSlider') ) {
		putRevSlider( $pinnacle['mobile_rev_slider'] ); 
	}
	if(isset($pinnacle['mobile_slider_arrow']) && $pinnacle['mobile_slider_arrow'] == 1) {
        echo '<div class="kad_fullslider_arrow"><a href="#kt-slideto"><i class="kt-icon-arrow-down"></i></a></div>';
    }?>
</div><!--sliderclass-->
<div id="kt-slideto"></div>
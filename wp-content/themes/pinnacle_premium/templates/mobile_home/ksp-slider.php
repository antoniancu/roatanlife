<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $pinnacle; 

?>
<div class="sliderclass ktslider_home_hidetop">
<?php echo do_shortcode( '[kadence_slider_pro id="'.$pinnacle['mobile_ksp_slider'].'"]' ); 
		if(isset($pinnacle['mobile_slider_arrow']) && $pinnacle['mobile_slider_arrow'] == 1) {
        	echo '<div class="kad_fullslider_arrow"><a href="#kt-slideto"><i class="kt-icon-arrow-down"></i></a></div>';
      	}
      	?>
</div><!--sliderclass-->
<div id="kt-slideto"></div>
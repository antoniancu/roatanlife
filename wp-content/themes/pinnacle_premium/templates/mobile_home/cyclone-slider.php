<?php  
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
global $pinnacle; 
?>
<div class="sliderclass cyclone_mhome_slider">
<?php echo do_shortcode( $pinnacle['mobile_cyclone_slider'] ); 
		if(isset($pinnacle['mobile_slider_arrow']) && $pinnacle['mobile_slider_arrow'] == 1) {
        	echo '<div class="kad_fullslider_arrow"><a href="#kt-slideto"><i class="kt-icon-arrow-down"></i></a></div>';
      	}
      	?>
</div><!--sliderclass-->
<div id="kt-slideto"></div>
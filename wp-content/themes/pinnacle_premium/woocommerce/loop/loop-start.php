 <?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
global $woocommerce, $woocommerce_loop, $pinnacle;
if(isset($pinnacle['pinnacle_animate_in']) && $pinnacle['pinnacle_animate_in'] == 1) {
	$animate = 1;
} else {
	$animate = 0;
}
if(isset($pinnacle['product_shop_style'])) {
	$product_shop_style = $pinnacle['product_shop_style'];
} else {
	$product_shop_style = 'kad-simple-shop';
}
if(isset($pinnacle['product_fitrows']) && $pinnacle['product_fitrows'] == 1) {
	$style = 'fitRows';
} else {
	$style = 'masonry';
}
if(isset($pinnacle['product_img_resize']) && $pinnacle['product_img_resize'] == 0) { 
	$isoclass = 'init-isotope';
} else { 
	$isoclass = 'init-isotope-intrinsic';
}
if(isset($pinnacle['infinitescroll']) && $pinnacle['infinitescroll'] == 1) {
	$infinit = 'data-nextselector=".woocommerce-pagination a.next" data-navselector=".woocommerce-pagination" data-itemselector=".kad_product" data-itemloadselector=".kad_product_fade_in" data-infiniteloader="'.get_template_directory_uri() . '/assets/img/loader.gif"';
	$scrollclass = 'init-infinit';
} else {
	$infinit = '';
	$scrollclass = '';
}
 if ( empty( $woocommerce_loop['columns'] ) ) $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
 $woocommerce_loop['rand'] = $woocommerce_loop['columns'];

  if(kadence_display_sidebar()) {
            $columns = "shopcolumn".$woocommerce_loop['columns']." shopsidebarwidth"; 
      } else {
			$columns = "shopcolumn".$woocommerce_loop['columns']." shopfullwidth"; 
      }
      if(is_cart()) {
      	$columns = "shopcolumn-cart".$woocommerce_loop['columns']." shopfullwidth";
      }
?>
<div id="product_wrapper<?php echo esc_attr($woocommerce_loop['rand']);?>" class="products kad_product_wrapper <?php echo esc_attr($isoclass); ?> <?php echo esc_attr($scrollclass); ?> rowtight <?php echo esc_attr($columns); ?> <?php echo esc_attr($product_shop_style); ?>" <?php echo $infinit;?> data-fade-in="<?php echo esc_attr($animate);?>" data-iso-selector=".kad_product" data-iso-style="<?php echo esc_attr($style);?>" data-iso-filter="true">
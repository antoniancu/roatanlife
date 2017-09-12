<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce, $woocommerce_loop, $pinnacle;
if(!empty($pinnacle['related_item_column'])) {$product_related_column = $pinnacle['related_item_column'];} else {$product_related_column = '4';}
if(isset($pinnacle['product_shop_style'])) {$product_shop_style = $pinnacle['product_shop_style'];} else {$product_shop_style = 'kad-simple-shop';}
$woocommerce_loop['columns'] = $product_related_column;
						$rpc = array();
						if ($product_related_column == '2') {
							$rpc['sxl'] = 2; 
							$rpc['xl'] = 2; 
							$rpc['md'] = 2; 
							$rpc['sm'] = 2; 
							$rpc['xs'] = 1;
							$rpc['ss'] = 1; 
						} else if ($product_related_column == '3'){
							$rpc['sxl'] = 3; 
							$rpc['xl'] = 3; 
							$rpc['md'] = 3; 
							$rpc['sm'] = 3; 
							$rpc['xs'] = 2;
							$rpc['ss'] = 1; 
						} else if ($product_related_column == '6'){
							$rpc['sxl'] = 6; 
							$rpc['xl'] = 6; 
							$rpc['md'] = 6; 
							$rpc['sm'] = 4; 
							$rpc['xs'] = 3;
							$rpc['ss'] = 2; 
						} else if ($product_related_column == '5'){ 
							$rpc['sxl'] = 5; 
							$rpc['xl'] = 5; 
							$rpc['md'] = 5; 
							$rpc['sm'] = 4; 
							$rpc['xs'] = 3;
							$rpc['ss'] = 2; 
						} else {
							$rpc['sxl'] = 4; 
							$rpc['xl'] = 4; 
							$rpc['md'] = 4; 
							$rpc['sm'] = 3; 
							$rpc['xs'] = 2;
							$rpc['ss'] = 1; 
						} 

						$rpc = apply_filters('kt_upsell_products_columns', $rpc);

if ( version_compare( WC_VERSION, '3.0', '>' ) ) {
	$upsells = $product->get_upsell_ids();
} else {
	$upsells = $product->get_upsells();
}

if ( sizeof( $upsells ) === 0 ) {
	return;
}

$meta_query = $woocommerce->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => 8,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->get_id() ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

if(!empty($pinnacle['wc_upsell_products_text'])) {
	$upsell_text = $pinnacle['wc_upsell_products_text'];
} else {
	$upsell_text = __( 'You may also like&hellip;', 'pinnacle');
}

if ( $products->have_posts() ) : ?>

<div class="upsells products carousel_outerrim">
		<h3><?php echo $upsell_text; ?></h3>
	<div class="fredcarousel">
		<div id="carouselcontainer-upsell" class="rowtight">
			<div id="upsale-product-carousel" class="products initcaroufedsel caroufedselclass <?php echo esc_attr($product_shop_style); ?> clearfix" data-carousel-container="#carouselcontainer-upsell" data-carousel-transition="700" data-carousel-scroll="1" data-carousel-auto="true" data-carousel-speed="9000" data-carousel-id="upsaleproduct" data-carousel-sxl="<?php echo esc_attr($rpc['sxl']);?>" data-carousel-xl="<?php echo esc_attr($rpc['xl']);?>" data-carousel-md="<?php echo esc_attr($rpc['md']);?>" data-carousel-sm="<?php echo esc_attr($rpc['sm']);?>" data-carousel-xs="<?php echo esc_attr($rpc['xs']);?>" data-carousel-ss="<?php echo esc_attr($rpc['ss']);?>">

					<?php while ( $products->have_posts() ) : $products->the_post(); 

						wc_get_template_part( 'content', 'product' ); 

					 endwhile;  ?>

				</div>
			</div>
			<div class="clearfix"></div>
            <a id="prevport-upsaleproduct" class="prev_carousel kt-icon-arrow-left" href="#"></a>
			<a id="nextport-upsaleproduct" class="next_carousel kt-icon-arrow-right" href="#"></a>
		</div>
	</div>

<?php endif;

wp_reset_postdata();

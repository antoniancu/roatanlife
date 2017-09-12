<?php  
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

 global $pinnacle; 

	$product_title = $pinnacle['product_title'];
	if(!empty($product_title)) {
		$ptitle = $product_title;
	} else { 
		$ptitle = __('Featured Products', 'pinnacle'); 
	}
	if(!empty($pinnacle['home_product_feat_column'])) {
		$product_tcolumn = $pinnacle['home_product_feat_column'];
	} else {
		$product_tcolumn = '4';
	}
	
	$pc = array();
	if ($product_tcolumn == '2') {
			$pc['md'] = 2; 
			$pc['sm'] = 2; 
			$pc['xs'] = 1;
			$pc['ss'] = 1; 
	} else if ($product_tcolumn == '3'){
			$pc['md'] = 3; 
			$pc['sm'] = 3; 
			$pc['xs'] = 2;
			$pc['ss'] = 1; 
	} else if ($product_tcolumn == '6'){
			$pc['md'] = 6; 
			$pc['sm'] = 4; 
			$pc['xs'] = 3;
			$pc['ss'] = 2; 
	} else if ($product_tcolumn == '5'){ 
			$pc['md'] = 5; 
			$pc['sm'] = 4; 
			$pc['xs'] = 3;
			$pc['ss'] = 2; 
	} else {
			$pc['md'] = 4; 
			$pc['sm'] = 3; 
			$pc['xs'] = 2;
			$pc['ss'] = 1; 
	}
	$pc['sxl'] = $pc['md'];
	$pc['xl'] = $pc['md'];
	$pc = apply_filters('kt_home_featured_product_carousel_columns', $pc);
	
	if(!empty($pinnacle['home_product_count'])) {
		$hp_procount = $pinnacle['home_product_count'];
	} else {
		$hp_procount = '6';
	}
	if(isset($pinnacle['product_shop_style'])) {
		$product_shop_style = $pinnacle['product_shop_style'];
	} else {
		$product_shop_style = 'kad-simple-shop';
	}
	if(!empty($pinnacle['home_product_feat_speed'])) {
		$hp_featspeed = $pinnacle['home_product_feat_speed'].'000';
	} else {
		$hp_featspeed = '9000';
	} 
	if(isset($pinnacle['home_product_feat_scroll']) && $pinnacle['home_product_feat_scroll'] == 'all' ) {
		$hp_featscroll = '';
	} else {
		$hp_featscroll = '1';
	} ?>
	<div class="home-product home-margin carousel_outerrim home-padding kad-animation" data-animation="fade-in" data-delay="0">
		<div class="clearfix"><h3 class="hometitle"><?php echo $ptitle; ?></h3></div>
		<div class=" fredcarousel">
			<div id="hp_carouselcontainer" class="rowtight fadein-carousel">
				<div id="home-product-carousel" class="products initcaroufedsel caroufedselclass <?php echo esc_attr($product_shop_style); ?> clearfix" data-carousel-container="#hp_carouselcontainer" data-carousel-transition="700" data-carousel-scroll="<?php echo esc_attr($hp_featscroll); ?>" data-carousel-auto="true" data-carousel-speed="<?php echo esc_attr($hp_featspeed); ?>" data-carousel-id="product" data-carousel-sxl="<?php echo esc_attr($pc['sxl']);?>" data-carousel-xl="<?php echo esc_attr($pc['xl']);?>" data-carousel-md="<?php echo esc_attr($pc['md']);?>" data-carousel-sm="<?php echo esc_attr($pc['sm']);?>" data-carousel-xs="<?php echo esc_attr($pc['xs']);?>" data-carousel-ss="<?php echo esc_attr($pc['ss']);?>">
				<?php 
				global $woocommerce_loop;
				if ( version_compare( WC_VERSION, '3.0', '>' ) ) {
			        $meta_query  = WC()->query->get_meta_query();
					$tax_query   = WC()->query->get_tax_query();
					$tax_query[] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					);
					$query_args = array(
						'post_type'           => 'product',
						'post_status'         => 'publish',
						'ignore_sticky_posts' => 1,
						'posts_per_page'      => $hp_procount,
						'orderby'             => 'menu_order',
						'order'               => 'ASC',
						'meta_query'          => $meta_query,
						'tax_query'           => $tax_query,
					);
				} else {
					$meta_query   = WC()->query->get_meta_query();
					$meta_query[] = array(
						'key'   => '_featured',
						'value' => 'yes'
					);

					$query_args = array(
						'post_type'           => 'product',
						'post_status'         => 'publish',
						'ignore_sticky_posts' => 1,
						'posts_per_page'      => $hp_procount,
						'orderby'             => 'menu_order',
						'order'               => 'ASC',
						'meta_query'          => $meta_query
					);
				}
				$loop = new WP_Query($query_args);
				$woocommerce_loop['columns'] = $product_tcolumn;

				if ( $loop ) : 
					while ( $loop->have_posts() ) : $loop->the_post(); 
						wc_get_template_part( 'content', 'product' ); 
					endwhile; // end of the loop. 

				endif; 

                wp_reset_postdata();?>
				</div>
			</div>
			<div class="clearfix"></div>
            <a id="prevport-product" class="prev_carousel kt-icon-arrow-left" href="#"></a>
			<a id="nextport-product" class="next_carousel kt-icon-arrow-right" href="#"></a>
		</div>
	</div>
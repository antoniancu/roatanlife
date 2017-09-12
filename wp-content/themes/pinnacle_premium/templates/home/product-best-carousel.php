<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

	global $pinnacle; 

	if(!empty($pinnacle['product_best_title'])) {
		$product_best_title = $pinnacle['product_best_title'];
	} else {
		$product_best_title = __('Best Selling Products', 'pinnacle');
	}
	if(!empty($pinnacle['home_product_best_column'])) {
		$product_tcolumn = $pinnacle['home_product_best_column'];
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
	$pc = apply_filters('kt_home_best_product_carousel_columns', $pc);

	if(!empty($pinnacle['home_product_best_count'])) {
		$hp_probcount = $pinnacle['home_product_best_count'];
	} else {
		$hp_probcount = '6';
	}
	if(!empty($pinnacle['home_product_best_speed'])) {
		$hp_bestspeed = $pinnacle['home_product_best_speed'].'000';
	} else {
		$hp_bestspeed = '9000';
	}
	if(isset($pinnacle['product_shop_style'])) {
		$product_shop_style = $pinnacle['product_shop_style'];
	} else {
		$product_shop_style = 'kad-simple-shop';
	}
	if(isset($pinnacle['home_product_best_scroll']) && $pinnacle['home_product_best_scroll'] == 'all' ) {
		$hp_bestscroll = '';
	} else {
		$hp_bestscroll = '1';
	}?>
	<div class="home-product home-margin carousel_outerrim home-padding kad-animation" data-animation="fade-in" data-delay="0">
		<div class="clearfix"><h3 class="hometitle"><?php echo $product_best_title; ?></h3></div>
		<div class="fredcarousel">
			<div id="hpb_carouselcontainer" class="rowtight fadein-carousel">
				<div id="home-product-best-carousel" class="products initcaroufedsel caroufedselclass <?php echo esc_attr($product_shop_style); ?>  clearfix" data-carousel-container="#hpb_carouselcontainer" data-carousel-transition="700" data-carousel-scroll="<?php echo esc_attr($hp_bestscroll); ?>" data-carousel-auto="true" data-carousel-speed="<?php echo esc_attr($hp_bestspeed); ?>" data-carousel-id="product_best" data-carousel-sxl="<?php echo esc_attr($pc['sxl']);?>" data-carousel-xl="<?php echo esc_attr($pc['xl']);?>" data-carousel-md="<?php echo esc_attr($pc['md']);?>" data-carousel-sm="<?php echo esc_attr($pc['sm']);?>" data-carousel-xs="<?php echo esc_attr($pc['xs']);?>" data-carousel-ss="<?php echo esc_attr($pc['ss']);?>">
    			<?php global $woocommerce_loop;
    				$temp = $wp_query; 
			  		$wp_query = null; 
			  		$wp_query = new WP_Query();
			  		$wp_query->query(array(
						'post_type' => 'product',
						'meta_key'=> 'total_sales',
			            'orderby' => 'meta_value_num',
						'post_status' => 'publish',
						'posts_per_page' => $hp_probcount
						)
			  		);
					$woocommerce_loop['columns'] = $product_tcolumn;
					if ( $wp_query ) :  while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
						wc_get_template_part( 'content', 'product' ); 
					endwhile;
					
					endif; 
                  	$wp_query = null; 
                  	$wp_query = $temp;  // Reset
                	wp_reset_query(); ?>
				</div>
			</div>
			<div class="clearfix"></div>
	        <a id="prevport-product_best" class="prev_carousel kt-icon-arrow-left" href="#"></a>
			<a id="nextport-product_best" class="next_carousel kt-icon-arrow-right" href="#"></a>
		</div>
	</div>
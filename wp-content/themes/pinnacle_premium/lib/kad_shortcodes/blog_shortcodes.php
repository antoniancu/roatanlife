<?php 
//Shortcode for Blog Posts
function kad_blog_shortcode_function( $atts, $content) {
	extract(shortcode_atts(array(
		'id' => (rand(10,1000)),
		'orderby' => 'date',
		'type' =>'normal',
		'speed' =>'7000',
		'columns' =>'3',
		'id' => (rand(10,100)),
		'height' =>'400',
		'width' =>'',
		'offset' =>null,
		'cat' => '',
		'tag' => '',
		'ids' => '',
		'fullwidth' => 'false',
		'items' => '4'
), $atts));
	if($orderby == 'menu_order') {$order = 'ASC';} else {$order = 'DESC';} 
	if(empty($cat)) {$cat = '';}

	if($type == 'slider') {
ob_start(); ?>
	<div class="sliderclass">
 		<?php if(kadence_display_sidebar()) {if(!empty($width)) {$slidewidth = $width;} else {$slidewidth = 848;}} else {if(!empty($width)) {$slidewidth = $width;} else {$slidewidth = 1140;}} ?>
        <div class="flexslider kt-flexslider loading" style="max-width:<?php echo esc_attr($slidewidth);?>px; margin-left: auto; margin-right:auto;" data-flex-speed="<?php echo esc_attr($speed); ?>" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
        <ul class="slides">
    		<?php 
    			$wp_query = null; 
				$wp_query = new WP_Query();
				$wp_query->query(
					array(
						'orderby' => $orderby,
						'order' => $order,
						'offset' => $offset,
						'post_type' => 'post',
						'p' => $ids,
						'category_name'=>$cat,
						'posts_per_page' => $items, 
					)
				);
				if ( $wp_query ) :  while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
                  	global $post;
                  		if (has_post_thumbnail( $post->ID ) ) {
                  			$image_id = get_post_thumbnail_id( $post->ID );
                  			$image_src = wp_get_attachment_image_src( $image_id, 'full' ); 
                            $image = aq_resize($$image_src[0], $slidewidth, $height, true);
                            if(empty($image)) { $image = $thumbnailURL; } ?>
                    	<li> 
                        	<a href="<?php the_permalink(); ?>">
                          		<img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>" />
                            	<div class="flex-caption">
                            		<div class="captiontitle headerfont">
                            			<?php the_title(); ?>
                            		</div>
                           		</div> 
                        </a>
                    </li>
                  <?php } endwhile; else: ?>
            <li class="error-not-found"><?php _e('Sorry, no blog entries found.', 'pinnacle'); ?></li>
          <?php endif; ?>
        <?php $wp_query = null; // Reset ?>
        <?php wp_reset_query(); ?>
        </ul>
      </div> <!--Flex Slides-->
  </div> <!--Slider Class-->
<?php  	$output = ob_get_contents();
		ob_end_clean();
			return $output;
	}  elseif ($type == "grid") {
	
		ob_start(); 

		global $postcolumn, $blog_fullwidth, $pinnacle; 
			if(isset($pinnacle['blog_grid_display_height']) && $pinnacle['blog_grid_display_height'] == 1) {
   				$matchheight = 1;
   			} else {
   				$matchheight = 'false';
   			}
			if ($columns == '2') {
				$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; 
				$postcolumn = '2';
			} else if ($columns == '3'){ 
				$itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
				$postcolumn = '3';
			} else if ($columns == '5'){
				$itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6'; 
				$postcolumn = '5';
			} else if ($columns == '6'){
				$itemsize = 'tcol-md-2 tcol-sm-25 tcol-xs-3 tcol-ss-6'; 
				$postcolumn = '6';
			} else {
				$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
				$postcolumn = '4';
			} ?>
			<div id="kad-blog-grid-<?php echo esc_attr($id);?>" class="rowtight reinit-isotope init-isotope kad-blog-grid" data-iso-match-height="<?php echo esc_attr($matchheight);?>" data-fade-in="<?php echo esc_attr(kad_animate());?>" data-iso-selector=".b_item" data-iso-style="masonry">
					<?php 
					$wp_query = null; 
					$wp_query = new WP_Query();
					$wp_query->query(
						array(
							'orderby' => $orderby,
							'order' => $order,
							'offset' => $offset,
							'post_type' => 'post',
							'p' => $ids,
							'category_name'=>$cat,
							'posts_per_page' => $items, 
						)
					);
					if ( $wp_query ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
						<div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
							<?php get_template_part('templates/content', 'post-grid');?>
						</div>
                    <?php endwhile; else: ?>
						<li class="error-not-found"><?php _e('Sorry, no blog entries found.', 'pinnacle');?></li>
					<?php endif; ?>
				<?php $wp_query = null; wp_reset_query(); ?>
		</div> <!-- postlist -->
		<?php  	
		$output = ob_get_contents();
	ob_end_clean();
	
	return $output;

	} else if ($type == "photo") {
	
	ob_start(); 

	global $postcolumn, $blog_fullwidth; 
	if($fullwidth == "true"){
		$blog_fullwidth = true;
		if ($columns == '2') {
			$itemsize = 'tcol-sxl-4 tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; 
			$postcolumn = '2'; 
		} else if ($columns == '3'){
			$itemsize = 'tcol-sxl-3 tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12';
			$postcolumn = '3'; 
		} else {
			$itemsize = 'tcol-sxl-25 tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
			$postcolumn = '4';
		}
	} else {
		$blog_fullwidth = false;
		if ($columns == '2') {
			$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; 
			$postcolumn = '2'; 
		} else if ($columns == '3'){
			$itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12';
			$postcolumn = '3'; 
		} else {
			$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
			$postcolumn = '4';
		}
	} ?>
		<div id="kad-blog-photo-grid" class="rowtight reinit-isotope init-isotope-intrinsic" data-fade-in="<?php echo esc_attr(kad_animate());?>" data-iso-selector=".b_item" data-iso-style="masonry">
					<?php 
					$wp_query = null; 
					$wp_query = new WP_Query();
					$wp_query->query(
						array(
							'orderby' => $orderby,
							'order' => $order,
							'offset' => $offset,
							'post_type' => 'post',
							'p' => $ids,
							'category_name'=>$cat,
							'posts_per_page' => $items, 
							)
						);
					if ( $wp_query ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
	                    <div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
	                        <?php  get_template_part('templates/content', 'post-photo-grid'); ?>
	            		</div>
                    <?php endwhile; else: ?>
						<li class="error-not-found"><?php _e('Sorry, no blog entries found.', 'pinnacle');?></li>
					<?php endif; ?>
				<?php $wp_query = null; wp_reset_query(); ?>
		</div> <!-- postlist -->
	<?php  	$output = ob_get_contents();
			ob_end_clean();
				return $output;

	} else if ($type == "full") {
ob_start(); ?>
		<?php if(kadence_display_sidebar()) {$display_sidebar = true; $fullclass = '';} else {$display_sidebar = false; $fullclass = 'fullwidth';} ?>
		<div class="single-article fullpost <?php echo esc_attr($fullclass);?>">
					<?php 
					$wp_query = null; 
					$wp_query = new WP_Query();
					$wp_query->query(array(
						'orderby' => $orderby,
							'order' => $order,
							'offset' => $offset,
							'post_type' => 'post',
							'p' => $ids,
							'category_name'=>$cat,
							'posts_per_page' => $items, 
						)
					);
					if ( $wp_query ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
							if($display_sidebar){
					            global $kt_feat_width; 
					            $kt_feat_width = 848;
					        } else {
					            global $kt_feat_width; 
					            $kt_feat_width = 1170;
					        }
								get_template_part('templates/content', 'fullpost'); 
                    endwhile; else: ?>
						<li class="error-not-found"><?php _e('Sorry, no blog entries found.', 'pinnacle');?></li>
					<?php endif; ?>
				<?php $wp_query = null; wp_reset_query(); ?>
		</div> <!-- postlist -->
	<?php  	$output = ob_get_contents();
			ob_end_clean();
				return $output;
	} else {
ob_start(); ?>
		<?php if(kadence_display_sidebar()) {$display_sidebar = true; $fullclass = '';} else {$display_sidebar = false; $fullclass = 'fullwidth';} ?>
		<div class="postlist <?php echo esc_attr($fullclass);?>">
					<?php 
					$wp_query = null; 
					$wp_query = new WP_Query();
					$wp_query->query(array('category_name'=>$cat,'offset' => $offset,'posts_per_page' => $items));
					if ( $wp_query ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
					if($display_sidebar){
								global $kt_post_with_sidebar; 
                				$kt_post_with_sidebar = true;
					        } else {
					            global $kt_feat_width; 
					            $kt_post_with_sidebar = false;
					        }
						 	get_template_part('templates/content', get_post_format()); 
                    endwhile; else: ?>
						<li class="error-not-found"><?php _e('Sorry, no blog entries found.', 'pinnacle');?></li>
					<?php endif; ?>
				<?php $wp_query = null; wp_reset_query(); ?>
		</div> <!-- postlist -->
	<?php  	$output = ob_get_contents();
			ob_end_clean();
				return $output;
	}
}
<?php
/*
Template Name: Staff Grid
*/

	get_header(); 

	get_template_part('templates/page', 'header'); ?>	
    <div id="content" class="container">
   		<div class="row">
      <div class="main <?php echo kadence_main_class(); ?> stafflist" role="main">
			<div class="entry-content" itemprop="mainContentOfPage">
					<?php get_template_part('templates/content', 'page'); ?>
		</div>
      		<?php global $post, $pinnacle, $kt_staff_loop; 
      		if(isset($pinnacle['pinnacle_animate_in']) && $pinnacle['pinnacle_animate_in'] == 1) {$animate = 1;} else {$animate = 0;}
      			$staff_category 		= get_post_meta( $post->ID, '_kad_staff_type', true ); 
			   	$staff_items 			= get_post_meta( $post->ID, '_kad_staff_items', true );
			   	$staff_column 			= get_post_meta( $post->ID, '_kad_staff_columns', true );
			   	$staff_masonry 			= get_post_meta( $post->ID, '_kad_staff_masonry', true );
			   	$staff_limit_content 	= get_post_meta( $post->ID, '_kad_staff_wordlimit', true );
			   	$staff_single_link 		= get_post_meta( $post->ID, '_kad_staff_single_link', true );
			   	$staff_ratio 			= get_post_meta( $post->ID, '_kad_staff_img_ratio', true );
			   	$staff_filter 			= get_post_meta( $post->ID, '_kad_staff_filter', true ); 
		   		
		   		if($staff_category == '-1' || empty($staff_category)) { 
		   			$staff_cat_slug = ''; $staff_cat_ID = ''; 
		   		} else {
					$staff_cat = get_term_by ('id',$staff_category,'staff-group' );
					$staff_cat_slug = $staff_cat -> slug;
				}
				if($staff_items == 'all') { 
					$staff_items = '-1'; 
				}
                if ($staff_column == '2') {
                	$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $slidewidth = 560;
                } else if ($staff_column == '3'){ 
                	$itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 400;
            	} else if ($staff_column == '6'){ 
            		$itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 270;
            	} else if ($staff_column == '5'){
            		$itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 270;
            	} else {
            		$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 370;
            	} 

            	if($staff_ratio == 'portrait') {
							$temppimgheight = $slidewidth * 1.35;
							$slideheight = floor($temppimgheight);
				} else if($staff_ratio == 'landscape') {
							$temppimgheight = $slidewidth / 1.35;
							$slideheight = floor($temppimgheight);
				} else if($staff_ratio == 'widelandscape') {
							$temppimgheight = $slidewidth / 2;
							$slideheight = floor($temppimgheight);
				} else {
							$slideheight = $slidewidth;
				}
                if ($staff_masonry == "true") {$slideheight = null;}
                $kt_staff_loop = array(
                 	'full_content' => $staff_limit_content,
                 	'single_link' => $staff_single_link,
                 	'slidewidth' => $slidewidth,
                 	'slideheight' => $slideheight,
                 	);
                if ($staff_filter == 'yes') {
	  				$sft = "true"; 
	  			?>
      			<section id="options" class="kt-filter-options clearfix">
				<?php 	if(!empty($pinnacle['filter_all_text'])) {
						$alltext = $pinnacle['filter_all_text'];
					} else {
						$alltext = __('All', 'pinnacle');
					}
					if(!empty($pinnacle['portfolio_filter_text'])) {
						$stafffiltertext = $pinnacle['portfolio_filter_text'];
					} else {
						$stafffiltertext = __('Filter Staff', 'pinnacle');
					}
					$termtypes  = array( 'child_of' => $staff_cat_ID,);
					$categories = get_terms('staff-group', $termtypes);
					$count      = count($categories);
						echo '<a class="filter-trigger headerfont" data-toggle="collapse" data-target=".filter-collapse"><i class="icon-tags"></i> '.$stafffiltertext.'</a>';
						echo '<ul id="filters" class="clearfix option-set filter-collapse">';
						echo '<li class="postclass"><a href="#" data-filter="*" title="All" class="selected"><h5>'.$alltext.'</h5><div class="arrow-up"></div></a></li>';
						 if ( $count > 0 ){
							foreach ($categories as $category){ 
							$termname = strtolower($category->name);
							$termname = preg_replace("/[^a-zA-Z 0-9]+/", " ", $termname);
							$termname = str_replace(' ', '-', $termname);
							echo '<li class="postclass"><a href="#" data-filter=".'.esc_attr($termname).'" title="" rel="'.esc_attr($termname).'"><h5>'.esc_html($category->name).'</h5><div class="arrow-up"></div></a></li>';
								}
				 		}
				 		echo "</ul>"; ?>
				</section>
            <?php } else {
            	$sft = "true";
            } ?>
               <div id="staffwrapper" class="rowtight init-isotope" data-fade-in="<?php echo esc_attr($animate);?>" data-iso-selector=".s_item" data-iso-style="masonry" data-iso-filter="<?php echo esc_attr($sft);?>"> 
				<?php 
				$temp = $wp_query; 
				$wp_query = null; 
				$wp_query = new WP_Query();
				$wp_query->query(array(
					'paged' => $paged,
					'post_type' => 'staff',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'staff-group'=>$staff_cat_slug,
					'posts_per_page' => $staff_items
					)
				);
				if ( $wp_query ) : 	 
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
					$terms = get_the_terms( $post->ID, 'staff-group' );
						if ( $terms && ! is_wp_error( $terms ) ) : 
							$links = array();
							foreach ( $terms as $term ) { $links[] = $term->name;}
							$links = preg_replace("/[^a-zA-Z 0-9]+/", " ", $links);
							$links = str_replace(' ', '-', $links);	
							$tax = join( " ", $links );		
						else :	
							$tax = '';	
						endif; ?>
				<div class="<?php echo esc_attr($itemsize);?>  <?php echo strtolower($tax); ?> s_item">
						<?php 
						do_action('kadence_staff_loop_start');
							get_template_part('templates/content', 'loop-staff'); 
						do_action('kadence_staff_loop_end');
						?>
                </div>
					<?php endwhile; else: ?>
					 
					<li class="error-not-found"><?php _e('Sorry, no staff entries found.', 'pinnacle');?></li>
						
				<?php endif; ?>
                </div> <!--portfoliowrapper-->
                    <?php 
                    if ($wp_query->max_num_pages > 1) : 
                        if(function_exists('kad_wp_pagenavi')) {
                            kad_wp_pagenavi(); 
                       	} 
                    endif; 
                    $wp_query = null; 
                    $wp_query = $temp;
                    wp_reset_query(); 

                    do_action('kadence_page_footer'); ?>
</div><!-- /.main -->
  <?php get_footer(); ?>
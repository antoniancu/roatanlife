<?php 
//Shortcode for staff Posts
function kad_staff_shortcode_function( $atts, $content) {
	extract(shortcode_atts(array(
		'orderby' => 'menu_order',
		'cat' => '',
		'columns' => '3',
		'limit_content' => 'true',
		'link' => 'true',
		'masonry' => false,
		'filter' => 'false',
		'ratio' => 'square',
		'offset' => null,
		'id' => (rand(10,100)),
		'items' => '4'
), $atts));
	if($orderby == 'menu_order') {$order = 'ASC';} else {$order = 'DESC';} 
	if(empty($cat)) {
		$cat = '';
		$staff_cat_ID = '';
	} else {
		$staff_cat 		= get_term_by ('slug',$cat,'staff-group' );
		$staff_cat_ID 	= $staff_cat -> term_id;
	}
		if ($columns == '2') {$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $slidewidth = 560;} 
		                   else if ($columns == '3'){ $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 400;} 
		                   else if ($columns == '6'){ $itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 270;} 
		                   else if ($columns == '5'){ $itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 270;} 
		                   else {$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 370;} 
		            if($ratio == 'portrait') {
									$temppimgheight = $slidewidth * 1.35;
									$slideheight = floor($temppimgheight);
						} else if($ratio == 'landscape') {
									$temppimgheight = $slidewidth / 1.35;
									$slideheight = floor($temppimgheight);
						} else if($ratio == 'widelandscape') {
									$temppimgheight = $slidewidth / 2;
									$slideheight = floor($temppimgheight);
						} else {
									$slideheight = $slidewidth;
						}
                   if ($masonry) {$slideheight = null; }
					global $pinnacle, $kt_staff_loop; 
					if(isset($pinnacle['pinnacle_animate_in']) && $pinnacle['pinnacle_animate_in'] == 1) {$animate = 1;} else {$animate = 0;}
					if($limit_content == 'true') {
						$full_content = 'false';
					} else {
						$full_content = 'true';
					}
					$kt_staff_loop = array(
	                 	'full_content' => $full_content,
	                 	'single_link' => $link,
	                 	'slidewidth' => $slidewidth,
	                 	'slideheight' => $slideheight,
                 	);
ob_start(); ?>
			<div class="staff-shortcode">

			<?php if ($filter == 'true') { 
				$sft = "true"; ?>
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
			<?php }  else {
				$sft = "false";
				}?>

			<div id="staffwrapper-<?php echo esc_attr($id);?>" class="rowtight init-isotope reinit-isotope" data-fade-in="<?php echo esc_attr($animate);?>" data-iso-selector=".s_item" data-iso-filter="<?php echo esc_attr($sft);?>" data-iso-style="masonry"> 
            <?php $wp_query = null; 
				  $wp_query = new WP_Query();
				  $wp_query->query(array(
				  	'orderby' => $orderby,
				  	'order' => $order,
				  	'offset' => $offset,
				  	'post_type' => 'staff',
				  	'staff-group'=>$cat,
				  	'posts_per_page' => $items
				  	)
				  );
				  $count =0;
					if ( $wp_query ) : 
					while ( $wp_query->have_posts() ) : $wp_query->the_post(); 

					global $post; 
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
					<div class="<?php echo esc_attr($itemsize);?> <?php echo strtolower($tax); ?> s_item">
                	<?php 
						do_action('kadence_staff_loop_start');
							get_template_part('templates/content', 'loop-staff'); 
						do_action('kadence_staff_loop_end');
						?>
                </div>
					<?php endwhile; else: ?>
					<li class="error-not-found"><?php _e('Sorry, no staff entries found.', 'pinnacle');?></li>
				<?php endif; ?>
                </div> <!-- staffwrapper -->
                    <?php $wp_query = null; wp_reset_query(); ?>
		</div><!-- /.home-staff -->		
	<?php  $output = ob_get_contents();
		ob_end_clean();
	return $output;
}
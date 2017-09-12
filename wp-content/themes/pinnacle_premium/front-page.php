<?php get_header(); 
	global $pinnacle; 
		$mobile_detect = false;
			if(isset($pinnacle['mobile_switch']) && $pinnacle['mobile_switch']  == '1') {
				$mobile_slider = true;
				$detect = new Mobile_Detect_pinnacle; 
				if(isset($pinnacle['mobile_tablet_show']) && $pinnacle['mobile_tablet_show']  == '1') {
					if($detect->isMobile()) {
						$mobile_detect = true;
					} else {
						$mobile_detect = false;
					}
				} else {
					if($detect->isMobile() && !$detect->isTablet()) {
						$mobile_detect = true;
					} else {
						$mobile_detect = false;
					}
				}
			} else {
				$mobile_slider = false;
			}
			if(($mobile_slider == true) && ($mobile_detect == true)){
		 		$m_home_header = $pinnacle['choose_mobile_slider'];
					if ($m_home_header == "rev") {
					get_template_part('templates/mobile_home/mobilerev', 'slider');
				}
				else if ($m_home_header == "flex") {
					get_template_part('templates/mobile_home/mobileflex', 'slider');
				}
				else if ($m_home_header == "pagetitle") {
					get_template_part('templates/mobile_home/page-title', 'mhome');
				}
				else if ($m_home_header == "video") {
					get_template_part('templates/mobile_home/mobilevideo', 'block');
				}
				else if ($m_home_header == "shortcode") {
					get_template_part('templates/mobile_home/cyclone', 'slider');
				}
				else if ($m_home_header == "ktslider") {
					get_template_part('templates/mobile_home/kt', 'slider');
				} 
				else if ($m_home_header == "ksp") {
					get_template_part('templates/mobile_home/ksp', 'slider');
				}
			} else { 
			  $home_header = $pinnacle['choose_home_header'];
				if ($home_header == "rev") {
							get_template_part('templates/home/rev', 'slider');
				}
				else if ($home_header == "ktslider") {
							get_template_part('templates/home/kt', 'slider');
				}
				else if ($home_header == "ksp") {
							get_template_part('templates/home/ksp', 'slider');
				}
				else if ($home_header == "flex") {
					get_template_part('templates/home/flex', 'slider');
				}
				else if ($home_header == "carousel") {
					get_template_part('templates/home/carousel', 'slider');
				}
				else if ($home_header == "imgcarousel") {
					get_template_part('templates/home/image', 'carousel');
				}
				else if ($home_header == "latest") {
					get_template_part('templates/home/latest', 'slider');
				}
				else if ($home_header == "cyclone") {
					get_template_part('templates/home/cyclone', 'slider');
				}
				else if ($home_header == "video") {
					get_template_part('templates/home/video', 'block');
				} 
				else if ($home_header == "pagetitle") {
					get_template_part('templates/home/page-title', 'home');
				}
}?>
    <div id="content" class="container homepagecontent">
   		<div class="row">
          <div class="main <?php echo kadence_main_class(); ?>" role="main">

      	<?php if(isset($pinnacle['homepage_layout']['enabled'])) { $layout = $pinnacle['homepage_layout']['enabled']; } else {$layout = array("block_one" => "block_one", "block_four" => "block_four");}

				if ($layout):

				foreach ($layout as $key=>$value) {

				    switch($key) {

				    	case 'block_one':?>
								
									<?php get_template_part('templates/home/callto', 'action'); ?>
								
					    <?php 
					    break;
					    case 'block_two': 
				    		get_template_part('templates/home/image', 'menu');
					    break;
						case 'block_three':
							if (class_exists('woocommerce'))  {
								get_template_part('templates/home/product', 'carousel');
							}
						break;
						case 'block_four': ?>
							<?php 
							if(is_home()) { 
								if(kadence_display_sidebar()) {
									$display_sidebar = true; 
									$fullclass = '';
								} else {
									$display_sidebar = false; 
									$fullclass = 'fullwidth';
								}
								global $pinnacle, $postcolumn, $blog_fullwidth; 
								if(isset($pinnacle['pinnacle_animate_in']) && $pinnacle['pinnacle_animate_in'] == 1) {
									$animate = 1;
								} else {
									$animate = 0;
								} 
								if(isset($pinnacle['home_post_summery']) && $pinnacle['home_post_summery'] == 'full'){
									    $summary = 'full'; 
									    $postclass = "single-article fullpost"; 
									    $contentid = 'homelatestpost';

								} else if(isset($pinnacle['home_post_summery']) && $pinnacle['home_post_summery'] == 'grid'){
								        if(isset($pinnacle['home_post_grid_columns'])) {
								        	$blog_grid_column = $pinnacle['home_post_grid_columns'];
								        } else {
								        	$blog_grid_column = '3';
								        }
								        if(isset($pinnacle['blog_grid_display_height']) && $pinnacle['blog_grid_display_height'] == 1) {
								            $matchheight = 1;
								        } else {
								            $matchheight = 0;
								        }
								        $summary = 'grid'; 
								        $postclass = 'postlist'; 
								        $contentid = 'kad-blog-grid-case';
								        if ($blog_grid_column == '2') {
								        	$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; 
								        	$postcolumn = '2';
								        } else if ($blog_grid_column == '3'){
								        	$itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
								        	$postcolumn = '3';
								        }  else {
								        	$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
								        	$postcolumn = '4';
								        }

								} else if(isset($pinnacle['home_post_summery']) && $pinnacle['home_post_summery'] == 'photo'){
								        if(isset($pinnacle['home_post_grid_columns'])) {
								        	$blog_grid_column = $pinnacle['home_post_grid_columns'];
								        } else {
								        	$blog_grid_column = '3';
								        }
								        if(isset($pinnacle['pinnacle_animate_in']) && $pinnacle['pinnacle_animate_in'] == 1) {
								        	$animate = 1;
								        } else {
								        	$animate = 0;
								        } 
								        $summary = 'photo'; 
								        $postclass = 'postlist'; 
								        $contentid = 'kad-blog-photo-grid-case';
								        $blog_fullwidth = false;

								        if ($blog_grid_column == '2') {
								        	$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; 
								        	$postcolumn = '2'; 
								        } else if ($blog_grid_column == '3'){
								        	$itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
								        	$postcolumn = '3'; 
								        } else {
								        	$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12';
								        	$postcolumn = '3';
								        }

								} else {
									  	$summary = 'normal'; 
									  	$postclass = 'postlist'; 
									  	$contentid = 'homelatestpost';
								}
								if(isset($pinnacle['blog_infinitescroll']) && $pinnacle['blog_infinitescroll'] == 1) {
							       if($summary == 'grid' || $summary == 'photo') {
							         $infinit = 'data-nextselector=".wp-pagenavi a.next" data-navselector=".wp-pagenavi" data-itemselector=".kad_blog_item" data-itemloadselector=".kad_blog_fade_in" data-infiniteloader="'.get_template_directory_uri() . '/assets/img/loader.gif"';
							         $scrollclass = 'init-infinit';
							      } else {
							         $infinit = 'data-nextselector=".wp-pagenavi a.next" data-navselector=".wp-pagenavi" data-itemselector=".post" data-itemloadselector=".kad-animation" data-infiniteloader="'.get_template_directory_uri() . '/assets/img/loader.gif"';
							         $scrollclass = 'init-infinit-norm';
							      }
							    } else {
							        $infinit = '';
							        $scrollclass = '';
							    }?>
								<div id="<?php echo esc_attr($contentid);?>" class="homecontent <?php echo esc_attr($fullclass).' '.esc_attr($postclass); ?> clearfix home-margin"  data-fade-in="<?php echo esc_attr($animate);?>"> 
							  	<?php  
								  	if($summary == 'full'){?>
					                    <div class="kt_home_archivecontent <?php echo esc_attr($scrollclass); ?>" <?php echo $infinit; ?>> 
					                    <?php 
							            if($display_sidebar){
							                global $kt_feat_width; 
							                $kt_feat_width = 848;
									    } else {
							                global $kt_feat_width; 
							                $kt_feat_width = 1170;
							            }
							            while (have_posts()) : the_post();
							                get_template_part('templates/content', 'fullpost'); 
							            endwhile;
					                    ?>
					                    </div> 
					                    <?php 
							      	} else if($summary == 'grid') { ?>
							            <div id="kad-blog-grid-home" class="rowtight kad-blog-grid kt_home_archivecontent <?php echo esc_attr($scrollclass); ?> init-isotope" data-iso-match-height="<?php echo esc_attr($matchheight);?>" <?php echo $infinit; ?> data-fade-in="<?php echo esc_attr($animate);?>"  data-iso-selector=".b_item" data-iso-style="masonry">
							                <?php while (have_posts()) : the_post(); ?>
							                	<div class="<?php echo esc_attr($itemsize); ?> b_item kad_blog_item">
							                 		<?php  get_template_part('templates/content', 'post-grid'); ?>
							                	</div>
							                <?php endwhile; ?>
							            </div>						        
							        <?php
							      	} else if ($summary == 'photo') { ?>
							      		<div id="kad-blog-photo-grid" class="rowtight kt_home_archivecontent <?php echo esc_attr($scrollclass); ?> init-isotope" <?php echo $infinit; ?> data-fade-in="<?php echo esc_attr($animate);?>"  data-iso-selector=".b_item" data-iso-style="masonry">
							                <?php while (have_posts()) : the_post(); ?>
							                    <div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
							                        <?php  get_template_part('templates/content', 'post-photo-grid'); ?>
							            		</div>
							           		<?php endwhile; ?>
							          	</div>						            
							            <?php 
							      	} else { ?>
					                    <div class="kt_home_archivecontent <?php echo esc_attr($scrollclass); ?>" <?php echo $infinit; ?>> 
					                    <?php 
							          	if($display_sidebar){
											global $kt_post_with_sidebar; 
			                				$kt_post_with_sidebar = true;
								        } else {
								            global $kt_feat_width; 
								            $kt_post_with_sidebar = false;
								        }
							               while (have_posts()) : the_post();
							                    get_template_part('templates/content', get_post_format());
							               endwhile;
							               ?>
					                    </div> 
					                    <?php 
							      	} ?>
								</div> 
								
								<?php 
								if ($wp_query->max_num_pages > 1) : 
							        if(function_exists('kad_wp_pagenavi')) {
							            kad_wp_pagenavi();   
							        }
							    endif; 
									
							} else { ?>
								<div class="homecontent clearfix home-margin"> 
									<?php get_template_part('templates/content', 'page'); ?>
								</div>
							<?php }
						break;
						case 'block_five':
						 	get_template_part('templates/home/blog', 'home'); 
						break;
						case 'block_six':
								get_template_part('templates/home/portfolio', 'carousel');		 
						break; 
						case 'block_seven':
								get_template_part('templates/home/icon', 'menu');		 
						break;
						case 'block_eight':
								get_template_part('templates/home/home', 'portfolio');		 
						break; 
						case 'block_nine':
							if (class_exists('woocommerce'))  {
								get_template_part('templates/home/product-sale', 'carousel');
							}	 
						break; 
						case 'block_ten':
							if (class_exists('woocommerce'))  {
								get_template_part('templates/home/product-best', 'carousel');
							}	 
						break; 
						case 'block_eleven':
								get_template_part('templates/home/custom', 'carousel');		 
						break; 
						case 'block_twelve':
								get_template_part('templates/home/widget', 'box');		 
						break;  
					    }

}
endif; ?>   


</div><!-- /.main -->
  <?php get_footer(); ?>
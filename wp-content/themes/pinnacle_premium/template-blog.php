<?php
/*
Template Name: Blog
*/

 global $post, $pinnacle;

	get_header(); 

	get_template_part('templates/page', 'header'); ?>
	
    <div id="content" class="container">
   		<div class="row">
   			<?php if(kadence_display_sidebar()) {
   				$display_sidebar = true; 
   				$fullclass = '';
   			} else {
   				$display_sidebar = false; 
   				$fullclass = 'fullwidth';
   			}
   			if(get_post_meta( $post->ID, '_kad_blog_summery', true ) == 'full') {
   				$summery = 'full'; 
   				$postclass = "single-article fullpost";
   			} else {
   				$summery = 'normal'; 
   				$postclass = 'postlist';
   			}
   			if(isset($pinnacle['blog_infinitescroll']) && $pinnacle['blog_infinitescroll'] == 1) {
		        $infinit = 'data-nextselector=".wp-pagenavi a.next" data-navselector=".wp-pagenavi" data-itemselector=".post" data-itemloadselector=".kad-animation" data-infiniteloader="'.get_template_directory_uri() . '/assets/img/loader.gif"';
         		$scrollclass = 'init-infinit-norm';
		    } else {
		        $infinit = '';
		        $scrollclass = '';
		    }
   			$blog_category = get_post_meta( $post->ID, '_kad_blog_cat', true ); 
   			$blog_cat= get_term_by ('id',$blog_category,'category');
			if($blog_category == '-1' || $blog_category == '') {
					$blog_cat_slug = '';
			} else {
			$blog_cat = get_term_by ('id',$blog_category,'category');
			$blog_cat_slug = $blog_cat -> slug;
			}

			$blog_items = get_post_meta( $post->ID, '_kad_blog_items', true ); 
			if($blog_items == 'all') {$blog_items = '-1';} 

   			?>
    <div class="main <?php echo kadence_main_class();?> <?php echo esc_attr($postclass) .' '. esc_attr($fullclass); ?>" role="main">
      	<div class="entry-content" itemprop="mainContentOfPage">
					<?php get_template_part('templates/content', 'page'); ?>
		</div>
		<div class="kt_blog_archive <?php echo esc_attr($scrollclass);?>" <?php echo $infinit;?>>
      		<?php 
					$temp = $wp_query; 
					$wp_query = null; 
					$wp_query = new WP_Query();
					$wp_query->query(array(
						'paged' => $paged,
						'category_name'=>$blog_cat_slug,
						'posts_per_page' => $blog_items));
					$count =0;
					if ( $wp_query ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
					<?php if($summery == 'full') {
							if($display_sidebar){
					            global $kt_feat_width; 
					            $kt_feat_width = 848;
					        } else {
					            global $kt_feat_width; 
					            $kt_feat_width = 1170;
					        }
							get_template_part('templates/content', 'fullpost'); 
						} else {
							if($display_sidebar){
								global $kt_post_with_sidebar; 
                				$kt_post_with_sidebar = true;
					        } else {
					            global $kt_feat_width; 
					            $kt_post_with_sidebar = false;
					        }
						 	get_template_part('templates/content', get_post_format()); 
						} 
                    endwhile; else: ?>
						<li class="error-not-found"><?php _e('Sorry, no blog entries found.', 'pinnacle'); ?></li>
					<?php endif; 
                
				if ($wp_query->max_num_pages > 1) : 
				 	if(function_exists('kad_wp_pagenavi')) { 
        				kad_wp_pagenavi();    
        		 	} 
        		endif; 

				$wp_query = null; 
				$wp_query = $temp;
				wp_reset_query(); 
		?>
		</div>
		<?php
		do_action('kadence_page_footer'); ?>
	</div><!-- /.main -->
  <?php get_footer(); ?>
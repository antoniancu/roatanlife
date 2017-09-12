<?php 
global $pinnacle, $postcolumn; 

    get_header(); 

    get_template_part('templates/archive', 'header'); 

    if(kadence_display_sidebar()) {
        $display_sidebar = true; $fullclass = '';
    } else {
        $display_sidebar = false; $fullclass = 'fullwidth';
    }
    if(isset($pinnacle['category_post_summary']) && $pinnacle['category_post_summary'] == 'full'){
        $summary = 'full'; 
        $postclass = "single-article fullpost";
    } else if(isset($pinnacle['category_post_summary']) && $pinnacle['category_post_summary'] == 'grid'){
        if(isset($pinnacle['category_post_grid_columns'])) {
            $blog_grid_column = $pinnacle['category_post_grid_columns'];
        } else {
            $blog_grid_column = '3';
        }
        if(isset($pinnacle['pinnacle_animate_in']) && $pinnacle['pinnacle_animate_in'] == 1) {
            $animate = 1;
        } else {
            $animate = 0;
        }
        if(isset($pinnacle['blog_grid_display_height']) && $pinnacle['blog_grid_display_height'] == 1) {
            $matchheight = 1;
        } else {
            $matchheight = 0;
        }
        $summary = 'grid'; 
        $postclass = 'postlist';
        if ($blog_grid_column == '2') {
            $itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; 
            $postcolumn = '2';
        } else if ($blog_grid_column == '3'){
            $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
            $postcolumn = '3';
        } else {
            $itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
            $postcolumn = '4';
        }
    } else if(isset($pinnacle['category_post_summary']) && $pinnacle['category_post_summary'] == 'photo'){
        if(isset($pinnacle['category_post_grid_columns'])) {
            $blog_grid_column = $pinnacle['category_post_grid_columns'];
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
        if ($blog_grid_column == '2') {
            $itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; 
            $postcolumn = '2'; 
            $image_width = 560; 
            $titletag = "h4";
        } else if ($blog_grid_column == '3'){
            $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12';
            $postcolumn = '3'; 
            $image_width = 380; 
            $titletag = "h5";
        } else {
            $itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
            $image_width = 340; 
            $titletag = "h5";
        }
    } else {
        $summary = 'normal'; 
        $postclass = 'postlist';
    } 

    if(isset($pinnacle['blog_cat_infinitescroll']) && $pinnacle['blog_cat_infinitescroll'] == 1) {
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
    }

    ?>
    <div id="content" class="container">
        <div class="row">
            <div class="main <?php echo kadence_main_class(); ?>  <?php echo esc_attr($postclass) .' '. esc_attr($fullclass); ?>" role="main">

                <?php if (!have_posts()) : ?>
                  <div class="alert">
                    <?php _e('Sorry, no results were found.', 'pinnacle'); ?>
                  </div>
                  <?php get_search_form(); 
                endif; 
    
                if($summary == 'full'){ ?>
                    <div class="kt_archivecontent <?php echo esc_attr($scrollclass); ?>" <?php echo $infinit; ?>> 
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
                            <div id="kad-blog-grid-archive" class="rowtight kt_archivecontent kad-blog-grid <?php echo esc_attr($scrollclass); ?> init-isotope"  data-iso-match-height="<?php echo esc_attr($matchheight);?>" <?php echo $infinit; ?> data-fade-in="<?php echo esc_attr($animate);?>"  data-iso-selector=".b_item" data-iso-style="masonry">
                                <?php while (have_posts()) : the_post(); ?>
                                    <div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
                                        <?php  get_template_part('templates/content', 'post-grid'); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                <?php
                } else if ($summary == 'photo') { ?>
                    <div id="kad-blog-photo-grid" class="rowtight kt_archivecontent  <?php echo esc_attr($scrollclass); ?> init-isotope" data-fade-in="<?php echo esc_attr($animate);?>" <?php echo $infinit; ?> data-iso-selector=".b_item" data-iso-style="masonry">
                        <?php while (have_posts()) : the_post(); ?>
                              <div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
                                    <div id="post-<?php the_ID(); ?>" class="blog_item postclass kad_blog_fade_in kt_item_fade_in grid_item" style="max-width:<?php echo esc_attr($image_width);?>px">
                                    <?php if(has_post_thumbnail( $post->ID )) {
                                        $image_url = wp_get_attachment_image_src( 
                                        get_post_thumbnail_id( $post->ID ), 'full' ); 
                                        $thumbnailURL = $image_url[0];
                                        $image = aq_resize($thumbnailURL, $image_width, false);
                                        if(empty($image)) { $image = $thumbnailURL; }
                                    } else {   
                                      $thumbnailURL = pinnacle_post_default_placeholder();
                                          $image = aq_resize($thumbnailURL, $image_width, false);
                                          if(empty($image)) { $image = $thumbnailURL; } 
                                      } ?>
                                          <div class="imghoverclass img-margin-center">
                                            <a href="<?php the_permalink()  ?>" title="<?php the_title(); ?>">
                                              <img src="<?php echo esc_url($image) ?>" alt="<?php the_title(); ?>" class="iconhover" style="display:block;">
                                            </a> 
                                          </div>
                                      <?php $image = null; $thumbnailURL = null;   ?>
                                    <div class="photo-postcontent">
                                      <header>
                                          <a href="<?php the_permalink() ?>"><?php echo '<'.$titletag.' class="entry-title">';  the_title(); echo '</'.$titletag.'>'; ?></a>
                                           <?php get_template_part('templates/entry', 'meta-subhead'); ?>
                                      </header>
                                    </div><!-- Text size -->
                              </div> <!-- Blog Item -->
                    </div>
                    <?php endwhile; ?>
                  </div>
                  <?php 
                } else { ?>
                    <div class="kt_archivecontent <?php echo esc_attr($scrollclass); ?>" <?php echo $infinit; ?>> 
                    <?php 
                        if($display_sidebar){
                            global $kt_post_with_sidebar; 
                                    $kt_post_with_sidebar = true;
                        } else {
                            global $kt_post_with_sidebar; 
                            $kt_post_with_sidebar = false;
                        }
                        while (have_posts()) : the_post();
                            get_template_part('templates/content', get_post_format());
                        endwhile;
                    ?>
                    </div> 
                    <?php 
                }

                if ($wp_query->max_num_pages > 1) : 
                   if(function_exists('kad_wp_pagenavi')) { 
                      kad_wp_pagenavi();   
                    }
                endif; 

                do_action('kt_after_pagecontent'); ?>

        </div><!-- /.main -->
  <?php get_footer(); ?>

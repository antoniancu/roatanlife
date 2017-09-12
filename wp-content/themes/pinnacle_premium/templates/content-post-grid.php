<?php 
global $post, $pinnacle, $postcolumn; 
            if(!empty($postcolumn)) {
              if($postcolumn == '3') {
                $image_width = 370;
                $image_height = 246;
                $titletag = "h5";
              } else if($postcolumn == '2') {
                $image_width = 560;
                $image_height = 370;
                $titletag = "h4";
              } else {
                $image_width = 340;
                $image_height = 226;
                $titletag = "h5";
              }
            } else {
              $image_width = 340;
              $image_height = 226;
              $titletag = "h5";
            }
            if(isset($pinnacle['postexcerpt_hard_crop']) && $pinnacle['postexcerpt_hard_crop'] == 1) {
              $hardcrop = true;
            } else {
              $hardcrop = false;
            }
            // Get summary setting
            $postsummery = kt_get_postsummary();

                if($postsummery == 'img_landscape' || $postsummery == 'img_portrait') { ?>
                <div id="post-<?php the_ID(); ?>" class="blog_item postclass kt_item_fade_in kad_blog_fade_in grid_item" itemscope="" itemtype="http://schema.org/BlogPosting">
                      <?php if(has_post_thumbnail( $post->ID ) ){
                                  $image_id = get_post_thumbnail_id( $post->ID );
                                  $image_url = wp_get_attachment_image_src( $image_id, 'full' ); 
                                  $thumbnailURL = $image_url[0];
                                  if($hardcrop) {
                                    $image = aq_resize($thumbnailURL, $image_width, $image_height, true, false);
                                  } else {
                                    $image = aq_resize($thumbnailURL, $image_width, null, false, false);
                                  }
                                  if(empty($image[0])) {$image = array($thumbnailURL,$image_width,$image_height);}
                                  ?>
                                      <div class="imghoverclass img-margin-center" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                        <a href="<?php the_permalink()  ?>" title="<?php echo esc_attr(get_the_title() ); ?>">
                                          <img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr(get_the_title() ); ?>" itemprop="contentUrl" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output( $image[1], $image[2], $thumbnailURL, $image_id);?> class="iconhover" style="display:block;">
                                            <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
		                                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
		                                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                                        </a> 
                                      </div>
                                  <?php $image = null; $thumbnailURL = null;   
                          } else {
                                    $thumbnailURL = pinnacle_post_default_placeholder();
                                    if($hardcrop) {
                                      $image = aq_resize($thumbnailURL, $image_width, $image_height, true, false);
                                    } else {
                                      $image = aq_resize($thumbnailURL, $image_width, null, false, false);
                                    }
                                    if(empty($image[0])) {$image = array($thumbnailURL,$image_width,$image_height);}
                                    ?> 
                                      <div class="imghoverclass img-margin-center" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                        <a href="<?php the_permalink()  ?>" title="<?php the_title(); ?>">
                                          <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title(); ?>" itemprop="contentUrl" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" class="iconhover" style="display:block;">
                                          <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
		                                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
		                                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                                        </a> 
                                      </div>
                                  <?php $image = null; $thumbnailURL = null;
                          } ?>

              <?php } elseif($postsummery == 'slider_landscape' || $postsummery == 'slider_portrait' || $postsummery == 'gallery_grid') {?>
                          <div id="post-<?php the_ID(); ?>" class="blog_item kt_item_fade_in postclass kad_blog_fade_in grid_item" itemscope="" itemtype="http://schema.org/BlogPosting">
                              <?php
                              if(function_exists('kt_create_flexslider')){
                                  $speed = 7000;
                                  $animationspeed = 400;
                                  $animation = "fade";
                                  $auto = "true";
                                  $initdelay = (rand(10,2000));
                                  $width = $image_width;
                                  $height = $image_height;
                                  $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                                  $link = 'post';
                                  kt_create_flexslider($speed, $animationspeed, $animation, $auto, $initdelay, $width, $height, $image_gallery, $link);
                              }
                              ?>

                    <?php } elseif($postsummery == 'video') {?>
                          <div id="post-<?php the_ID(); ?>" class="blog_item kt_item_fade_in postclass kad_blog_fade_in grid_item" itemscope="" itemtype="http://schema.org/BlogPosting">
                                <div class="videofit">
                                    <?php $video = get_post_meta( $post->ID, '_kad_post_video', true ); echo do_shortcode($video); ?>
                                </div>
                               <?php if (has_post_thumbnail( $post->ID ) ) { 
						            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
						            <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
						                <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
						                <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
						                <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
						            </div>
						        <?php } ?>

                    <?php } else {?>
                          <div id="post-<?php the_ID(); ?>" class="blog_item kt_item_fade_in postclass kad_blog_fade_in grid_item" itemscope="" itemtype="http://schema.org/BlogPosting">
                        <?php }?>

                      <div class="postcontent">
                          <header>
                              <a href="<?php the_permalink() ?>"><?php echo '<'.$titletag.' class="entry-title" itemprop="name headline">';  the_title(); echo '</'.$titletag.'>'; ?></a>
                               <?php get_template_part('templates/entry', 'meta-subhead'); ?>
                          </header>
                          <div class="entry-content" itemprop="description articleBody">
                              <?php the_excerpt(); ?>
                          </div>
                          <footer class="clearfix">
                             <?php get_template_part('templates/entry', 'meta-footer'); ?>
                          </footer>
                        </div><!-- Text size -->
              </div> <!-- Blog Item -->
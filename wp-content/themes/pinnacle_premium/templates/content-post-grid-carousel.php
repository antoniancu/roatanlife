<?php global $post, $pinnacle, $postcolumn; 
    if(!empty($postcolumn)) {
      if($postcolumn == '3') {
        $image_width = 372; 
        $image_height = 246; 
      } else if($postcolumn == '2') {
        $image_width = 560; 
        $image_height = 370;
      } else if($postcolumn == '6') {
        $image_width = 240; 
        $image_height = 159;
      } else if($postcolumn == '5') {
        $image_width = 240; 
        $image_height = 159;
      } else {
        $image_width = 340; 
        $image_height = 226;
      }
    } else {
      $image_width = 340;
      $image_height = 226; 
    } ?>
        <div id="post-<?php the_ID(); ?>" class="blog_item postclass grid_item" itemscope="" itemtype="http://schema.org/BlogPosting">
                <?php if(has_post_thumbnail( $post->ID )) {
                        $image_id = get_post_thumbnail_id( $post->ID );
                        $image_url = wp_get_attachment_image_src( $image_id, 'full' ); 
                        $thumbnailURL = $image_url[0];
                        $image = aq_resize($thumbnailURL, $image_width, $image_height, true, false);
                        if(empty($image[0])) {$image = array($thumbnailURL,$image_width,$image_height);}
                   } else {
                      $image_id = '';
                      $thumbnailURL = pinnacle_post_default_placeholder();
                      $image = aq_resize($thumbnailURL, $image_width, $image_height, true, false);
                      if(empty($image[0])) {$image = array($thumbnailURL,$image_width,$image_height);}
                       } ?>
                                  <div class="imghoverclass img-margin-center" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                    <a href="<?php the_permalink()  ?>" title="<?php the_title(); ?>">
                                      <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title(); ?>"  itemprop="contentUrl" <?php echo 'width="'.esc_attr($image[1]).'" height="'.esc_attr($image[2]).'"';?> <?php echo kt_get_srcset_output( $image[1], $image[2], $thumbnailURL, $image_id);?> class="iconhover" style="display:block;">
                                      <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
		                                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
		                                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                                    </a> 
                                  </div>
                              <?php $image = null; $thumbnailURL = null;   ?>
                      <div class="postcontent">
                          <header>
                              <a href="<?php the_permalink() ?>"><h5 class="entry-title" itemprop="name headline"><?php the_title();?> </h5></a>
                               <?php get_template_part('templates/entry', 'meta-subhead'); ?>
                          </header>
                          <div class="entry-content color_body" itemprop="description articleBody">
                                  <?php if(function_exists('the_advanced_excerpt') ) {
                                    the_excerpt();
                                    } else { ?>
                                  	<p><?php echo pinnacle_excerpt(16); ?> <a href="<?php the_permalink() ?>"><?php global $pinnacle; if(!empty($pinnacle['post_readmore_text'])) {$readmore = $pinnacle['post_readmore_text'];} else {$readmore = __('Read More', 'pinnacle');} echo $readmore; ?></a></p>
                                  <?php } ?> 
                              </div>
                          <footer class="clearfix">
                          <?php 
                          echo '<meta itemprop="dateModified" content="'.esc_attr(get_the_modified_date('c')).'">';
							echo '<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="'.esc_url(get_the_permalink()).'">';
							echo '<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">';
							    if (!empty($pinnacle['x1_logo_upload']['url'])) {  
							    echo '<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">';
							    echo '<meta itemprop="url" content="'.esc_attr($pinnacle['x1_logo_upload']['url']).'">';
							    echo '<meta itemprop="width" content="'.esc_attr($pinnacle['x1_logo_upload']['width']).'">';
							    echo '<meta itemprop="height" content="'.esc_attr($pinnacle['x1_logo_upload']['height']).'">';
							    echo '</div>';
							    }
							    echo '<meta itemprop="name" content="'.esc_attr(get_bloginfo('name')).'">';
							echo '</div>';
							?>
                          </footer>
                        </div><!-- Text size -->
              </div> <!-- Blog Item -->
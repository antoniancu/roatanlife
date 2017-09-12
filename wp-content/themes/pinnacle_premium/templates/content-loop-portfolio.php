<?php
/**
 * Portfolio Summary Content Loop
 *
 * @author    KadenceThemes
 *
 */

 global $post, $kt_portfolio_loop; 

$postsummery = get_post_meta( $post->ID, '_kad_post_summery', true );

?>

  <div class="portfolio-item grid_item postclass kad-light-gallery kt_item_fade_in">
      <?php if ($postsummery == 'slider') { 
        if(empty($kt_portfolio_loop['slideheight'])) {$slide_height = $kt_portfolio_loop['slidewidth'];} else {$slide_height = $kt_portfolio_loop['slideheight'];}
        $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                      $attachments = array_filter( explode( ',', $image_gallery ) );
                      if ($attachments) {
                        $firstthumbnailURL = wp_get_attachment_url($attachments[0] , 'full');
                        $firstimage = aq_resize($firstthumbnailURL, $kt_portfolio_loop['slidewidth'], $kt_portfolio_loop['slideheight'], true, false, false, $attachments[0]);
        ?>
        <div class="portfolio-imagepadding">
            <div class="flexslider kt-flexslider loading imghoverclass kt-intrinsic clearfix"  style="padding-bottom:<?php echo ($firstimage[2]/$firstimage[1]) * 100;?>%;" data-flex-speed="7000" data-flex-initdelay="<?php echo (rand(10,2000));?>" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                <ul class="slides kad-light-gallery">
                    <?php 
                        foreach ($attachments as $attachment) {
                          $thumbnail_src = wp_get_attachment_image_src($attachment , 'full');
                          $thumbnailURL = $thumbnail_src[0];
                            $image = aq_resize($thumbnailURL, $kt_portfolio_loop['slidewidth'], $kt_portfolio_loop['slideheight'], true, false, false, $attachment);
                            if(empty($image[0])) {$image = array($thumbnailURL,$thumbnail_src[1],$thumbnail_src[2]);} 
                            // Rocket Lazy Load
                            if( kad_lazy_load_filter() ) {
                              $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
                            } else {
                              $image_src_output = 'src="'.esc_url($image[0]).'"'; 
                            }
                             ?>
                              <li>
                                <a href="<?php the_permalink() ?>" class="portfolio_slider_link">
                                  	<img <?php echo $image_src_output;?> width="<?php echo esc_attr($image[1]); ?>" height="<?php echo esc_attr($image[2]); ?>" <?php echo kt_get_srcset_output($image[1], $image[2], $thumbnailURL, $attachment);?> class="portfolio_img_slider portfolio_img" />
                                  </a>
                                  <div class="portfolio-hoverover"></div>
                                  <a href="<?php the_permalink() ?>" class="portfolio_hov_link_bg"></a>
                                  <div class="portfolio-table">
                                      <div class="portfolio-cell">
                                        <?php if($kt_portfolio_loop['pstyleclass'] == "padded_style" ) { ?>

                                              <a href="<?php the_permalink() ?>" class="kad-btn kad-btn-primary">
                                                <?php echo $kt_portfolio_loop['viewdetails'];?>
                                              </a>
                                              
                                              <?php if($kt_portfolio_loop['lightbox'] == 'true') { ?>
                                                <a href="<?php echo esc_url($thumbnailURL); ?>" class="kad-btn kad-btn-primary plightbox-btn" title="<?php the_title();?>" rel="lightbox">
                                                  <i class="kt-icon-search4"></i>
                                                </a>
                                              <?php } 
                                        } elseif($kt_portfolio_loop['pstyleclass'] == "flat-no-margin" || $kt_portfolio_loop['pstyleclass'] == "flat-w-margin" ) { ?>
                                              <h5><?php the_title();?></h5>
                                              
                                              <?php if($kt_portfolio_loop['showtypes'] == 'true') {
                                                  $terms = get_the_terms( $post->ID, 'portfolio-type' );
                                                  if ($terms) {?> 
                                                    <p class="cportfoliotag">
                                                      <?php $output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); ?>
                                                    </p>
                                                  <?php } 
                                              }

                                              if($kt_portfolio_loop['showexcerpt'] == 'true') {?> 
                                                  <p class="p_excerpt">
                                                    <?php echo pinnacle_excerpt(16); ?>
                                                  </p>
                                              <?php } 

                                              if($kt_portfolio_loop['lightbox'] == 'true') {?>
                                                <a href="<?php echo esc_url($thumbnailURL); ?>" class="kad-btn kad-btn-primary plightbox-btn" title="<?php the_title();?>" rel="lightbox">
                                                <i class="kt-icon-search4"></i>
                                                </a>
                                              <?php }
                                        } ?>
                                      </div>
                                  </div>
                              </li>
                        <?php }
                     ?>                       
                </ul>
          </div> <!--Flex Slides-->
      </div>
      <?php  }  ?>     

    <?php } else if($postsummery == 'videolight') { 
      
      if (has_post_thumbnail( $post->ID ) ) {
                  $image_id = get_post_thumbnail_id( $post->ID );
                  $image_url = wp_get_attachment_image_src( $image_id, 'full' ); 
                  $thumbnailURL = $image_url[0]; 
                  $image = array();
                  $image = aq_resize($thumbnailURL, $kt_portfolio_loop['slidewidth'], $kt_portfolio_loop['slideheight'], true, false, false, $image_id);
                  $video_string = get_post_meta( $post->ID, '_kad_post_video_url', true );
                  if(!empty($video_string)) {$video_url = $video_string;} else {$video_url = $thumbnailURL;}
                  if(empty($image[0])) {$image = array($thumbnailURL,$image_url[1],$image_url[2]);} 
                  // Rocket Lazy Load
                  if( kad_lazy_load_filter() ) {
                    $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
                  } else {
                    $image_src_output = 'src="'.esc_url($image[0]).'"'; 
                  }
                  ?>
                  <div class="portfolio-imagepadding kt-portfolio-video">
                    <div class="portfolio-hoverclass">
                      <a href="<?php the_permalink() ?>" class="kt-intrinsic" style="padding-bottom:<?php echo ($image[2]/$image[1]) * 100;?>%;">
                          <img <?php echo $image_src_output;?> width="<?php echo esc_attr($image[1]); ?>" height="<?php echo esc_attr($image[2]); ?>" <?php echo kt_get_srcset_output($image[1], $image[2], $thumbnailURL, $image_id);?> alt="<?php the_title(); ?>" class="kad-lightboxhover">
                      </a>
                        <div class="portfolio-hoverover"></div>
                        <a href="<?php the_permalink() ?>" class="portfolio_hov_link_bg"></a>
                            <div class="portfolio-table">
                              <div class="portfolio-cell">
                                  <?php if($kt_portfolio_loop['pstyleclass'] == "padded_style" ) { ?>
                                      
                                      <a href="<?php the_permalink() ?>" class="kad-btn kad-btn-primary">
                                      <?php echo $kt_portfolio_loop['viewdetails'];?>
                                      </a>
                                      
                                      <?php if($kt_portfolio_loop['lightbox'] == 'true') {?>
                                          <a href="<?php echo esc_url($video_url); ?>" class="kad-btn kad-btn-primary plightbox-btn pvideolight" title="<?php the_title();?>" data-rel="lightbox">
                                            <i class="kt-icon-search4"></i>
                                          </a>
                                      <?php }

                                  } elseif($kt_portfolio_loop['pstyleclass'] == "flat-no-margin" || $kt_portfolio_loop['pstyleclass'] == "flat-w-margin" ) { ?>
                                     <a href="<?php the_permalink() ?>">  
                                        <h5><?php the_title();?></h5>
                                      </a>
                                          <?php if($kt_portfolio_loop['showtypes'] == 'true') {
                                                  $terms = get_the_terms( $post->ID, 'portfolio-type' );
                                                  if ($terms) {?> 
                                                    <p class="cportfoliotag">
                                                      <?php $output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); ?>
                                                    </p>
                                                  <?php } 
                                              }

                                               if($kt_portfolio_loop['showexcerpt'] == 'true') {?> 
                                                  <p class="p_excerpt">
                                                    <?php echo pinnacle_excerpt(16); ?>
                                                  </p>
                                              <?php } 
                                              if($kt_portfolio_loop['lightbox'] == 'true') {?>
                                                <a href="<?php echo esc_url($video_url); ?>" class="kad-btn kad-btn-primary plightbox-btn pvideolight" title="<?php the_title();?>" data-rel="lightbox">
                                                <i class="kt-icon-search4"></i>
                                                </a>
                                              <?php }
                                  } ?>
                                </div>
                              </div>
                    </div>
                  </div>
                  <?php $image = null; $thumbnailURL = null;
      }
    } else {
      if (has_post_thumbnail( $post->ID ) ) {
                  $image_id = get_post_thumbnail_id( $post->ID );
                  $image_url = wp_get_attachment_image_src( $image_id, 'full' ); 
                  $thumbnailURL = $image_url[0];
                  $image = array();
                  $image = aq_resize($thumbnailURL, $kt_portfolio_loop['slidewidth'], $kt_portfolio_loop['slideheight'], true, false, false, $image_id);
                  if(empty($image[0])) {$image = array($thumbnailURL,$image_url[1],$image_url[2]);}
                  // Rocket Lazy Load
                  if( kad_lazy_load_filter() ) {
                    $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
                  } else {
                    $image_src_output = 'src="'.esc_url($image[0]).'"'; 
                  }
                ?>
                    <div class="portfolio-imagepadding">
                      <div class="portfolio-hoverclass">
                          <a href="<?php the_permalink() ?>" class="kt-intrinsic" style="padding-bottom:<?php echo ($image[2]/$image[1]) * 100;?>%;">
                          <img <?php echo $image_src_output;?> width="<?php echo esc_attr($image[1]); ?>" height="<?php echo esc_attr($image[2]); ?>" alt="<?php the_title(); ?>" <?php echo kt_get_srcset_output($image[1], $image[2], $thumbnailURL, $image_id);?> class="kad-lightboxhover">
                          </a>
                          <div class="portfolio-hoverover"></div>
                          <a href="<?php the_permalink() ?>" class="portfolio_hov_link_bg"></a>
                          <div class="portfolio-table">
                            <div class="portfolio-cell">
                              <?php if($kt_portfolio_loop['pstyleclass'] == "padded_style" ) { ?>
                                      
                                      <a href="<?php the_permalink() ?>" class="kad-btn kad-btn-primary">
                                      <?php echo $kt_portfolio_loop['viewdetails'];?>
                                      </a>
                                      
                                      <?php if($kt_portfolio_loop['lightbox'] == 'true') {?>
                                          <a href="<?php echo esc_url($thumbnailURL); ?>" class="kad-btn kad-btn-primary plightbox-btn" title="<?php the_title();?>" data-rel="lightbox">
                                            <i class="kt-icon-search4"></i>
                                          </a>
                                      <?php }

                              } elseif($kt_portfolio_loop['pstyleclass'] == "flat-no-margin" || $kt_portfolio_loop['pstyleclass'] == "flat-w-margin" ) { ?>
                                          <a href="<?php the_permalink() ?>">  <h5><?php the_title();?> </h5> </a>

                                          <?php if($kt_portfolio_loop['showtypes'] == 'true') {
                                                  $terms = get_the_terms( $post->ID, 'portfolio-type' );
                                                  if ($terms) {?> 
                                                    <p class="cportfoliotag">
                                                      <?php $output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); ?>
                                                    </p>
                                                  <?php } 
                                              }

                                               if($kt_portfolio_loop['showexcerpt'] == 'true') {?> 
                                                  <p class="p_excerpt">
                                                    <?php echo pinnacle_excerpt(16); ?>
                                                  </p>
                                              <?php } 
                                              if($kt_portfolio_loop['lightbox'] == 'true') {?>
                                                <a href="<?php echo esc_url($thumbnailURL); ?>" class="kad-btn kad-btn-primary plightbox-btn" title="<?php the_title();?>" data-rel="lightbox">
                                                <i class="kt-icon-search4"></i>
                                                </a>
                                              <?php }
                              } ?>
                            </div>
                          </div>
                      </div>
                    </div>
                    <?php $image = null; $thumbnailURL = null;
    } 
  } ?>

          <?php if($kt_portfolio_loop['pstyleclass'] == "padded_style" ) { ?>
                  <a href="<?php the_permalink() ?>" class="portfoliolink">
                    <div class="piteminfo">   
                        <h5><?php the_title();?></h5>
                            
                            <?php if($kt_portfolio_loop['showtypes'] == 'true') {
                              $terms = get_the_terms( $post->ID, 'portfolio-type' ); 
                              if ($terms) {?> 
                              <p class="cportfoliotag">
                                <?php $output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); ?>
                              </p>
                              <?php } 
                            } 

                            if($kt_portfolio_loop['showexcerpt'] == 'true') {?> 
                                <p class="p_excerpt">
                                    <?php echo pinnacle_excerpt(16); ?>
                                </p>
                            <?php } ?>
                    </div>
                  </a>
          <?php } ?>
</div>


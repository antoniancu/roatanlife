<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $pinnacle; 
        if( isset( $pinnacle['shop_slider_size'])) {
            $slideheight =  $pinnacle['shop_slider_size'];
        } else {
            $slideheight = 400; 
        }
        if( isset( $pinnacle['shop_slider_size_width'])) {
            $slidewidth = $pinnacle['shop_slider_size_width'];
        } else {
            $slidewidth = 1170;
        }
        if(isset($pinnacle['shop_slider_captions'])) {
            $captions = $pinnacle['shop_slider_captions'];
        } else {
            $captions = '0';
        }
        $slides = $pinnacle['shop_slider_images'];
        if(isset($pinnacle['shop_slider_autoplay']) && $pinnacle['shop_slider_autoplay'] == 0) {
            $autoplay = 'false';
        } else {
            $autoplay = 'true';
        }
        if(isset($pinnacle['shop_slider_pausetime'])) {
            $pausetime = $pinnacle['shop_slider_pausetime'];
        } else {
            $pausetime = '7000';
        }
        ?>
    <div class="sliderclass carousel_outerrim">
        <div id="imageslider" class="loading">
            <div class="carousel_slider_outer fredcarousel fadein-carousel" style="overflow:hidden; max-width:<?php echo esc_attr($slidewidth);?>px; height: <?php echo esc_attr($slideheight);?>px; margin-left: auto; margin-right:auto;">
                <div class="carousel_slider initcarouselslider" data-carousel-container=".carousel_slider_outer" data-carousel-transition="600" data-carousel-height="<?php echo esc_attr($slideheight); ?>" data-carousel-auto="<?php echo esc_attr($autoplay); ?>" data-carousel-speed="<?php echo esc_attr($pausetime); ?>" data-carousel-id="scarouselslider">
                    <?php foreach ($slides as $slide) : 
                    if(isset($slide['target']) && $slide['target'] == '1' ) {$target = '_self';} else {$target = '_blank';} 
                    $image = aq_resize($slide['url'], null, $slideheight, false, false, false, $slide['attachment_id']);
                    if(empty($image[0])) {$image = array($slide['url'], $slidewidth, $slideheight);} 
                    $img_srcset_output = kt_get_srcset_output( $image[1], $image[2], $slide['url'], $slide['attachment_id']);
                    echo '<div class="carousel_gallery_item" style="float:left; display: table; position: relative; text-align: center; margin: 0; width:auto; height:'.esc_attr($image[2]).'px;">';
                        echo '<div class="carousel_gallery_item_inner" style="vertical-align: middle; display: table-cell;">';
                        if(!empty($slide['link'])) {
                            echo '<a href="'.$slide['link'].'" target="'.$target.'">';
                        }
                            echo '<img src="'.esc_url($image[0]).'" width="'.esc_attr($image[1]).'" height="'.esc_attr($image[2]).'" alt="'.esc_attr($slide['description']).'" '.$img_srcset_output.' />';
                            if ($captions == '1') { ?> 
                                <div class="flex-caption">
                                    <?php if (!empty($slide['title'])) {
                                        echo '<div class="captiontitle headerfont">'.$slide['title'].'</div>';
                                    } 
                                    if (!empty($slide['description'])) {
                                        echo '<div><div class="captiontext headerfont"><p>'.$slide['description'].'</p></div></div>';
                                    } ?>
                                </div> 
                        <?php } ?>
                        <?php if(!empty($slide['link'])) {
                            echo '</a>';
                            } ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
              <a id="prevport-scarouselslider" class="prev_carousel kt-icon-arrow-left" href="#"></a>
              <a id="nextport-scarouselslider" class="next_carousel kt-icon-arrow-right" href="#"></a>
          </div> <!--fredcarousel-->
  </div><!--Container-->
</div><!--sliderclass-->
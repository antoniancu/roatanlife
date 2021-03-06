<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $pinnacle; 

    $slides = $pinnacle['shop_slider_images'];
    if( isset( $pinnacle['shop_slider_size']))  { 
        $slideheight = $pinnacle['shop_slider_size'];
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
    if(!empty($pinnacle['shop_trans_type'])) {
        $transtype = $pinnacle['shop_trans_type'];
    } else {
        $transtype = 'slide';
    }
    if(isset($pinnacle['shop_slider_transtime'])) {
        $transtime = $pinnacle['shop_slider_transtime'];
    } else {
        $transtime = '300';
    }
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
    <div class="sliderclass">
        <div id="imageslider" class="container">
            <div class="flexslider kt-flexslider loading" style="max-width:<?php echo esc_attr($slidewidth);?>px;" data-flex-speed="<?php echo esc_attr($pausetime);?>" data-flex-initdelay="0" data-flex-anim-speed="<?php echo esc_attr($transtime);?>" data-flex-animation="<?php echo esc_attr($transtype); ?>" data-flex-auto="<?php echo esc_attr($autoplay);?>">
                <ul class="slides">
                <?php foreach ($slides as $slide) : 
                    
                    $image = aq_resize($slide['url'], $slidewidth, $slideheight, true, false, false, $slide['attachment_id']);
                    if(empty($image[0])) {$image = array($slide['url'], $slidewidth, $slideheight);} 
                    $img_srcset_output = kt_get_srcset_output( $image[1], $image[2], $slide['url'], $slide['attachment_id']);?> 
                        <li> 
                        <?php if(!empty($slide['link'])) {
                            if(isset($slide['target']) && $slide['target'] == '1' ) {$target = '_self';} else {$target = '_blank';} 
                            echo '<a href="'.esc_url($slide['link']).'" target="'.esc_attr($target).'">';
                        } ?>
                            <img src="<?php echo esc_url($image[0]); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo $img_srcset_output; ?> alt="<?php echo esc_attr($slide['description']);?>" title="<?php echo esc_attr($slide['title']); ?>" />
                                <?php if ($captions == '1') { ?> 
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
                      </li>
                <?php endforeach; ?>
                </ul>
            </div> <!--Flex Slides-->
        </div>
    </div>
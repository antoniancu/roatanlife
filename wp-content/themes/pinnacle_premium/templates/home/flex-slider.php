<?php  
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

 global $pinnacle; 
        if(isset($pinnacle['slider_size'])) {$slideheight = $pinnacle['slider_size'];} else { $slideheight = 400; }
        if(isset($pinnacle['slider_size_width'])) {$slidewidth = $pinnacle['slider_size_width'];} else { $slidewidth = 1140; }
        if(isset($pinnacle['slider_captions'])) { $captions = $pinnacle['slider_captions']; } else {$captions = '';}
        if(isset($pinnacle['home_slider'])) {$slides = $pinnacle['home_slider']; } else {$slides = '';}
        if(isset($pinnacle['trans_type'])) {$transtype = $pinnacle['trans_type'];} else { $transtype = 'slide';}
        if(isset($pinnacle['slider_transtime'])) {$transtime = $pinnacle['slider_transtime'];} else {$transtime = '300';}
        if(isset($pinnacle['slider_autoplay']) && $pinnacle['slider_autoplay'] == 0) {$autoplay = 'false';} else {$autoplay = 'true';}
        if(isset($pinnacle['slider_pausetime'])) {$pausetime = $pinnacle['slider_pausetime'];} else {$pausetime = '7000';}
                ?>
<div class="sliderclass">
     <div id="imageslider" class="">
        <div class="flexslider kt-flexslider loading" style="max-width:<?php echo esc_attr($slidewidth);?>px; margin-left: auto; margin-right:auto;"  data-flex-speed="<?php echo esc_attr($pausetime);?>" data-flex-initdelay="0" data-flex-anim-speed="<?php echo esc_attr($transtime);?>" data-flex-animation="<?php echo esc_attr($transtype); ?>" data-flex-auto="<?php echo esc_attr($autoplay);?>">
            <ul class="slides">
            <?php foreach ($slides as $slide) :
                    if(!empty($slide['target']) && $slide['target'] == 1) {$target = '_blank';} else {$target = '_self';} 
                    $image = aq_resize($slide['url'], $slidewidth, $slideheight, true, false, false, $slide['attachment_id']);
                    if(empty($image[0])) {$image = array($slide['url'], $slidewidth, $slideheight);} 
                    $img_srcset_output = kt_get_srcset_output( $image[1], $image[2], $slide['url'], $slide['attachment_id']);
                        ?>
                      <li> 
                        <?php if(!empty($slide['link'])) {
                            echo '<a href="'.esc_url($slide['link']).'" target="'.esc_attr($target).'">';
                            } ?>
                          <img src="<?php echo esc_url($image[0]); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo $img_srcset_output;?> alt="<?php echo esc_attr($slide['title']); ?>" />
                              <?php if ($captions == '1') { ?> 
                                <div class="flex-caption">
                                <?php if (!empty($slide['title'])) {
                                        echo '<div class="captiontitle headerfont">'.$slide['title'].'</div>';
                                    } 
                                    if (!empty($slide['description'])) {
                                        echo '<div><div class="captiontext headerfont"><p>'.$slide['description'].'</p></div></div>';
                                    }?>
                                </div> 
                              <?php } ?>
                        <?php if(!empty($slide['link'])) {
                                echo '</a>';
                            }?>
                      </li>
                  <?php endforeach; ?>
            </ul>
        </div> <!--Flex Slides-->
    </div><!--Container-->
</div><!--sliderclass-->
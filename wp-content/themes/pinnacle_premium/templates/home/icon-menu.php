<?php 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

global $pinnacle; 

    $icons = $pinnacle['icon_menu']; 
    if(!empty($pinnacle['home_icon_menu_column'])) {
        $columnsize = $pinnacle['home_icon_menu_column'];
    } else {
        $columnsize = 3;
    }
    if ($columnsize == '2') {
        $itemsize = 'tcol-lg-6 tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; 
    } else if ($columnsize == '3'){
        $itemsize = 'tcol-lg-4 tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
    } else if ($columnsize == '6'){
        $itemsize = 'tcol-lg-2 tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6';
    } else if (
        $columnsize == '5'){
        $itemsize = 'tcol-lg-25 tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6';
    } else {
        $itemsize = 'tcol-lg-3 tcol-md-3 tcol-sm-6 tcol-xs-6 tcol-ss-12';
    }
    if(!empty($pinnacle['home_icon_menu_btn'])) {
        $iconbtn = $pinnacle['home_icon_menu_btn'];
    } else {
        $iconbtn = '';
    }
    if(isset($pinnacle['home_icon_menu_btn_show']) && $pinnacle['home_icon_menu_btn_show'] == 0) {
        $iconbtncss = '';
    } else {
        $iconbtncss = 'kt-iconbtn-hide';
    }
                	?>
    <div class="home-margin home-padding kt-home-icon-menu">
        <div class="rowtight homepromo kt-home-iconmenu-container" data-equal-height="1">
        <?php $counter = 1;
            foreach ($icons as $icon) : 
                if(!empty($icon['target']) && $icon['target'] == 1) {$target = '_blank';} else {$target = '_self';} ?>
                    <div class="<?php echo esc_attr($itemsize);?> home-iconmenu kad-animation <?php echo 'homeitemcount'.$counter;?>" data-animation="fade-in" data-delay="<?php echo $counter*150;?>">
                        <?php if(!empty($icon['link'])) {?> 
                            <a href="<?php echo esc_url($icon['link']); ?>" target="<?php echo esc_attr($target); ?>"  title="<?php echo esc_attr($icon['title']); ?>" class="home-icon-item">
                        <?php } else { ?>
                            <div class="home-icon-item">
                        <?php } 
                        if(!empty($icon['url'])) {
                            echo '<i><img src="'.$icon['url'].'"/></i>' ;
                        } else {
                            echo '<i class="'.$icon['icon_o'].'"></i>';
                        }
                        if (!empty($icon['title'])) {
                            echo '<h4>'.$icon['title'].'</h4>'; 
                        }
                        if (!empty($icon['description'])) {
                            echo '<p>'.$icon['description'].'</p>'; 
                        }
                        if(!empty($iconbtn)) {
                            echo '<div class="kad-btn sm-kad-btn '.esc_attr($iconbtncss).' kad-btn-primary">'.esc_attr($iconbtn).'</div>';
                        }
                        if(!empty($icon['link'])) {
                            echo '</a>';
                        } else { 
                            echo '</div>';
                        } ?>
                    </div>
                    <?php $counter ++;
        endforeach; ?>
        </div> <!--homepromo -->
    </div>
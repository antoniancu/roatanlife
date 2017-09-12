<?php global $post, $pinnacle, $postcolumn, $blog_fullwidth; 
    
    if ($blog_fullwidth) { 
        if ($postcolumn == '2') {
            $image_width = 700;
            $image_height = 460;
            $titletag = "h4";
        } else if ($postcolumn == '3'){
            $image_width = 460;
            $image_height = 300;
            $titletag = "h5";
        } else {
            $image_width = 360;
            $image_height = 240;
            $titletag = "h5";
        }
    } else {
        if ($postcolumn == '2') {
            $image_width = 560;
            $image_height = 370;
            $titletag = "h4";
        } else if ($postcolumn == '3'){ 
            $image_width = 380;
            $image_height = 250;
            $titletag = "h5";
        } else {
            $image_width = 340;
            $image_height = 225;
            $titletag = "h5";
        }
    } 
    if(isset($pinnacle['postexcerpt_hard_crop']) && $pinnacle['postexcerpt_hard_crop'] == 1) {
      $hardcrop = true;
    } else {
      $hardcrop = false;
    }
    ?>
    <div id="post-<?php the_ID(); ?>" class="blog_item postclass kt_item_fade_in kad_blog_fade_in grid_item">
        <?php 
        if(has_post_thumbnail( $post->ID )) {
            $image_id = get_post_thumbnail_id( $post->ID );
            $image_url = wp_get_attachment_image_src($image_id, 'full' ); 
            $thumbnailURL = $image_url[0];
            if($hardcrop) {
                $image = aq_resize($thumbnailURL, $image_width, $image_height, true, false, false, $image_id);
            } else {
                $image = aq_resize($thumbnailURL, $image_width, null, false, false, false, $image_id);
            }
            if(empty($image[0])) {$image = array($thumbnailURL,$image_url[1],$image_url[2]);}
        } else {
            $image_id = '';
            $thumbnailURL = pinnacle_post_default_placeholder();
            if($hardcrop) {
                $image = aq_resize($thumbnailURL, $image_width, $image_height, true, false);
            } else {
              $image = aq_resize($thumbnailURL, $image_width, null, false, false);
            }
            if(empty($image[0])) {$image = array($thumbnailURL,$image_width,$image_height);}
        } ?>
        <div class="imghoverclass img-margin-center">
            <a href="<?php the_permalink() ?>" class="kt-intrinsic" style="padding-bottom:<?php echo ($image[2]/$image[1]) * 100;?>%;">
                <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title(); ?>"  width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output( $image[1], $image[2], $thumbnailURL, $image_id);?> class="iconhover">
            </a> 
        </div>
        <?php $image = null; $thumbnailURL = null;   ?>
        <div class="photo-postcontent">
            <header>
                <a href="<?php the_permalink() ?>"><?php echo '<'.$titletag.' class="entry-title">';  the_title(); echo '</'.$titletag.'>'; ?></a>
                   <?php get_template_part('templates/entry', 'meta-subhead'); ?>
            </header>
        </div><!-- post content -->
    </div> <!-- Blog Item -->
<?php
/**
 * Template for displaying a featured image in post excerpt area.
 */
global $post, $pinnacle,  $kt_post_with_sidebar;
if($kt_post_with_sidebar) {
    $kt_feat_width = 848;
} else {
    $kt_feat_width = 1170;
}
if (has_post_format( 'gallery' )) {
$swidth = get_post_meta( $post->ID, '_kad_gallery_posthead_width', true );
$height = get_post_meta( $post->ID, '_kad_gallery_posthead_height', true ); 
} elseif (has_post_format( 'image' )) {
    $swidth = get_post_meta( $post->ID, '_kad_image_posthead_width', true );
    $height = "";
} else {
    $swidth = "";
    $height = "";
}

if (!empty($swidth)) {$slidewidth = $swidth;} else {$slidewidth = $kt_feat_width;}
if (!empty($height)) {$slideheight = $height;} else {$slideheight = 400;}
if(isset($pinnacle['postexcerpt_hard_crop']) && $pinnacle['postexcerpt_hard_crop'] == 1) {
    $hardcrop = true;
    $img_width = 'width="'.esc_attr($slidewidth).'"';
    $img_height = 'height="'.esc_attr($slideheight).'"';
} else {
    $hardcrop = false;
    $img_width = "";
    $img_height = "";
}
if (has_post_thumbnail( $post->ID ) ) {
	$image_id =  get_post_thumbnail_id( $post->ID );
   	$image_url = wp_get_attachment_image_src($image_id, 'full' ); 
    $thumbnailURL = $image_url[0];
    if($hardcrop) {
        $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true, false);
    } else {
        $image = aq_resize($thumbnailURL,$slidewidth, null, false, false);
    }
    if(empty($image[0])) { $image = array($thumbnailURL,$image_url[1],$image_url[2]);}
    if( kad_lazy_load_filter() ) {
      $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
   } else {
      $image_src_output = 'src="'.esc_url($image[0]).'"'; 
   } ?>
        <div class="col-md-12">
            <div class="imghoverclass img-margin-center" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                <a href="<?php the_permalink()  ?>" title="<?php the_title_attribute(); ?>">
                    <img <?php echo $image_src_output; ?> alt="<?php the_title_attribute(); ?>" itemprop="contentUrl" class="iconhover" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $thumbnailURL, $image_id);?>>
                    <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                </a> 
        	</div>
        </div>
    <?php $image = null; $thumbnailURL = null; 
    } else { 
    	$image_id = '';
        $thumbnailURL = pinnacle_post_default_placeholder();
        $image_url = array($thumbnailURL, $slidewidth, $slideheight);
        if($hardcrop) {
            $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true, false);
        } else {
            $image = aq_resize($thumbnailURL,$slidewidth, null, false, false);
        }
        if(empty($image[0])) { $image = array($thumbnailURL,$image_url[1],$image_url[2]);}  ?>
        <div class="col-md-12">
            <div class="imghoverclass img-margin-center" itemprop="image">
                <a href="<?php the_permalink()  ?>" title="<?php the_title_attribute(); ?>">
                    <img src="<?php echo esc_url($image[0]);?>" alt="<?php the_title_attribute(); ?>" itemprop="contentUrl" class="iconhover" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $thumbnailURL, $image_id);?>>
                    <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                </a> 
            </div>
        </div>
        <?php $image = null; $thumbnailURL = null; 
    } ?>
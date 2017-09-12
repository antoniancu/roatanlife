<?php
/**
 * Template for displaying a gallery grid in post excerpt area.
 */
global $post, $kt_post_with_sidebar;
if($kt_post_with_sidebar) {
	$largeimgsize = 440;
	$smallimgsize = 220;
} else {
	$largeimgsize = 600;
	$smallimgsize = 300;
}
?>
<div class="kad_post_grid kad-light-wp-gallery">
	<div class="kad_postgrid_wrap clearfix">
		<?php
        $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
        if(!empty($image_gallery)) {
            $attachments = array_filter( explode( ',', $image_gallery ) );
            if ($attachments) {
                $i = 1;
                foreach ($attachments as $attachment) {
                	$image_id =  $attachment;
                    $image_url = wp_get_attachment_image_src( $attachment, 'full' ); 
                    $attachment_url = $image_url[0];
                    $attachment_post = get_post( $attachment  );
                    if($i==3) {
                    	$image = aq_resize($attachment_url, $largeimgsize, $largeimgsize, true, false);
                    } else {
                    	$image = aq_resize($attachment_url, $smallimgsize, $smallimgsize, true, false);
                    }
                   	if(empty($image[0])) { $image = array($attachment_url,$image_url[1],$image_url[2]);}
                    	if($i==1 || $i == 4) {
                    		echo '<div class="side_post_gal">';
                    	} ?>
                        <div class="kpgi kad_post_grid_item-<?php echo esc_attr($i); ?>">
                            <a href="<?php the_permalink() ?>" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                	<img src="<?php echo esc_url($image[0]); ?>" alt="<?php esc_attr($attachment_post->post_excerpt);?>" itemprop="contentUrl" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $attachment_url, $image_id);?>>
                                    <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                            </a>
                        </div>
                        <?php if($i==2 || $i == 5) { echo '</div>';} 
                            $i ++;
                        if($i==6) break;
                    }
            }
        } ?>                                   
    </div>
</div>
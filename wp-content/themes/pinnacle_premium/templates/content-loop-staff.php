<?php
/*
Template: Staff Grid Loop
*/

global $post, $pinnacle, $kt_staff_loop; 
?>
    <div class="grid_item staff_item kt_item_fade_in kad_staff_fade_in postclass">
		<?php if (has_post_thumbnail( $post->ID ) ) {
		$image_id = get_post_thumbnail_id( $post->ID );
		$image_src = wp_get_attachment_image_src($image_id, 'full' ); 
		$image = aq_resize($image_src[0], $kt_staff_loop['slidewidth'],$kt_staff_loop['slideheight'], true, false, false, $image_id);
		if(empty($image[0])) {$image = array($image_src[0], $image_src[1], $image_src[2]); } ?>
		
		<div class="imghoverclass">
			<?php 
			if($kt_staff_loop['single_link'] == 'true') {?>
				<a href="<?php the_permalink(); ?>"> 
			<?php }?>
	        	<img src="<?php echo esc_url($image[0]); ?>" width="<?php echo esc_attr($image[1]); ?>" height="<?php echo esc_attr($image[2]); ?>" alt="<?php the_title(); ?>" <?php echo kt_get_srcset_output($image[1], $image[2], $image_src[0], $image_id);?>>
	        <?php if($kt_staff_loop['single_link'] == 'true') {?>
	        	</a>
	        <?php } ?>
	    </div>
    	<?php } ?>
    
	    <header class="kt-staff-header">
	        <?php if($kt_staff_loop['single_link'] == 'true') {?>
	        	<a href="<?php the_permalink(); ?>"> 
	        <?php }?>
	        <h3><?php the_title();?></h3>
	        <?php if($kt_staff_loop['single_link'] == 'true') {?>
	        	</a>
	        <?php } ?>
			<?php
			$title = get_post_meta( $post->ID, '_kad_staff_job_title', true );
			if(!empty($title)) {
				echo '<div class="kt-staff-title">'.esc_html($title).'</div>';
			} ?>
	    </header>
		<div class="entry-content staff-entry-content">
			<?php if($kt_staff_loop['full_content'] == 'false') {
				the_excerpt();
			} else {
				the_content(); 
			} ?>
		</div>
		<footer class="clearfix staff-footer">
	    	<?php 
	    	/*
	    	*	@hooked kt_staff_links 20
	    	*/
	    	do_action('kt_staff_footer');?>
		</footer>
	</div>
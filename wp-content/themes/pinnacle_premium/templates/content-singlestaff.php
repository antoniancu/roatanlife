<?php get_template_part('templates/post', 'header'); ?>
<div id="content" class="container">
    <div class="row single-article">
      <div class="main <?php echo kadence_main_class(); ?>" role="main">
		<?php while (have_posts()) : the_post(); ?>
		    <article <?php post_class('postclass'); ?>>
		    	<div class="clearfix">
		    	<div class="staff-img thumbnail alignleft clearfix">
				 		<?php the_post_thumbnail( 'medium' ); ?>
				</div>
			  	<header class="kt-staff-header">
	      			<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
	      			<?php $staff_job_title = get_post_meta( $post->ID, '_kad_staff_job_title', true );
			                	if(!empty($staff_job_title)) echo '<div class="kt-staff-title">'.$staff_job_title.'</div>'; ?>
				</header>
				<div class="entry-content" itemprop="mainContentOfPage">
      				<?php the_content(); ?>
      				<?php wp_link_pages(array('before' => '<nav id="page-nav" class="kt-page-pagnation">', 'after' => '</nav>','link_before'=> '<span>','link_after'=> '</span>')); ?>
    			</div>
    			</div>
    			<footer class="single-footer">
      				<footer class="clearfix staff-footer">
                          	<?php 
					    	/*
					    	*	@hooked kt_staff_links 20
					    	*/
					    	do_action('kt_staff_footer');?>
                          </footer>
			    </footer>
			</article>
		<?php endwhile; ?>
	</div>
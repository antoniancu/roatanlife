<?php
/*
Template Name: Page Builder
*/

	get_header();

	get_template_part('templates/page', 'header'); ?>
	
    <div id="content" class="container kt-pagebuilder-page">
   		<div class="row">
     		<div class="main <?php echo kadence_main_class(); ?>" role="main">
     			<div class="entry-content" itemprop="mainContentOfPage">
					<?php get_template_part('templates/content', 'page'); ?>
				</div>
				<?php do_action('kadence_page_footer'); ?>
			</div><!-- /.main -->
		  <?php get_footer(); ?>
<?php
/*
Template Name: Landing Page
*/
do_action('get_header');

get_template_part('templates/head'); 

global $pinnacle; 
  if(isset($pinnacle["smooth_scrolling"]) && $pinnacle["smooth_scrolling"] == '1') { $scrolling = '1';} else if(isset($pinnacle["smooth_scrolling"]) && $pinnacle["smooth_scrolling"] == '2') { $scrolling = '2';} else {$scrolling = '0';}
  if(isset($pinnacle["smooth_scrolling_hide"]) && $pinnacle["smooth_scrolling_hide"] == '1') {$scrolling_hide = '1';} else {$scrolling_hide = '0';} 
  if(isset($pinnacle['pinnacle_animate_in']) && $pinnacle['pinnacle_animate_in'] == '1') {$animate = '1';} else {$animate = '0';}
  if(isset($pinnacle['sticky_header']) && $pinnacle['sticky_header'] == '1') {$sticky = '1';} else {$sticky = '0';}
  if(isset($pinnacle['header_style'])) {$header_style = $pinnacle['header_style'];} else {$header_style = 'default';}
  if(isset($pinnacle['select2_select'])) {$select2_select = $pinnacle['select2_select'];} else {$select2_select = '1';}
  ?>
<body <?php body_class(); ?> data-smooth-scrolling="<?php echo esc_attr($scrolling);?>" data-smooth-scrolling-hide="<?php echo esc_attr($scrolling_hide);?>" data-jsselect="<?php echo esc_attr($select2_select);?>" data-animate="<?php echo esc_attr($animate);?>" data-sticky="<?php echo esc_attr($sticky);?>">
<div id="wrapper" class="container">
  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'pinnacle'); ?>
    </div>
  <![endif]-->
  <div class="wrap contentclass landing-wrap" role="document">
    <?php do_action('kt_afterheader');?>
	
    <div id="content" class="container kt-pagebuilder-page">
   		<div class="row">
     		<div class="main col-md-12 kt-nosidebar" role="main">
     			<div class="entry-content" itemprop="mainContentOfPage">
					<?php get_template_part('templates/content', 'page'); ?>
				</div>
				<?php do_action('kadence_page_footer'); ?>
			</div><!-- /.main -->
      </div><!-- /.row-->
    </div><!-- /.content -->
  </div><!-- /.wrap -->
  
  <?php do_action('get_footer');
		wp_footer(); ?>
</div><!--Wrapper-->
</body>
</html>
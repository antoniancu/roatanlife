<?php 
/* Attachment Page Content */
  get_template_part('templates/post', 'header'); 

  ?>
<div id="content" class="container">
  <div id="post-<?php the_ID(); ?>" class="row single-article" itemscope="" itemtype="http://schema.org/BlogPosting">
    <div class="main <?php echo kadence_main_class(); ?>" role="main">
        <?php while (have_posts()) : the_post();

        do_action( 'kadence_single_attachment_before' ); 
        ?>

        <article <?php post_class('postclass'); ?>>

          <?php

          echo wp_get_attachment_image( get_the_ID(), 'full' );

          /**
          *
          */
          do_action( 'kadence_single_attachment_before_header' );
          ?>
          <header>      
            <?php 
            /**
            * @hooked pinnacle_archive_header_title - 10
            * @hooked pinnacle_post_header_meta - 20
            */
            do_action( 'kadence_single_attachment_header' );
            ?>
          </header>
          <div class="entry-content clearfix" itemprop="description articleBody">
            <?php

              do_action( 'kadence_single_attachment_content_before' );
            
              the_content(); 

              do_action( 'kadence_single_attachment_content_after' );
            
            ?>
          </div>
          <footer class="single-footer clearfix">
            <?php 
            /**
            *
            */
            do_action( 'kadence_single_attachment_footer' );
            ?>
          </footer>
        </article>
      <?php 
      /**
      *@hooked pinnacle_post_comments - 40
      */
      do_action( 'kadence_single_attachment_after' );
      
      endwhile; ?>
    </div>


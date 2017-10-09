<?php get_header(); ?>
<?php global $post, $pinnacle; $layout = get_post_meta( $post->ID, '_kad_ppost_layout', true );
          $ppost_type = get_post_meta( $post->ID, '_kad_ppost_type', true );
           $imgheight = get_post_meta( $post->ID, '_kad_posthead_height', true );
           $imgwidth = get_post_meta( $post->ID, '_kad_posthead_width', true );
           if($layout == 'above')  {
     				$imgclass = 'col-md-12';
     				$textclass = 'pcfull clearfix';
     				$entryclass = 'col-md-8';
     				$valueclass = 'col-md-4';
             $layoutclass = 'kt-portfolio-above';
             $layoutcontainclass = 'container';
     				$slidewidth_d = 1140;
     		} elseif ($layout == 'three')  {
     				$imgclass = 'col-md-12';
     				$textclass = 'pcfull clearfix';
     				$entryclass = 'col-md-12';
     				$valueclass = 'col-md-12';
             $layoutclass = 'kt-portfolio-above';
             $layoutcontainclass = 'container';
     				$slidewidth_d = 1140;
     			} elseif ($layout == 'besidesmall') {
     				$imgclass = 'col-md-8';
     				$textclass = 'col-md-4 pcside';
     				$entryclass = '';
     				$valueclass = '';
     				$slidewidth_d = 780;
             $layoutcontainclass = '';
             $layoutclass = 'kt-portfolio-beside';
     			} else {
             $imgclass = 'col-md-7';
             $textclass = 'col-md-5 pcside';
             $entryclass = '';
             $valueclass = '';
             $layoutcontainclass = '';
             $layoutclass = 'kt-portfolio-beside';
             $slidewidth_d = 653;
             }
     			 	$portfolio_margin = '';
     		if (!empty($imgheight)) { $slideheight = $imgheight; } else { $slideheight = 450; }
     		if (!empty($imgwidth)) { $slidewidth = $imgwidth; } else { $slidewidth = $slidewidth_d; }

        do_action( 'kadence_single_portfolio_after_header' );

        if ($ppost_type == 'imgcarousel') { ?>
<section class="postfeat carousel_outerrim loading">
       <div id="post-carousel-gallery" class="fredcarousel portfolioimgcarousel fadein-carousel" style="overflow:hidden; height: <?php echo esc_attr($slideheight);?>px">
           <div class="gallery-carousel kad-light-wp-gallery initimagecarousel" data-carousel-container=".portfolioimgcarousel" data-carousel-transition="300" data-carousel-auto="true" data-carousel-speed="7000" data-carousel-id="portfolioimgcarousel">
             <?php
                 $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                     if(!empty($image_gallery)) {
                       $attachments = array_filter( explode( ',', $image_gallery ) );
                         if ($attachments) {
                           foreach ($attachments as $attachment) {
                           $attachment_url = wp_get_attachment_url($attachment , 'full');
                           $image = aq_resize($attachment_url, null, $slideheight, false, false);
                             if(empty($image)) {$image = $attachment_url;}
                             echo '<div class="carousel_gallery_item" style="float:left; margin: 0 5px; width:'.esc_attr($image[1]).'px; height:'.esc_attr($image[2]).'px;">';
                             echo '<a href="'.esc_url($attachment_url).'" data-rel="lightbox">';
                             echo '<img src="'.esc_url($attachment_url).'" alt="'.esc_attr(get_post_field('post_excerpt', $attachment)).'"/>';
                             echo '</a></div>';
                           }
                         }
                     } ?>
       </div> <!--post gallery carousel-->
       <div class="clearfix"></div>
         <a id="prevport-portfolioimgcarousel" class="prev_carousel kt-icon-arrow-left" href="#"></a>
         <a id="nextport-portfolioimgcarousel" class="next_carousel kt-icon-arrow-right" href="#"></a>
     </div> <!--fredcarousel-->
   </section>
   <?php $layoutclass = "kt-imagecarouselportfolio";?>
 <?php } ?>
 <div id="content" class="container">
     <div class="row">
       <div class="main <?php echo kadence_main_class(); ?> portfolio-single <?php echo esc_attr($layoutclass);?>" role="main">
       <?php while (have_posts()) : the_post(); ?>

   <?php do_action( 'kadence_single_portfolio_before' );  ?>
   <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
       <div class="portfolio-postclass">
       	<div class="row">
       		<div class="<?php echo esc_attr($imgclass); ?>">
           <?php do_action( 'kadence_single_portfolio_feature_before' );  ?>
 				  <?php if ($ppost_type == 'flex') { ?>
 					<div class="flexslider kt-flexslider loading kad-light-gallery" style="max-width:<?php echo esc_attr($slidewidth);?>px;" data-flex-speed="7000" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
               <ul class="slides">
                 <?php $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                       if(!empty($image_gallery)) {
                     	   $attachments = array_filter( explode( ',', $image_gallery ) );
                     	   if ($attachments) {
 											       foreach ($attachments as $attachment) {
         												$attachment_url = wp_get_attachment_url($attachment , 'full');
         												$caption = get_post($attachment)->post_excerpt;
         												$image = aq_resize($attachment_url, $slidewidth, $slideheight, true);
 													       if(empty($image)) {$image = $attachment_url;}
 												      echo '<li><a href="'.esc_url($attachment_url).'" data-rel="lightbox" title="'.esc_attr($caption).'"><img src="'.esc_url($image).'" alt="'.esc_attr($caption).'" /></a></li>';
 											        }
 										      }

 								        } ?>
 						</ul>
               	</div> <!--Flex Slides-->
 				<?php
 			} else if ($ppost_type == 'carousel') { ?>

 					 <div id="imageslider" class="loading carousel_outerrim">
 					    <div class="carousel_slider_outer fredcarousel fadein-carousel" style="overflow:hidden; max-width:<?php echo esc_attr($slidewidth);?>px; height: <?php echo esc_attr($slideheight);?>px; margin-left: auto; margin-right:auto;">
 					        <div class="carousel_slider kad-light-gallery initcarouselslider" data-carousel-container=".carousel_slider_outer" data-carousel-transition="600" data-carousel-height="<?php echo esc_attr($slideheight); ?>" data-carousel-auto="true" data-carousel-speed="9000" data-carousel-id="carouselslider">
 					            <?php
                           		$image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                           		if(!empty($image_gallery)) {
                     				$attachments = array_filter( explode( ',', $image_gallery ) );
                     					if ($attachments) {
 										foreach ($attachments as $attachment) {
 											$attachment_url = wp_get_attachment_url($attachment , 'full');
 											$caption = get_post($attachment)->post_excerpt;
 					                    	$image = aq_resize($attachment_url, null, $slideheight, false, false);
 					                    	if(empty($image)) {$image = array($attachment_url, $slidewidth, $slideheight);}
 					                        echo '<div class="carousel_gallery_item" style="float:left; display: table; position: relative; text-align: center; margin: 0; width:auto; height:'.esc_attr($image[2]).'px;">';
 					                        echo '<div class="carousel_gallery_item_inner" style="vertical-align: middle; display: table-cell;">';
 					                        echo '<a href="'.esc_url($attachment_url).'" data-rel="lightbox" title="'.esc_attr($caption).'">';
 					                        echo '<img src="'.esc_url($image[0]).'" width="'.esc_attr($image[1]).'" height="'.esc_attr($image[2]).'"  />';
 					                        echo '</a>'; ?>
 					                      </div>
 					                    </div>
 					                  <?php } ?>
 					                  <?php } ?>
 					                  <?php } ?>
 					            </div>
 					            <div class="clearfix"></div>
 					              <a id="prevport-carouselslider" class="prev_carousel kt-icon-arrow-left" href="#"></a>
 					              <a id="nextport-carouselslider" class="next_carousel kt-icon-arrow-right" href="#"></a>
 					          </div> <!--fredcarousel-->
 					  </div><!--Container-->
 				<?php
 				}else if ($ppost_type == 'imgcarousel') {
 				}else if ($ppost_type == 'none') {
 					$portfolio_margin = "kad_portfolio_nomargin";
 				} else {
 						$post_id = get_post_thumbnail_id();
 						$img_url = wp_get_attachment_url( $post_id);
 						$image = aq_resize( $img_url, $slidewidth, $slideheight, true ); //resize & crop the image
 						if(empty($image)) {$image = $img_url;}
 							if($image) : ?>
                                     <div class="imghoverclass portfolio-single-img" itemprop="image">
                                     	<a href="<?php echo esc_url($img_url); ?>" rel="lightbox" class="lightboxhover">
                                     		<img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_post($post_id)->post_excerpt); ?>"  />
                                     	</a>
                                     </div>
                             <?php endif; ?>
 				<?php } ?>
         <?php do_action( 'kadence_single_portfolio_feature_after' );  ?>
         	</div><!--imgclass -->
           <div class="p-container <?php echo esc_attr($layoutcontainclass);?>">
   			   <div class="<?php echo esc_attr($textclass); ?>">
            <div class="postclass clearfix">
 		    	 <div class="entry-content <?php echo esc_attr($entryclass); ?> <?php echo esc_attr($portfolio_margin); ?>" itemprop="mainContentOfPage">
             <?php if (isset($pinnacle['default_showportfoliotitle_inpost']) && $pinnacle['default_showportfoliotitle_inpost'] == 1) { ?>
               <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
             <?php } ?>
             <?php do_action( 'kadence_single_portfolio_before_content' );  ?>
            <h3>Details:</h3>
 		      	<?php the_content(); ?>
            <div class="col-md-6 property_info nopadding">
              <h3>Info:</h3>
              <ul>
                <li class="access_type"><?php echo get_field_object("access_type")['choices'][get_field("access_type", $post)];?></li>
                <?php
                  $property_info = [
                    'bedrooms' => get_field_object('bedrooms'),
                    'bathrooms' => get_field_object('bathrooms'),
                    'floors' => get_field_object('floors'),
                    'square_footage' => get_field_object('square_footage'),
                    'lot_size' => get_field_object('lot_size'),
                    'hoa_condo_fees' => get_field_object('hoa_condo_fees')
                  ];
                 ?>
                 <?php foreach ($property_info as $info) {
                    if($info['value'] != '') {
                      echo '<li class="'.$info['name'].'">'.$info['label'].': '.$info['value'].'</li>';
                    }
                  } ?>
              </ul>
            </div>
            <div class="col-md-6 features nopadding">
              <h3>Features:</h3>
              <ul>
                <?php
                  $features = [
                    'waterfront' => (get_field('waterfront') ? get_field_object("waterfront")['label'] : ""),
                    'pool' => (get_field('pool') ? get_field_object('pool')['label'] : ""),
                    'furnished' => (get_field('furnished') ? get_field_object('furnished')['label'] : ""),
                    'beach_access' => (get_field('beach_access') ? get_field_object('beach_access')['label'] : ""),
                    'garage_parking' => (get_field('garage_parking') ? get_field_object('garage_parking')['label'] : ""),
                    'generator' => (get_field('generator') ? get_field_object('generator')['label'] : "")
                  ];
                  foreach ($features as $feature) {
                    if($feature != "") {
                      echo '<li class="feature">'.$feature.'</li>';
                    }
                  };
                ?>
              </ul>
            </div>
             <?php do_action( 'kadence_single_portfolio_after_content' );  ?>
 		  		  </div>
 	    	<div class="<?php echo esc_attr($valueclass); ?> property_info">
          <div class="property_status">
            <span class="status"><?php echo get_field("status", $post);?></span>
            <span class="property_mls_number">#<?php echo get_field("mls_number", $post);?></span>
          </div>
          <ul class="property_general_info">
            <li class="property_type_label"><?php echo get_field_object("property_type")['label']; ?>:</li>
            <li class="property_type"><?php echo get_field_object("property_type")['choices'][get_field("property_type", $post)]?></li>
            <li class="property_sub_type"><?php echo get_field_object("property_sub_type")['choices'][get_field("property_sub_type", $post)];?></li>
            <li class="property_year"><?php echo get_field_object("year_built")['label']; ?>: <?php echo get_field("year_built", $post); ?></li>
          </ul>
          <div class="property_location">
            <span class="property_location_label">Property Location:</span>
            <span class="property_island"><?php echo get_field_object("island")['choices'][get_field("island", $post)];?>,</span>
            <span class="property_city"><?php echo get_field("city", $post);?></span>
          </div>
 				</div>
       </div>
       </div>
     	</div><!--textclass -->
     </div><!--row-->
     <div class="clearfix"></div>
     </div><!--postclass-->
     <footer>
       <?php wp_link_pages(array('before' => '<nav id="page-nav" class="kt-page-pagnation">', 'after' => '</nav>','link_before'=> '<span>','link_after'=> '</span>')); ?>
       <?php
       $portfolio_carousel = get_post_meta( $post->ID, '_kad_portfolio_carousel_recent', true );
       if (empty($portfolio_carousel) || $portfolio_carousel == 'defualt') {
          if(isset($pinnacle['single_portfolio_carousel_default']) && $pinnacle['single_portfolio_carousel_default'] == "yes") {get_template_part('templates/bottomportfolio', 'carousel');}
       } elseif (
         $portfolio_carousel == 'yes'){ get_template_part('templates/bottomportfolio', 'carousel');
       } ?>
     </footer>
     <?php if(isset($pinnacle['portfolio_comments']) && $pinnacle['portfolio_comments'] == 1) { comments_template('/templates/comments.php'); } ?>
   </article>
   <?php do_action( 'kadence_single_portfolio_after' );  ?>
 <?php endwhile; ?>
 </div>

<?php get_footer(); ?>

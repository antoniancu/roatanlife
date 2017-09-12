<?php 
/*-----------------------------------------------------------------------------------*/
/* This theme supports WooCommerce */
/*-----------------------------------------------------------------------------------*/

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
  add_theme_support( 'woocommerce' );
}
/*-----------------------------------------------------------------------------------*/
/* WooCommerce Functions */
/*-----------------------------------------------------------------------------------*/

if (class_exists('woocommerce')) {
  add_filter( 'woocommerce_enqueue_styles', '__return_false' );
  	if ( version_compare( WC_VERSION, '3.0', '>' ) ) {
		$pinnacle = pinnacle_get_options();
		if(isset($pinnacle['product_gallery_zoom']) && 1 == $pinnacle['product_gallery_zoom']) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}
		if(isset($pinnacle['product_gallery_slider']) && 1 == $pinnacle['product_gallery_slider']) {
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}
  // Disable WooCommerce Lightbox
    if (get_option( 'woocommerce_enable_lightbox' ) == true ) {
      update_option( 'woocommerce_enable_lightbox', false );
    }
   // Makes the product finder plugin work.
    remove_action( 'template_redirect' , array( 'WooCommerce_Product_finder' , 'load_template' ) );
    
}
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);



// Redefine woocommerce_output_related_products()
add_action( 'init', 'woocommerce_customize' );

function woocommerce_customize(){

function kad_woo_related_products_limit($args) {
  	global $product, $woocommerce;
  	if ( version_compare( WC_VERSION, '3.0', '>' ) ) {
		$related = wc_get_related_products($product->get_id(), 8);
	} else {
		$related = $product->get_related(8);
	}
	  $args = array(
	    'post_type'           => 'product',
	    'no_found_rows'       => 1,
	    'posts_per_page'      => 8,
	    'ignore_sticky_posts'   => 1,
	    'orderby'               => 'rand',
	    'post__in'              => $related,
	    'post__not_in'          => array($product->get_id())
	  );
  	return $args;
}
add_filter( 'woocommerce_related_products_args', 'kad_woo_related_products_limit' );

}

add_filter( 'woocommerce_single_product_image_thumbnail_html', 'kad_product_thumnbnail_image');
function kad_product_thumnbnail_image($html) {
    $html = str_replace('data-rel="prettyPhoto', 'rel="lightbox', $html);
    return $html;
}

add_filter( 'woocommerce_product_tabs', 'kad_product_video_tab');
function kad_product_video_tab_content() {
  global $post,$pinnacle; if($videocode = get_post_meta( $post->ID, '_kad_product_video', true )) {
  if(!empty($pinnacle['video_title_text'])) {$product_video_title = $pinnacle['video_title_text'];} else {$product_video_title = __('Product Video', 'pinnacle');}
 echo '<h3>'.$product_video_title.'</h3>';
 echo '<div class="videofit product_video_case">'.$videocode.'</div>';
}
}
function kad_product_video_tab($tabs) {
  global $post, $pinnacle; if($videocode = get_post_meta( $post->ID, '_kad_product_video', true )) {
    if(!empty($pinnacle['video_tab_text'])) {$product_video_title = $pinnacle['video_tab_text'];} else {$product_video_title = __('Product Video', 'pinnacle');}
 $tabs['video_tab'] = array(
 'title' => $product_video_title,
 'priority' => 50,
 'callback' => 'kad_product_video_tab_content'
 );
}

 return $tabs;
}
// Number of products per page
add_filter('loop_shop_per_page', 'wooframework_products_per_page');
if (!function_exists('wooframework_products_per_page')) {
  function wooframework_products_per_page() {
    global $pinnacle;
    if ( isset( $pinnacle['products_per_page'] ) ) {
      return $pinnacle['products_per_page'];
    }
  }
}

// Display product tabs?
add_action('wp_head','wooframework_tab_check');
if ( ! function_exists( 'wooframework_tab_check' ) ) {
  function wooframework_tab_check() {
    global $pinnacle;
    if ( isset( $pinnacle[ 'product_tabs' ] ) && $pinnacle[ 'product_tabs' ] == "0" ) {
      remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    }
  }
}

// Display related products?
add_action('wp_head','wooframework_related_products');
if ( ! function_exists( 'wooframework_related_products' ) ) {
  function wooframework_related_products() {
    global $pinnacle;
    if ( isset( $pinnacle[ 'related_products' ] ) && $pinnacle[ 'related_products' ] == "0" ) {
      remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    }
  }
}
//add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
    if ( is_product_category() ){
      global $wp_query;
      $cat = $wp_query->get_queried_object();
      $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
      $image = wp_get_attachment_url( $thumbnail_id );
      global $pinnacle; if( isset( $pinnacle[ 'shop_layout' ] ) && $pinnacle[ 'shop_layout' ] == "sidebar" ) {$cat_width = 770;} else {$cat_width = 1170;}
      $sizeimage = aq_resize($image, $cat_width, 300, true);
      if ( $image ) {
        echo '<div class="cat_main_img"><img src="' . $sizeimage . '" alt="" /></div>';
    }
  }
}
// Change the tab title
add_filter( 'woocommerce_product_tabs', 'kad_woo_rename_tabs', 98 );
function kad_woo_rename_tabs( $tabs ) {
 global $pinnacle; 
  if(!empty($pinnacle['description_tab_text']) && !empty($tabs['description']['title'])) {$tabs['description']['title'] = $pinnacle['description_tab_text'];}
  if(!empty($pinnacle['additional_information_tab_text']) && !empty($tabs['additional_information']['title'])) {$tabs['additional_information']['title'] = $pinnacle['additional_information_tab_text'];}
  if(!empty($pinnacle['reviews_tab_text']) && !empty($tabs['reviews']['title'])) {$tabs['reviews']['title'] = $pinnacle['reviews_tab_text'];}
 
  return $tabs;
}
// Change the tab description heading
add_filter( 'woocommerce_product_description_heading', 'kad_description_tab_heading', 10, 1 );
function kad_description_tab_heading( $title ) {
  global $pinnacle; 
  if(!empty($pinnacle['description_header_text'])) {$title = $pinnacle['description_header_text'];}
  return $title;
}
// Change the tab aditional info heading
add_filter( 'woocommerce_product_additional_information_heading', 'kad_additional_information_tab_heading', 10, 1 );
function kad_additional_information_tab_heading( $title ) {
  global $pinnacle; 
  if(!empty($pinnacle['additional_information_header_text'])) {$title = $pinnacle['additional_information_header_text'];}
  return $title;
}

add_filter( 'woocommerce_product_tabs', 'kad_woo_reorder_tabs', 98 );
function kad_woo_reorder_tabs( $tabs ) {
  global $pinnacle; 
  if(isset($pinnacle['ptab_description'])) {$dpriority = $pinnacle['ptab_description'];} else {$dpriority = 10;}
  if(isset($pinnacle['ptab_additional'])) {$apriority = $pinnacle['ptab_additional'];} else {$apriority = 20;}
  if(isset($pinnacle['ptab_reviews'])) {$rpriority = $pinnacle['ptab_reviews'];} else {$rpriority = 30;}
  if(isset($pinnacle['ptab_video'])) {$vpriority = $pinnacle['ptab_video'];} else {$vpriority = 40;}
 
  if(!empty($tabs['description'])) $tabs['description']['priority'] = $dpriority;      // Description
  if(!empty($tabs['additional_information'])) $tabs['additional_information']['priority'] = $apriority; // Additional information 
  if(!empty($tabs['reviews'])) $tabs['reviews']['priority'] = $rpriority;     // Reviews 
  if(!empty($tabs['video_tab'])) $tabs['video_tab']['priority'] = $vpriority;      // Video second
 
  return $tabs;
}

add_filter('loop_shop_columns', 'kad_loop_columns');
  function kad_loop_columns() {
    global $pinnacle;
    if(isset($pinnacle['product_shop_layout']) && !empty($pinnacle['product_shop_layout'])) {
      return $pinnacle['product_shop_layout'];
    } else {
      return 4;
    }
}


// Add the custom tabs

function kad_custom_tab_01($tabs) {
  global $post; if($tab_content = get_post_meta( $post->ID, '_kad_tab_content_01', true )) {
    $tab_title = get_post_meta( $post->ID, '_kad_tab_title_01', true );
    $tab_priority = get_post_meta( $post->ID, '_kad_tab_priority_01', true ); 
    if(!empty($tab_title)) {$product_tab_title = $tab_title;} else {$product_tab_title = __('Custom Tab', 'pinnacle');}
    if(!empty($tab_priority)) {$product_tab_priority = esc_attr($tab_priority);} else {$product_tab_priority = 45;}
   $tabs['kad_custom_tab_01'] = array(
   'title' => $product_tab_title,
   'priority' => $product_tab_priority,
   'callback' => 'kad_product_custom_tab_content_01'
   );
  }

 return $tabs;
}
function kad_product_custom_tab_content_01() {
   global $post; $tab_content_01 = wpautop(get_post_meta( $post->ID, '_kad_tab_content_01', true ));
   echo do_shortcode('<div class="product_custom_content_case">'.__($tab_content_01).'</div>');
}
function kad_custom_tab_02($tabs) {
  global $post; if($tab_content = get_post_meta( $post->ID, '_kad_tab_content_02', true )) {
    $tab_title = get_post_meta( $post->ID, '_kad_tab_title_02', true );
    $tab_priority = get_post_meta( $post->ID, '_kad_tab_priority_02', true ); 
    if(!empty($tab_title)) {$product_tab_title = $tab_title;} else {$product_tab_title = __('Custom Tab', 'pinnacle');}
    if(!empty($tab_priority)) {$product_tab_priority = esc_attr($tab_priority);} else {$product_tab_priority = 50;}
   $tabs['kad_custom_tab_02'] = array(
   'title' => $product_tab_title,
   'priority' => $product_tab_priority,
   'callback' => 'kad_product_custom_tab_content_02'
   );
  }

 return $tabs;
}
function kad_product_custom_tab_content_02() {
   global $post; $tab_content_02 = wpautop(get_post_meta( $post->ID, '_kad_tab_content_02', true ));
   echo do_shortcode('<div class="product_custom_content_case">'.__($tab_content_02).'</div>');

}
function kad_custom_tab_03($tabs) {
  global $post; if($tab_content = get_post_meta( $post->ID, '_kad_tab_content_03', true )) {
    $tab_title = get_post_meta( $post->ID, '_kad_tab_title_03', true );
    $tab_priority = get_post_meta( $post->ID, '_kad_tab_priority_03', true ); 
    if(!empty($tab_title)) {$product_tab_title = $tab_title;} else {$product_tab_title = __('Custom Tab', 'pinnacle');}
    if(!empty($tab_priority)) {$product_tab_priority = esc_attr($tab_priority);} else {$product_tab_priority = 55;}
   $tabs['kad_custom_tab_03'] = array(
   'title' => $product_tab_title,
   'priority' => $product_tab_priority,
   'callback' => 'kad_product_custom_tab_content_03'
   );
  }

 return $tabs;
}
function kad_product_custom_tab_content_03() {
   global $post; $tab_content_03 = wpautop(get_post_meta( $post->ID, '_kad_tab_content_03', true ));
   echo do_shortcode('<div class="product_custom_content_case">'.__($tab_content_03).'</div>');
}

$pinnacle = get_option('pinnacle');
 if ( isset( $pinnacle['custom_tab_01'] ) && $pinnacle['custom_tab_01'] == 1 ) {
add_filter( 'woocommerce_product_tabs', 'kad_custom_tab_01');
}
if ( isset( $pinnacle['custom_tab_02'] ) && $pinnacle['custom_tab_02'] == 1 ) {
add_filter( 'woocommerce_product_tabs', 'kad_custom_tab_02');
}
if ( isset( $pinnacle['custom_tab_03'] ) && $pinnacle['custom_tab_03'] == 1 ) {
add_filter( 'woocommerce_product_tabs', 'kad_custom_tab_03');
}


// Shop Pages

if ( isset( $pinnacle['default_showproducttitle_inpost'] ) && $pinnacle['default_showproducttitle_inpost'] == 0 ) {
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'kt_hidden_woocommerce_template_single_title', 5 );

  function kt_hidden_woocommerce_template_single_title() {
    echo '<span itemprop="name" class="product_title kt_title_hidden entry-title">';
      the_title(); 
     echo '</span>';

  }
}


remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'kt_woocommerce_template_loop_product_title', 10);
function kt_woocommerce_template_loop_product_title() {
  echo '<h5>'.get_the_title().'</h5>';
}


/*
*
* WOO RADIO VARIATION 
*
*/
function kad_woo_variation_ratio_output() {
    if ( ! function_exists( 'kad_wc_radio_variation_attribute_options' ) ) {
        function kad_wc_radio_variation_attribute_options( $args = array() ) {
            $args['class'] = 'kt-no-select2';
            echo '<div class="kt-radio-variation-container">';
            kadence_variable_swatch_wc_dropdown_variation_attribute_options($args);
            kadence_wc_radio_variation_attribute_options($args);
            echo '</div>';
        }
    }
    if ( ! function_exists( 'kt_wc_radio_variation_attribute_options' ) ) {
      function kadence_wc_radio_variation_attribute_options( $args = array() ) {
        $args = wp_parse_args( $args, array(
          'options'          => false,
          'attribute'        => false,
          'product'          => false,
          'selected'         => false,
          'name'             => '',
          'id'               => ''
        ) );
        $options   = $args['options'];
        $product   = $args['product'];
        $attribute = $args['attribute'];
        $name      = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
        $id        = $args['id'] ? $args['id'] : sanitize_title( $attribute );
        if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
          $attributes = $product->get_variation_attributes();
          $options    = $attributes[ $attribute ];
        }
        echo '<fieldset class="kad_radio_variations" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';
        if ( ! empty( $options ) ) {
          if ( $product && taxonomy_exists( $attribute ) ) {
            // Get terms if this is a taxonomy - ordered. We need the names too.
            $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );
            foreach ( $terms as $term ) {
              if ( in_array( $term->slug, $options ) ) {
                echo '<label for="'. esc_attr( sanitize_title($name) ) . esc_attr( $term->slug ) . '"><input type="radio" value="' . esc_attr( $term->slug ) . '" ' . checked( sanitize_title( $args['selected'] ), $term->slug, false ) . ' id="'. esc_attr( sanitize_title($name) ) . esc_attr( $term->slug ) . '" name="'. sanitize_title($name).'">' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</label>';
              }
            }
          } else {
            foreach ( $options as $option ) {
              // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
              $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? checked( $args['selected'], sanitize_title( $option ), false ) : checked( $args['selected'], $option, false );
              echo '<label for="'. esc_attr( sanitize_title($name) ) . esc_attr( sanitize_title( $option ) ) .'"><input type="radio" value="' . esc_attr( $option ) . '" ' . $selected . ' id="'. esc_attr( sanitize_title($name) ) . esc_attr( sanitize_title( $option ) ) .'" name="'. sanitize_title($name).'">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</label>';
            }
          }
        }
        echo '</fieldset>';
      }
    }

    function kadence_variable_swatch_wc_dropdown_variation_attribute_options( $args = array() ) {
        $args = wp_parse_args( apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ), array(
            'options'          => false,
            'attribute'        => false,
            'product'          => false,
            'selected'         => false,
            'name'             => '',
            'id'               => '',
            'class'            => '',
            'show_option_none' => __( 'Choose an option', 'pinnacle' )
        ) );

        $options   = $args['options'];
        $product   = $args['product'];
        $attribute = $args['attribute'];
        $name      = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
        $id        = $args['id'] ? $args['id'] : sanitize_title( $attribute );
        $class     = $args['class'];

        if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
            $attributes = $product->get_variation_attributes();
            $options    = $attributes[ $attribute ];
        }

        $html = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

        if ( $args['show_option_none'] ) {
            $html .= '<option value="">' . esc_html( $args['show_option_none'] ) . '</option>';
        }

        if ( ! empty( $options ) ) {
            if ( $product && taxonomy_exists( $attribute ) ) {
                // Get terms if this is a taxonomy - ordered. We need the names too.
                $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                foreach ( $terms as $term ) {
                    if ( in_array( $term->slug, $options ) ) {
                        $html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
                    }
                }
            } else {
                foreach ( $options as $option ) {
                    // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
                    $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
                    $html .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
                }
            }
        }

        $html .= '</select>';

        echo apply_filters( 'woocommerce_dropdown_variation_attribute_options_html', $html );
    }
}
add_action( 'init', 'kad_woo_variation_ratio_output');

remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
add_action( 'woocommerce_single_variation', 'kt_woocommerce_single_variation', 10 );
add_action( 'woocommerce_single_variation', 'kt_woocommerce_single_variation_add_to_cart_button', 20 );

if ( ! function_exists( 'kt_woocommerce_single_variation_add_to_cart_button' ) ) {
  /**
   * Output the add to cart button for variations.
   */
  function kt_woocommerce_single_variation_add_to_cart_button() {
    global $product;
    ?>
    <div class="variations_button">
      <?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
      <button type="submit" class="kad_add_to_cart headerfont kad-btn kad-btn-primary single_add_to_cart_button"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
      <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
      <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
      <input type="hidden" name="variation_id" class="variation_id" value="" />
    </div>
    <?php
  }
}

if ( ! function_exists( 'kt_woocommerce_single_variation' ) ) {
  /**
   * Output placeholders for the single variation.
   */
  function kt_woocommerce_single_variation() {
    echo '<div class="single_variation headerfont"></div>';
  }
}

/*
*
* WOO ARCHIVE IMAGES
*
*/
function kad_woo_archive_image_output() {
    function kad_woocommerce_image_link_open() {
        echo  '<a href="'.get_the_permalink().'" class="product_item_link product_img_link">';
    }
    add_action( 'woocommerce_before_shop_loop_item_title', 'kad_woocommerce_image_link_open', 5 );
    function kad_woocommerce_image_link_close() {
        echo '</a>';
    }
    add_action( 'woocommerce_before_shop_loop_item_title', 'kad_woocommerce_image_link_close', 50 );

    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
    add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 5 );

    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    add_action( 'woocommerce_before_shop_loop_item_title', 'kt_woocommerce_template_loop_product_thumbnail', 10 );
    function kt_woocommerce_template_loop_product_thumbnail() {
    global $product, $woocommerce_loop, $pinnacle, $post;

    $product_column = $woocommerce_loop['columns'];

    if ($product_column == '1') {
        $productimgwidth = 400;
    } else if ($product_column == '2') {
        $productimgwidth = 560;
    } else if ($product_column == '3'){
        $productimgwidth = 400;
    } else if ($product_column == '6'){
        $productimgwidth = 240;
    } else if ($product_column == '5'){
        $productimgwidth = 240;
    } else {
        $productimgwidth = 300;
    }

    if(isset($pinnacle['product_img_flip']) && $pinnacle['product_img_flip'] == 0) {
      $productimgflip = 0;
    } else {
      $productimgflip = 1;
    }
    if(isset($pinnacle['product_img_resize']) && $pinnacle['product_img_resize'] == 0) {
      $resizeimage = 0;
    } else {
      $resizeimage = 1;
        if(isset($pinnacle['shop_img_ratio'])) {$img_ratio = $pinnacle['shop_img_ratio'];} else {$img_ratio = 'square';}
        if($img_ratio == 'portrait') {
              $tempproductimgheight = $productimgwidth * 1.35;
              $productimgheight = floor($tempproductimgheight);
        } else if($img_ratio == 'landscape') {
              $tempproductimgheight = $productimgwidth / 1.35;
              $productimgheight = floor($tempproductimgheight);
        } else if($img_ratio == 'widelandscape') {
              $tempproductimgheight = $productimgwidth / 2;
              $productimgheight = floor($tempproductimgheight);
        } else {
              $productimgheight = $productimgwidth;
        }
    }

    if($productimgflip == 1 && $resizeimage == 1) {
    	if ( version_compare( WC_VERSION, '3.0', '>' ) ) {
        	$attachment_ids = $product->get_gallery_image_ids();
        } else {
        	$attachment_ids = $product->get_gallery_attachment_ids();
        }
        if ( $attachment_ids ) {$flipclass = "kad-product-flipper";} else {$flipclass = "kad-product-noflipper";}
        if ( has_post_thumbnail() ) {
          $image_id = get_post_thumbnail_id( $post->ID );
          $product_image_array = wp_get_attachment_image_src( $image_id, 'full' ); 
          $product_image_url = $product_image_array[0];

          $img_src = aq_resize($product_image_url, $productimgwidth, $productimgheight, true);
          if(empty($img_src)) {$img_src = $product_image_url; }
          // Get srcset
          $img_srcset_output = kt_get_srcset_output( $productimgwidth, $productimgheight, $product_image_url, $image_id);
          // Get alt and fall back to title if no alt
          $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
          if(empty($alt_text)) {$alt_text = get_the_title();}
           $pclass = '';
        } else {
          $img_src = wc_placeholder_img_src();
          $alt_text = get_the_title();
          $img_srcset_output =  '';
          $pclass = 'wc-placeholder-img';
        } 
        ?> 
        <div class="<?php echo esc_attr($flipclass);?> kt-product-intrinsic <?php echo esc_attr($pclass);?>" style="padding-bottom:<?php echo ($productimgheight/$productimgwidth) * 100; ?>%;">
              <div class="kad_img_flip image_flip_front">
                  <img width="<?php echo esc_attr($productimgwidth);?>" height="<?php echo esc_attr($productimgheight);?>" 
                      src="<?php echo esc_url($img_src);?>"
                      <?php echo $img_srcset_output;?>
                      class="attachment-shop_catalog size-<?php echo esc_attr($productimgwidth.'x'.$productimgheight);?> wp-post-image"
                      alt="<?php echo esc_attr($alt_text); ?>">
                      <div class="kad-action-case"></div>
                </div>
                <?php 
                if ( $attachment_ids ) {
                      $secondary_image_id = $attachment_ids['0'];
                      $second_product_image_url = wp_get_attachment_image_src( $secondary_image_id, 'full');
                      $second_product_image_url = $second_product_image_url[0]; 
                      $second_image_product = aq_resize($second_product_image_url, $productimgwidth, $productimgheight, true);
                      if(empty($second_image_product)) {$second_image_product = $second_product_image_url;}
                        // Get alt and fall back to title if no alt
                        $alt_text = get_post_meta($secondary_image_id, '_wp_attachment_image_alt', true);
                        if(empty($alt_text)) {$alt_text = get_the_title();}

                      ?>
                   <div class="kad_img_flip image_flip_back">
                      <img width="<?php echo esc_attr($productimgwidth);?>" height="<?php echo esc_attr($productimgheight);?>" 
                      src="<?php echo esc_attr($second_image_product);?>"
                      <?php echo kt_get_srcset_output( $productimgwidth, $productimgheight, $second_product_image_url, $secondary_image_id); ?>
                      class="attachment-shop_catalog size-<?php echo esc_attr($productimgwidth.'x'.$productimgheight);?> wp-post-image" 
                      alt="<?php echo esc_attr($alt_text); ?>">
                      <div class="kad-action-case"></div>
                    </div>

                <?php 
                }
          echo '</div>';
      } else if ( $resizeimage == 1 ) {
          if ( has_post_thumbnail() ) {
             $image_id = get_post_thumbnail_id( $post->ID );
              $product_image_array = wp_get_attachment_image_src( $image_id, 'full' ); 
              $product_image_url = $product_image_array[0];

              $img_src = aq_resize($product_image_url, $productimgwidth, $productimgheight, true);
              if(empty($img_src)) {$img_src = $product_image_url; }
              $img_srcset_output = kt_get_srcset_output( $productimgwidth, $productimgheight, $product_image_url, $image_id);
              // Get alt and fall back to title if no alt
              $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
              if(empty($alt_text)) {$alt_text = get_the_title();}
               $pclass = '';
          } else {
            $img_src = wc_placeholder_img_src();
            $alt_text = get_the_title();
            $img_srcset_output = '';
            $pclass = 'wc-placeholder-img';
          } 	
          ?> 
          <div class="kad-product-noflipper kt-product-intrinsic <?php echo esc_attr($pclass);?>" style="padding-bottom:<?php echo ($productimgheight/$productimgwidth) * 100; ?>%;">
            <img width="<?php echo esc_attr($productimgwidth);?>" height="<?php echo esc_attr($productimgheight);?>" 
                src="<?php echo esc_url($img_src);?>"
                <?php echo $img_srcset_output; ?>
                class="attachment-shop_catalog size-<?php echo esc_attr($productimgwidth.'x'.$productimgheight);?> wp-post-image"
                alt="<?php echo esc_attr($alt_text); ?>">
          </div>
          <div class="kad-action-case"></div>
              <?php
      } else { 
        echo '<div class="kad-woo-image-size">';
        echo woocommerce_template_loop_product_thumbnail();
        echo '</div><div class="kad-action-case"></div>';
      }
  }
}
add_action( 'init', 'kad_woo_archive_image_output');


remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
add_action( 'woocommerce_shop_loop_subcategory_title', 'kt_woocommerce_template_loop_category_title', 10 );

 function kt_woocommerce_template_loop_category_title( $category ) {
        ?>
        <h5>
            <?php
                echo $category->name;

                if ( $category->count > 0 )
                    echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
            ?>
        </h5>
        <?php
    }



function kt_add_class_woocommerce_loop_add_to_cart_link($array, $product) {
  $array['class'] .= ' kad-btn headerfont kad_add_to_cart';
  return $array;
}   
add_filter('woocommerce_loop_add_to_cart_args', 'kt_add_class_woocommerce_loop_add_to_cart_link', 10, 2);

remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );
add_action( 'woocommerce_before_subcategory', 'kt_woocommerce_template_loop_category_link_open', 10 );
add_action( 'woocommerce_after_subcategory', 'kt_woocommerce_template_loop_category_link_close', 10 );

function kt_woocommerce_template_loop_category_link_open( $category ) {
    echo '<a href="' . get_term_link( $category->slug, 'product_cat' ) . '">';
}
function kt_woocommerce_template_loop_category_link_close() {
    echo '</a>';
}

function kt_woocommerce_product_nav() {
global $pinnacle;
if(isset($pinnacle['product_nav']) && $pinnacle['product_nav'] == '1') {?>
    <div class="productnav">
        <?php previous_post_link_plus( array('order_by' => 'menu_order', 'loop' => true, 'in_same_tax' => true, 'format' => '%link', 'link' => '<i class="kt-icon-arrow-left"></i>') ); ?>
        <?php next_post_link_plus( array('order_by' => 'menu_order', 'loop' => true, 'in_same_tax' => true, 'format' => '%link', 'link' => '<i class="kt-icon-arrow-right"></i>') ); ?>
    </div>
    <?php } 
}
add_action( 'woocommerce_single_product_summary', 'kt_woocommerce_product_nav', 1 );

/*
*
* WOO ARCHIVE CAT IMAGES
*
*/
function kad_woo_archive_cat_image_output() {
    remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
    add_action( 'woocommerce_before_subcategory_title', 'kad_woocommerce_subcategory_thumbnail', 10 );
    function kad_woocommerce_subcategory_thumbnail($category) {
        global $woocommerce_loop, $pinnacle;
        
        if(is_shop() || is_product_category() || is_product_tag()) {
            if(isset($pinnacle['product_cat_layout']) && !empty($pinnacle['product_cat_layout'])) {
                $product_cat_column = $pinnacle['product_cat_layout'];
            } else {
                $product_cat_column = 4;
            }
        } else {
            if ( empty( $woocommerce_loop['columns'] ) ) {
                $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
            }
            $product_cat_column = $woocommerce_loop['columns'];
        }

        if ($product_cat_column == '1') {
            $catimgwidth = 600;
        } else if ($product_cat_column == '2') {
            $catimgwidth = 600;
        } else if ($product_cat_column == '3'){
            $catimgwidth = 400;
        } else if ($product_cat_column == '6'){
            $catimgwidth = 240;
        } else if ($product_cat_column == '5'){ 
            $catimgwidth = 240;
        } else {
            $catimgwidth = 300;
        }

        if(!is_shop() && !is_product_category() && !is_product_tag()) {
            $woocommerce_loop['columns'] = $product_cat_column;
        }
        if(isset($pinnacle['product_cat_img_ratio'])) {
            $img_ratio = $pinnacle['product_cat_img_ratio'];
        } else {
            $img_ratio = 'widelandscape';
        }

        if($img_ratio == 'portrait') {
                $tempcatimgheight = $catimgwidth * 1.35;
                $catimgheight = floor($tempcatimgheight);
        } else if($img_ratio == 'landscape') {
                $tempcatimgheight = $catimgwidth / 1.35;
                $catimgheight = floor($tempcatimgheight);
        } else if($img_ratio == 'square') {
                $catimgheight = $catimgwidth;
        } else {
                $tempcatimgheight = $catimgwidth / 2;
                $catimgheight = floor($tempcatimgheight);
        }
        // OUTPUT 

        if($img_ratio == 'off') {
                woocommerce_subcategory_thumbnail($category);
        } else {
            $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
            if ( $thumbnail_id ) {
                $image_cat_src = wp_get_attachment_image_src( $thumbnail_id, 'full');
                $image_cat_url = $image_cat_src[0];
                $cat_image = aq_resize($image_cat_url, $catimgwidth, $catimgheight, true, false, false, $thumbnail_id);
                if(empty($cat_image[0])) {$cat_image = array($image_cat_url,$image_cat_src[1],$image_cat_src[2]);} 
                $img_srcset_output = kt_get_srcset_output( $catimgwidth, $catimgheight, $image_cat_url, $thumbnail_id);

            } else {
                $cat_image = array(pinnacle_img_placeholder_cat(),$catimgwidth,$catimgheight); 
                $img_srcset_output = '';
            }
            if ( $cat_image[0] ) {
                    echo '<div class="kt-cat-intrinsic" style="padding-bottom:'. ($cat_image[2]/$cat_image[1]) * 100 .'%;">';
                    echo '<img src="' . esc_url($cat_image[0]) . '" width="'.esc_attr($cat_image[1]).'" height="'.esc_attr($cat_image[2]).'" alt="' . esc_attr($category->name) . '" '.$img_srcset_output.' />';
                    echo '</div>';
            }
        }

    }
}
add_action( 'init', 'kad_woo_archive_cat_image_output');


<?php
// Custom post types
if ( !is_plugin_active('virtue-toolkit/virtue_toolkit.php') ) {
function kadence_portfolio_post_init() {
  $portfoliolabels = array(
    'name' =>  __('Portfolio', 'pinnacle'),
    'singular_name' => __('Portfolio Item', 'pinnacle'),
    'add_new' => __('Add New', 'pinnacle'),
    'add_new_item' => __('Add New Portfolio Item', 'pinnacle'),
    'edit_item' => __('Edit Portfolio Item', 'pinnacle'),
    'new_item' => __('New Portfolio Item', 'pinnacle'),
    'all_items' => __('All Portfolio', 'pinnacle'),
    'view_item' => __('View Portfolio Item', 'pinnacle'),
    'search_items' => __('Search Portfolio', 'pinnacle'),
    'not_found' =>  __('No Portfolio Item found', 'pinnacle'),
    'not_found_in_trash' => __('No Portfolio Items found in Trash', 'pinnacle'),
    'parent_item_colon' => '',
    'menu_name' => __('Portfolio', 'pinnacle')
  );

  $portargs = array(
    'labels' => $portfoliolabels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite'  => false,
    //'rewrite'  => array( 'slug' => 'portfolio' ), /* you can specify its url slug */
    'has_archive' => false, 
    'capability_type' => apply_filters('kadence_portfolio_capability_type','post'), 
    'map_meta_cap' =>  apply_filters('kadence_portfolio_map_meta_cap',null),
    'hierarchical' => false,
    'menu_position' => 8,
    'menu_icon' => 'dashicons-format-gallery',
    'supports' => array( 'title', 'excerpt', 'editor', 'author', 'page-attributes', 'thumbnail', 'comments' )
  ); 
  // Initialize Taxonomy Labels
    $worklabels = array(
        'name' => __( 'Portfolio Type', 'pinnacle' ),
        'singular_name' => __( 'Type', 'pinnacle' ),
        'search_items' =>  __( 'Search Type', 'pinnacle' ),
        'all_items' => __( 'All Type', 'pinnacle' ),
        'parent_item' => __( 'Parent Type', 'pinnacle' ),
        'parent_item_colon' => __( 'Parent Type:', 'pinnacle' ),
        'edit_item' => __( 'Edit Type', 'pinnacle' ),
        'update_item' => __( 'Update Type', 'pinnacle' ),
        'add_new_item' => __( 'Add New Type', 'pinnacle' ),
        'new_item_name' => __( 'New Type Name', 'pinnacle' ),
    );
    $portfolio_type_slug = apply_filters('kadence_portfolio_type_slug', 'portfolio-type');
    // Register Custom Taxonomy
    register_taxonomy('portfolio-type',array('portfolio'), array(
        'hierarchical' => true, // define whether to use a system like tags or categories
        'labels' => $worklabels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite'  => array( 'slug' => $portfolio_type_slug )
    ));
    $taglabels = array(
        'name' => __( 'Portfolio Tags', 'pinnacle' ),
        'singular_name' => __( 'Tags', 'pinnacle' ),
        'search_items' =>  __( 'Search Tags', 'pinnacle' ),
        'all_items' => __( 'All Tag', 'pinnacle' ),
        'parent_item' => __( 'Parent Tag', 'pinnacle' ),
        'parent_item_colon' => __( 'Parent Tag:', 'pinnacle' ),
        'edit_item' => __( 'Edit Tag', 'pinnacle' ),
        'update_item' => __( 'Update Tag', 'pinnacle' ),
        'add_new_item' => __( 'Add New Tag', 'pinnacle' ),
        'new_item_name' => __( 'New Tag Name', 'pinnacle' ),
    );
    $portfolio_tag_slug = apply_filters('kadence_portfolio_tag_slug', 'portfolio-tag');
    // Register Custom Taxonomy
    register_taxonomy('portfolio-tag',array('portfolio'), array(
        'hierarchical' => false,
        'labels' => $taglabels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite'  => array( 'slug' => $portfolio_tag_slug )
    ));

  register_post_type( 'portfolio', $portargs );
}
add_action( 'init', 'kadence_portfolio_post_init', 1 );
}
    
function testimonial_post_init() {
  $testlabels = array(
    'name' =>  __('Testimonials', 'pinnacle'),
    'singular_name' => __('Testimonial', 'pinnacle'),
    'add_new' => __('Add New', 'pinnacle'),
    'add_new_item' => __('Add New Testimonial', 'pinnacle'),
    'edit_item' => __('Edit Testimonial', 'pinnacle'),
    'new_item' => __('New Testimonial', 'pinnacle'),
    'all_items' => __('All Testimonials', 'pinnacle'),
    'view_item' => __('View Testimonial', 'pinnacle'),
    'search_items' => __('Search Testimonials', 'pinnacle'),
    'not_found' =>  __('No Testimonials found', 'pinnacle'),
    'not_found_in_trash' => __('No Testimonials found in Trash', 'pinnacle'),
    'parent_item_colon' => '',
    'menu_name' => __('Testimonials', 'pinnacle')
  );
   $testimonial_post_slug = apply_filters('kadence_testimonial_post_slug', 'testimonial');
  $testargs = array(
    'labels' => $testlabels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => $testimonial_post_slug ),
    'capability_type' => apply_filters('kadence_testimonial_capability_type','post'),
    'map_meta_cap' =>  apply_filters('kadence_testimonial_map_meta_cap',null),
    'has_archive' => false,  
    'hierarchical' => false,
    'menu_position' => 22,
    'menu_icon' => 'dashicons-testimonial',
    'supports' => array( 'title', 'editor', 'excerpt', 'page-attributes', 'thumbnail' )
  ); 

  // Initialize Taxonomy Labels
    $taxlabels = array(
        'name' => __( 'Testimonial Group', 'pinnacle' ),
        'singular_name' => __( 'Testimonials', 'pinnacle' ),
        'search_items' =>  __( 'Search Groups', 'pinnacle' ),
        'all_items' => __( 'All Groups', 'pinnacle' ),
        'parent_item' => __( 'Parent Groups', 'pinnacle' ),
        'parent_item_colon' => __( 'Parent Groups:', 'pinnacle' ),
        'edit_item' => __( 'Edit Group', 'pinnacle' ),
        'update_item' => __( 'Update Group', 'pinnacle' ),
        'add_new_item' => __( 'Add New Group', 'pinnacle' ),
        'new_item_name' => __( 'New Group Name', 'pinnacle' ),
    );
    $testimonial_group_slug = apply_filters('kadence_testimonial_group_slug', 'testimonial-group');
    // Register Custom Taxonomy
    register_taxonomy('testimonial-group',array('testimonial'), array(
        'hierarchical' => true, // define whether to use a system like tags or categories
        'labels' => $taxlabels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite'  => array( 'slug' => $testimonial_group_slug )
    ));

  register_post_type( 'testimonial', $testargs );
}
add_action( 'init', 'testimonial_post_init' );

function staff_post_init() {
  $stafflabels = array(
    'name' =>  __('Staff', 'pinnacle'),
    'singular_name' => __('Staff', 'pinnacle'),
    'add_new' => __('Add New', 'pinnacle'),
    'add_new_item' => __('Add New Staff', 'pinnacle'),
    'edit_item' => __('Edit Staff', 'pinnacle'),
    'new_item' => __('New Staff', 'pinnacle'),
    'all_items' => __('All Staff', 'pinnacle'),
    'view_item' => __('View Staff', 'pinnacle'),
    'search_items' => __('Search Staff', 'pinnacle'),
    'not_found' =>  __('No Staff found', 'pinnacle'),
    'not_found_in_trash' => __('No Staff found in Trash', 'pinnacle'),
    'parent_item_colon' => '',
    'menu_name' => __('Staff', 'pinnacle')
  );
  $staff_post_slug = apply_filters('kadence_staff_post_slug', 'staff');
  $staffargs = array(
    'labels' => $stafflabels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => $staff_post_slug ),
    'capability_type' => apply_filters('kadence_staff_capability_type','post'),
    'map_meta_cap' =>  apply_filters('kadence_staff_map_meta_cap',null),
    'has_archive' => false, 
    'hierarchical' => false,
    'menu_position' => 23,
    'menu_icon' => 'dashicons-id-alt',
    'supports' => array( 'title', 'editor', 'excerpt', 'page-attributes', 'thumbnail' )
  ); 
  // Initialize Taxonomy Labels
    $grouplabels = array(
        'name' => __( 'Staff Group', 'pinnacle' ),
        'singular_name' => __( 'Staff', 'pinnacle' ),
        'search_items' =>  __( 'Search Groups', 'pinnacle' ),
        'all_items' => __( 'All Groups', 'pinnacle' ),
        'parent_item' => __( 'Parent Groups', 'pinnacle' ),
        'parent_item_colon' => __( 'Parent Groups:', 'pinnacle' ),
        'edit_item' => __( 'Edit Group', 'pinnacle' ),
        'update_item' => __( 'Update Group', 'pinnacle' ),
        'add_new_item' => __( 'Add New Group', 'pinnacle' ),
        'new_item_name' => __( 'New Group Name', 'pinnacle' ),
    );
    $staff_group_slug = apply_filters('kadence_staff_group_slug', 'staff-group');
    // Register Custom Taxonomy
    register_taxonomy('staff-group',array('staff'), array(
        'hierarchical' => true, // define whether to use a system like tags or categories
        'labels' => $grouplabels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite'  => array( 'slug' => $staff_group_slug )
    ));

  register_post_type( 'staff', $staffargs );
}
add_action( 'init', 'staff_post_init' );


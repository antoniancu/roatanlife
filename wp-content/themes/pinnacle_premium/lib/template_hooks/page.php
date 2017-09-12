<?php

/**
 * Page Hooks
 */

add_action('kadence_page_footer', 'pinnacle_page_comments');
function pinnacle_page_comments() {
 global $pinnacle;
 if(isset($pinnacle['page_comments']) && $pinnacle['page_comments'] == 1) {
  comments_template('/templates/comments.php');
 }
}

// Footer

function kt_sitewide_shortcode_output() {
  global $pinnacle;

  if(isset($pinnacle['sitewide_footer_shortcode_input']) && !empty($pinnacle['sitewide_footer_shortcode_input'])) {
    echo '<div class="clearfix kt_footer_sitewide_shortcode">';
    echo do_shortcode($pinnacle['sitewide_footer_shortcode_input']);
    echo '</div>';
  }
}
add_action('kt_before_footer', 'kt_sitewide_shortcode_output', 10 );

function kt_sitewide_calltoaction_output() {

  global $pinnacle;

  if(isset($pinnacle['sitewide_calltoaction']) && $pinnacle['sitewide_calltoaction'] == 1) { 
    get_template_part('templates/sitewide', 'action'); 
  }
}
add_action('kt_before_footer', 'kt_sitewide_calltoaction_output', 20 );
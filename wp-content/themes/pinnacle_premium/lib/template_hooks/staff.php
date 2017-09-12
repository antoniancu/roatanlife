<?php

/**
 * staffHooks
 */


function kt_staff_links() {
    get_template_part('templates/content', 'loop-staff-meta'); 
}
add_action('kt_staff_footer', 'kt_staff_links', 20 );
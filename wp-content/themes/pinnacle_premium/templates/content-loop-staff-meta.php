<?php
/*
Template: Staff Grid Loop Meta
*/

global $post;
    echo '<div class="kadence_social_widget">';
    $staff_email = get_post_meta( $post->ID, '_kad_staff_email', true );
    $staff_phone = get_post_meta( $post->ID, '_kad_staff_phone', true );
    $staff_facebook = get_post_meta( $post->ID, '_kad_staff_facebook', true );
    $staff_twitter = get_post_meta( $post->ID, '_kad_staff_twitter', true );
    $staff_instagram = get_post_meta( $post->ID, '_kad_staff_instagram', true );
    $staff_linkedin = get_post_meta( $post->ID, '_kad_staff_linkedin', true ); 
    if(!empty($staff_email)) {
        echo '<a href="mailto:'.esc_attr($staff_email).'" target="_blank" class="email_link" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Email', 'pinnacle').' '.get_the_title().'">';
        echo '<i class="kt-icon-mail4"></i>';
        echo '</a>';
    }
    if(!empty($staff_phone)) {
        echo '<a href="tel:'.esc_attr($staff_phone).'" target="_blank" class="phone_link" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Call', 'pinnacle').' '.get_the_title().'">';
        echo '<i class="kt-icon-mobile2"></i>';
        echo '</a>';
    }
    if(!empty($staff_facebook)) { 
        echo '<a href="'.esc_url($staff_facebook).'" target="_blank" class="facebook_link" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Follow', 'pinnacle').' '.get_the_title().' '.__('on Facebook', 'pinnacle').'">';
        echo '<i class="kt-icon-facebook3"></i>';
        echo '</a>';
    } 
    if(!empty($staff_twitter)) { 
        echo '<a href="'.esc_url($staff_twitter).'" target="_blank" class="twitter_link" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Follow', 'pinnacle').' '.get_the_title().' '.__('on Twitter', 'pinnacle').'">';
        echo '<i class="kt-icon-twitter2"></i>';
        echo '</a>';
    } 
    if(!empty($staff_instagram)) { 
        echo '<a href="'.esc_url($staff_instagram).'" target="_blank" class="instagram_link" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Follow', 'pinnacle').' '.get_the_title().' '.__('on Instagram', 'pinnacle').'">';
        echo'<i class="kt-icon-instagram"></i>';
        echo '</a>';
    } 
    if(!empty($staff_linkedin)) { 
        echo '<a href="'.esc_url($staff_linkedin).'" target="_blank" class="linkedin_link" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Follow', 'pinnacle').' '.get_the_title().' '.__('on Linkedin', 'pinnacle').'">';
        echo '<i class="kt-icon-linkedin2"></i>';
        echo '</a>';
    }
    echo '</div>';
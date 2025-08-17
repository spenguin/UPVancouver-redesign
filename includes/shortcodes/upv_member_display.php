<?php
/**
 * Render Audition parts
 * (Might need to be extended or rebuilt if section is used elsewhere)
 */

function upv_member_display( $atts = [], $content = null, $tag = '' )
{
    extract(shortcode_atts(array(
        'name' => '',
        'title'=> ''
     ), $atts));

    if( empty($name)) return '';
    $ad     = get_post_by_title($name, '', 'member' ); 
    $url    = get_the_post_thumbnail_url($ad->ID);
    $o      = <<<EOD
        <section class="member-display">
            <h3>$title: <span>$ad->post_title</span></h3>
            <div class="member-display__wrapper">
                <div class="member-display--image">
                    <img src="$url" />
                </div>
                <div class="member-display--text">
                    $ad->post_content
                </div>
            </div>
        </section>
    EOD;

    return $o;
} 
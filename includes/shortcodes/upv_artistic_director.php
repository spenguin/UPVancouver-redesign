<?php
/**
 * Render Audition parts
 * (Might need to be extended or rebuilt if section is used elsewhere)
 */

function upv_artistic_director( $atts = [], $content = null, $tag = '' )
{
    extract(shortcode_atts(array(
        'name' => '',
     ), $atts));
    if( empty($name)) return '';
    $ad     = get_post_by_title($name, '', 'member' ); 
    $url    = get_the_post_thumbnail_url($ad->ID);
    $o      = <<<EOD
        <section class="artistic_director">
            <h3>Artistic Director: <span>$ad->post_title</span></h3>
            <div class="artistic_director__wrapper">
                <div class="artistic_director--image">
                    <img src="$url" />
                </div>
                <div class="artistic_director--text">
                    $ad->post_content
                </div>
            </div>
        </section>
    EOD;

    return $o;
} 
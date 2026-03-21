<?php
/**
 * Render wrapper for video
 */

function upv_display_video( $atts = [], $content = null, $tag = '' )
{
    if( !(isset($atts['display']) && $atts['display'] != "false" ) )
    {
        return '';
    } else {
        if( empty( $atts['videoid'] ) ) return '';
        
        return '<div class="video_wrapper" style="display:flex; justify-content:center;"><iframe src="https://player.vimeo.com/video/' . $atts['videoid'] . '?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479&amp;title=0&amp;byline=0&amp;portrait=0" width="640" height="360" frameborder=0;fullscreen; ></iframe><script src="https://player.vimeo.com/api/player.js"></script></div>';

    }
}
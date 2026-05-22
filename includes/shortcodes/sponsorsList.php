<?php
/**
 * Render Sponsors list
 */

namespace Shortcodes\SponsorsList;

add_shortcode( 'sponsorsList', '\Shortcodes\SponsorsList\sponsorsList' );

function sponsorsList( $atts = [], $content = null, $tag = '' )
{
   echo '<p>Sponsors</p>';
}
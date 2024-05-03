<?php

namespace Shortcodes;

require_once CORE_SHORTCODE . 'ws_show_season.php';

\Shortcodes\initialize();

function initialize()
{
    add_shortcode( 'ws_show_season', '\ws_show_season' );
}
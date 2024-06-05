<?php

namespace Shortcodes;

require_once CORE_SHORTCODE . 'ws_show_season.php';
require_once CORE_SHORTCODE . 'upv_cart.php';
require_once CORE_SHORTCODE . 'upv_checkout.php';

\Shortcodes\initialize();

function initialize()
{
    add_shortcode( 'ws_show_season', '\ws_show_season' );
    add_shortcode( 'upv_cart', '\upv_cart' );
    add_shortcode( 'upv_checkout', '\upv_checkout' );
}
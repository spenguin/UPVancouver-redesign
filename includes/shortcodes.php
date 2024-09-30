<?php

namespace Shortcodes;

require_once CORE_SHORTCODE . 'upv_show_season.php';
require_once CORE_SHORTCODE . 'upv_cart.php';
// require_once CORE_SHORTCODE . 'upv_checkout.php';
require_once CORE_SHORTCODE . 'upv_season_tickets.php';
require_once CORE_SHORTCODE . 'upv_confirm_order.php';
require_once CORE_SHORTCODE . 'upv_ticket_admin.php';
require_once CORE_SHORTCODE . 'upv_performance_report.php';
require_once CORE_SHORTCODE . 'upv_clear_sales.php';


\Shortcodes\initialize();

function initialize()
{
    add_shortcode( 'upv_show_season', '\upv_show_season' );
    add_shortcode( 'upv_cart', '\upv_cart' );
    // add_shortcode( 'upv_checkout', '\upv_checkout' );
    add_shortcode( 'upv_season_tickets', '\upv_season_tickets' );
    add_shortcode( 'upv_confirm_order', '\upv_confirm_order' );
    add_shortcode( 'upv_ticket_admin', '\upv_ticket_admin' );
    add_shortcode( 'upv_performance_report', '\upv_performance_report' );
    add_shortcode( 'upv_clear_sales', '\upv_clear_sales' );
}
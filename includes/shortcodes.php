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
require_once CORE_SHORTCODE . 'upv_audition_show_details.php';
require_once CORE_SHORTCODE . 'upv_audition_roles.php';
require_once CORE_SHORTCODE . 'upv_artistic_director.php';
require_once CORE_SHORTCODE . 'upv_member_display.php';


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
    add_shortcode( 'upv_audition_show_details', '\upv_audition_show_details' );
    add_shortcode( 'upv_audition_roles', '\upv_audition_roles' );
    add_shortcode( 'upv_artistic_director', '\upv_artistic_director' );
    add_shortcode( 'upv_member_display', '\upv_member_display' );
}
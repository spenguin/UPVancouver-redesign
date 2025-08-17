<?php
/**
 * Present season tickets purchase functionality
 * preceded by the shows the tickets will purchase
 * 
 */

function upv_season_tickets()
{
    $display_next_season = get_option('display_next_season'); 
    if( $display_next_season ) return;
    // Which season are we in?
    $season = get_season_ticket_season();
    ob_start();
    ?>
    <div id="tickets" class="show-ticketing">
        <h4>Ticket Ordering</h4>
        <?php get_template_part('template-parts/select-tickets-for-performance'); ?>
    </div>
    <?php

    return ob_get_clean();
}



function get_season_ticket_season()
{
    global $wpdb;
    
    // Try first season
    $sql        = $wpdb->prepare(
        "SELECT * FROM `wpba_terms` WHERE `slug` LIKE %s",
        ['%' . date('Y') . '%']
    );
    $season     = $wpdb->get_results( $sql , ARRAY_A );

    $args   = [
        'post_type'         => 'show',
        'posts_per_page'    => -1,
        'tax_query'         => [
            [
            'taxonomy'      => 'season',
            'field'         => 'slug',
            'terms'         => $season[0]['slug']
            ]
        ],
        'meta_key'          => 'end_date',
        'meta_value'        => date('Y-m-d'),
        'meta_compare'      => '>='
    ];
    $query  = new WP_Query( $args ); 
    if( $query->post_count >= 3 ) return $query;

    // Okay,that didn't work. Try next season
    // $sql        = $wpdb->prepare(
    //     "SELECT * FROM `wpba_terms` WHERE `slug` LIKE %s",
    //     [date('Y'). '%']
    // );
    // $season     = $wpdb->get_results( $sql , ARRAY_A ); //pvd($season); 

    $args   = [
        'post_type'         => 'show',
        'posts_per_page'    => -1,
        'tax_query'         => [
            'taxonomy'      => 'season',
            'field'         => 'slug',
            'terms'         => $season[1]['slug']
        ],
        'meta_key'          => 'start_date',
        'meta_value'        => date('Y-m-d'),
        'meta_compare'      => '<='
    ]; 
    $query  = new WP_Query( $args );

    return $query;
}
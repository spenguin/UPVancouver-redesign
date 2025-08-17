<?php

/**
 * Bespoke code to for tickets
 */

/**
 * @author: John Anderson
 * @since: 7 August 2023
 * Get ticket details
 * @param (int) Show Id - if -1, then Season Ticket
 * @return (array)
 */
function getTickets( $showId )
{
    $seasonTickets  = $showId > 0 ? FALSE : TRUE;
    $showCount      = $showId > 0 ? 1 : getActiveSeasonShowCount();  // Need to actually determine number of remaining shows in the season
   
    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => [
            [
            'taxonomy'  => 'product_cat',
            'field'     => 'slug',
            'terms'     => $seasonTickets ? 'season-ticket' : 'single-show'
            ]
        ]
    ]; 
    $o  = [];
    $query = new WP_Query($args); 
    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); 
            $ticketId       = get_the_ID();
            // $ticket_charge  = get_post_meta($ticketId, 'ticket_charge', TRUE) * $showCount;
           $ticket_charge = get_post_meta($ticketId, '_regular_price', TRUE) * $showCount;
            $o[]   = [
                'ticketid'  => $ticketId,
                'name'      => get_the_title(),
                'charge'    => $ticket_charge,
                'quantity'  => 0
            ];
        endwhile;
    endif;
    wp_reset_postdata(); //pvd($o);
    return $o;
}

/**
 * @author: John Anderson
 * @since: 10 August 2023
 * Is the Season Ticket Special still available?
 * @return (bool)
 */
function isTicketSpecialAvailable()
{
    $options    = get_option('performance_options');
    return $options['performance_field_season_ticket_end_day'] >= date('Y-m-d');
}

/**
 * @author: John Anderson
 * @since: 18 June 2024
 * Count the number of shows left in the current season
 * @return (int)
 */
function getActiveSeasonShowCount()
{
    $shows = get_season_shows('current', 2, 'current' );
    return $shows->post_count > 2 ? $shows->post_count : 5; // Assumes 5 shows in the next season. BICBW
}


/**
 * @author: John Anderson
 * @since: 18 September 2024
 * Get All single show tickets, including Uncategorised
 * @return (array)
 */
function getSingleShowTickets()
{
    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => [
            [
            'taxonomy'  => 'product_cat',
            'field'     => 'slug',
            'terms'     => 'single-show'
            ]
        ]
    ]; 
    $o  = [];
    $query = new WP_Query($args); 
    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); 
        $o[get_the_ID()]    = strtolower(get_the_title());
    endwhile; endif; wp_reset_postdata(); 

    $comp   = get_post_by_title('Comp', '', 'product');
    $o[$comp->ID]   = 'comp'; //$comp->post_title;

    $season = get_post_by_title( 'Season Subscriber', '', 'product' );
    $o[$season->ID] = 'seasons'; //$season->post_title;
  
    wp_reset_postdata();
    return $o;

}

/**
 * Loop through the Notes to get the email statement
 * @param (array) order notes
 * @return (str) email statement
 */
function generate_statement($notes)
{
    $statementOrder = [
        'season-ticket' => 0,
        'donation'      => 4
    ];
    
    $o  = [];
    foreach( $notes as $ticket_id => $note )
    {
        $ticket = get_post($ticket_id); 
        $term   = reset(get_the_terms($ticket_id, 'product_cat')); 

    }
}

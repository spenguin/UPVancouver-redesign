<?php

/**
 * Bespoke code to for tickets
 */

// function offer_tickets()
// {
//     $args = array(
//         'post_type' => 'product',
//         'posts_per_page' => -1
//     );
//     $loop = new WP_Query($args);
//     if ($loop->have_posts()) {
//         while ($loop->have_posts()) : $loop->the_post();
//             get_template_part('template-parts/content', get_post_type());
//         endwhile;
//     } else {
//         echo __('No products found');
//     }
//     wp_reset_postdata();
// }

/**
 * Get tickets as an array
 */
// function get_tickets()
// {
//     $args = array(
//         'post_type' => 'ticket',
//         'posts_per_page' => -1
//     );
//     $o  = [];
//     $loop = new WP_Query($args);
//     if ($loop->have_posts()) :
//         while ($loop->have_posts()) : $loop->the_post();
//             $ticketId       = get_the_ID();
//             $ticket_charge  = get_post_meta($ticketId, 'ticket_charge', TRUE);
//             $o[]   = [
//                 'ticketid'  => $ticketId,
//                 'name'      => get_the_title(),
//                 'charge'    => $ticket_charge,
//                 'quantity'  => 0
//             ];
//         endwhile;
//     endif;
//     wp_reset_postdata();
//     return $o;
// }

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

    // return [
    //     [
    //         'ticketid'  => 1,
    //         'name'      => 'Adult',
    //         'charge'    => 39.00,
    //         'quantity'  => 0
    //     ],
    //     [
    //         'ticketid'  => 2,
    //         'name'      => 'Senior',
    //         'charge'    => 34.00,
    //         'quantity'  => 0
    //     ],
    //     [
    //         'ticketid'  => 1,
    //         'name'      => 'Student',
    //         'charge'    => 15.00,
    //         'quantity'  => 0
    //     ],  
    //     [
    //         'ticketid'  => 4,
    //         'name'      => 'Preview',
    //         'charge'    => 15.00,
    //         'quantity'  => 0
    //     ],                        
    // ];
    
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
    return 3; // For now
}

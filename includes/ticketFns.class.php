<?php
/**
 * Ticket  Functions class
 */
class ticketFns
{
    /**
     * @author: John Anderson
     * @since: 7 August 2023
     * Get ticket details
     * @param (int) Show Id - if -1, then Season Ticket
     * @return (array)
     */
    static function getTickets( $showId )
    {
        $seasonTickets  = $showId > 0 ? FALSE : TRUE;
        $showCount      = $showId > 0 ? 1 : self::getActiveSeasonShowCount();  // Need to actually determine number of remaining shows in the season
    
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
    static function isTicketSpecialAvailable()
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
    static function getActiveSeasonShowCount()
    {
        $shows = showFns::getSeasonShows('current', 2, 'current' );
        return $shows->post_count > 2 ? $shows->post_count : 5; // Assumes 5 shows in the next season. BICBW
    }    

    /**
     * @author: John Anderson
     * @since: 18 September 2024
     * Get All single show tickets, including Uncategorised
     * @return (array)
     */
    static function getSingleShowTickets()
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

        $comp   = siteFns::getPostByTitle('Comp', '', 'product');
        $o[$comp->ID]   = 'comp'; //$comp->post_title;

        $season = siteFns::getPostByTitle( 'Season Subscriber', '', 'product' );
        $o[$season->ID] = 'seasons'; //$season->post_title;
    
        wp_reset_postdata();
        return $o;

    }

    /**
     * @author: John Anderson
     * @since: 16 March 2026
     * Count the number of Tickets in an order that is either Complete or Box Office
     * @return (int)
     */
    static function countTicketsInOrder($orderId)
    {
        $order  = new WC_Order( $order_id );
        $status = $order->get_status();
        if( $status == "cancelled") return 0;
        $orderNotes    = get_order_note($orderId); 
        if( empty( $orderNotes) ) return 0;
        $o      = 0;
        foreach( $orderNotes as $key => $ticketOrder )
        {
            if( $ticketOrder === TRUE ) continue; // FIX
            if( $key == "amended" ) continue; // Are there other keys I need to check for?
            if( $key == "customer_contact" ) continue;
            if( $key == "fees" ) continue;
            if( $ticket_order['name'] == "Donation" ) continue;
            $o  += $ticketOrder['quantity'];            
        }
        return $o;
    }


        //     foreach( $order_notes as $key => $ticket_order )
        // {
        //     if( $ticket_order === TRUE ) continue; // FIX
        //     if( $key == "amended" ) continue; // Are there other keys I need to check for?
        //     if( $key == "customer_contact" ) continue;
        //     if( $key == "fees" ) continue;
        //     if( $ticket_order['name'] == "Donation" ) continue;
        //     if( !isset($ticket_order['performance_title'] ) )
        //     { 
        //         $ticket_order['performance_title'] = strtotime( $ticket_order['date'] . ' ' . $ticket_order['time'] );
        //     } 
        //     if( $ticket_order['performance_title'] != (int) $performance->post_title ) continue; // Not for this performance
        //     // $ticket_name = in_array($ticket_order['name'], ['Season', 'Seasons', 'Season Subsc']) ? 'Season' : $ticket_order['name']; // Another kludge
        //     $ticket_name = str_contains( $ticket_order['name'], 'Season' ) ? 'Season' : $ticket_order['name'];
        //     $value[array_search($ticket_name, $column_headings)]   = $ticket_order['quantity'];

        // }

}
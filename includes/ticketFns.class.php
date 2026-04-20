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
        if( $seasonTickets ) {
            $upcomingShows = self::getActiveSeasonShows();
        } else {
            $upcomingShows = array( $showId );
        }
        //$showCount      = $showId > 0 ? 1 : self::getActiveSeasonShowCount();  // Need to actually determine number of remaining shows in the season
        $totalCharges = [];
        foreach( $upcomingShows as $upcomingShowId ) {
            $ticketCharges = ticketFns::getActualTicketPrices( $upcomingShowId, $seasonTickets );
            $totalCharges = ticketFns::mergeTicketCharges( $totalCharges, $ticketCharges );
            //add to total prices
        }
        return $totalCharges;
    }

     /**
     * @author: Nicolas Demers
     * @since:  2026
     * Get all ticket prices for a given show. By default from the show's meta fields, then from WooCommerce products if they
     * don't exist
     * @param (int) ID of the show
     * @param (boolean) whether this is a season pass or single ticket
     * @return (array)
     */
    private static function getActualTicketPrices( $showId, $seasonTickets ) {
        global $wpdb;
        $prefix = $seasonTickets > 0 ? 'season-ticket' : 'single-show';
        $prices_sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id = %d AND meta_key LIKE %s",
            $showId,
            $prefix.'-price-%'
        );
        //check if we do get a result. If not, read from WooCommerce products
        $prices_result = $wpdb->get_results( $prices_sql , ARRAY_A ); 
        $return = [];
        if( $prices_result ) {
            //show prices are stored in the meta? Massage and return them!
            foreach( $prices_result as $ticket_price ) {
                //we need to get the product name / title.
                $ticketId = substr( $ticket_price['meta_key'], strlen( $prefix ) + 7 );
                $return[] = [
                    'ticketId' => $ticketId,
                    'name' => get_the_title( $ticketId ),
                    'charge' => $ticket_price['meta_value'],
                    'quantity' => 0,
                ];
            }
            return $return;
        } else {
            //show prices are not yet stored in the meta? Retrieve from WooCommerce products as per the old olgic
            $prices_args = [
                'post_type' => 'product',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'tax_query' => [
                    [
                        'taxonomy'  => 'product_cat',
                        'field'     => 'slug',
                        'terms'     => $prefix
                    ]
                ]
            ]; 
            $prices_query = new WP_Query($prices_args); 
            if ($prices_query->have_posts()) {
                while ($prices_query->have_posts()) : $prices_query->the_post(); 
                    $return[] = [
                        'ticketId' => get_the_ID(),
                        'name' => get_the_title(),
                        'charge' => get_post_meta( get_the_ID(), '_regular_price', TRUE),
                        'quantity' => 0,
                    ];
                endwhile;
                wp_reset_postdata();
                return $return;
            } else {
                return array();
            }
        }
 
    }
    /*
     * @author: Nicolas Demers
     * @since:  2026
     * 
     * don't exist
     * @param (array) the existing array of charges
     * @param (boolean) the new array of charges, to add charges into the existing charges
     * @return (array) */
    private static function mergeTicketCharges( $baseCharges, $newCharges ) {
        if( is_array( $baseCharges ) && !empty( $baseCharges ) ) {
            foreach( $newCharges as $newCharge ) {
                foreach( $baseCharges as $idx => $baseCharge ) {
                    if( $baseCharge['ticketId'] == $newCharge['ticketId'] ) {
                        $baseCharges[$idx]['charge'] = (string) (floatval( $baseCharges[$idx]['charge'] ) + floatval( $newCharge['charge'] ) );
                    }
                }
            }
            return $baseCharges;
        } else {
            return $newCharges;
        }
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
     * @author: Nicolas Demers
     * @since: 6 March 2026
     * Return the shows left in the current season
     * @return (array)
     */
    private static function getActiveSeasonShows() {
        $shows_query = showFns::getSeasonShows('current', 2, 'current' );
        $show_ids = array();
        if( $shows_query->have_posts() ) {
            while ($shows_query->have_posts()) : $shows_query->the_post(); 
                $show_ids[] = get_the_ID();
            endwhile;
            wp_reset_postdata();
        }
        return $show_ids;
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
<?php
/**
 * Correct Tickets Sold for each Performance Date
 * 1. Delete all Tickets Sold meta value
 * 2. Go through all Orders and reaccumulate them correctly
 */

function correctTicketsSold()
{
    $args = [
        'post_type'     => 'performance',
        'posts_per_page'=> -1,
        'orderby'       => 'title',
        'order'         => 'ASC'
    ];

    $query  = new WP_Query( $args );
    $i      = 0;

    if( $query->have_posts()): while( $query->have_posts()): $query->the_post();
        $performanceId  = get_the_ID();
        $tickets_sold   = get_post_meta( $performanceId, 'tickets_sold', TRUE );
        $title          = get_the_title(); 
        echo '<p>' . $performanceId . ' ' .  date( 'd M Y h:i a', $title ) . ' (' . $title . ')</p>';
        $tickets_sold = get_post_meta( $performanceId, 'tickets_sold', TRUE ); 
        if( empty( $tickets_sold) )
        {
            update_post_meta( $performanceId, 'tickets_sold', [] );
            continue;
        } 
        $o  = [];
        foreach( $tickets_sold as $orderId => $quantities )
        {
            $p  = 0;
            $orderNoteClass = new Order_note($orderId);
            $orderNote      = $orderNoteClass->get_order_note(); 
            foreach( $orderNote as $key => $note )
            {
                if( !is_array( $note ) ) continue;
                if( !isset( $note['date'] ) ) continue;
                $performanceDateTime = strtotime( $note['date'] . ' ' . $note['time'] ); 
                if( $performanceDateTime != $title ) continue;
                $p    += $note['quantity'];
            }
            if( $p > 0 ) $o[$orderId]    = $p;
        }
        
        update_post_meta( $performanceId, 'tickets_sold', $o );
        // if( $i++ > 10 ) break;
        // update_post_meta( $performanceId, 'tickets_sold', [] ); // Overwrites tickets_sold with empty array
    endwhile; endif; wp_reset_postdata();

}
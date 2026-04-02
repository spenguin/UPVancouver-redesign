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
        $performanceId = get_the_ID();
        echo '<p>' . $performanceId . '</p>';
        $tickets_sold = get_post_meta( $performanceId, 'tickets_sold', TRUE ); 
        if( empty($tickets_sold) ) continue;
        echo print_r($tickets_sold);
        if( $i++ > 10 ) break;
    endwhile; endif; wp_reset_postdata();

}
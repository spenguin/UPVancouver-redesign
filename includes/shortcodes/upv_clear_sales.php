<?php
/**
 * A page to reset the Sales data
 */

function upv_clear_sales()
{
    echo '<p>Clear Tickets Sold</p>';
    $args = [
        'post_type'         => 'performance',
        'posts_per_page'    => -1
    ];
    $query = new WP_Query($args); 

    if($query->have_posts()): while( $query->have_posts()): $query->the_post();
        echo get_the_title() . '<br/>';
        update_post_meta( $query->post->ID, 'tickets_sold', [] );
    endwhile; endif; wp_reset_postdata();
}
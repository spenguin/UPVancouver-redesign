<?php
/**
 * Render Audition parts
 * (Might need to be extended or rebuilt if section is used elsewhere)
 */

function upv_reset_performance_titles( $atts = [], $content = null, $tag = '' )
{
    $args = [
        'post_type'         => 'performance',
        'posts_per_page'    => -1
    ];

    $query = new WP_Query($args);
    if( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();
        $performance_time   = get_post_meta( get_the_ID(), 'performance_time', TRUE );
        $datetime           = get_the_title() . ' ' . $performance_time;
        echo '<p>' . get_the_title() . ': ' . $performance_time . '</p>';
        echo '<p>' . strtotime($datetime) . '</p>';
        $post_args  = [
            'ID'    => get_the_ID(),
            'post_title'    => strtotime($datetime)
        ];

        
        // Update the post
        $result = wp_update_post( $post_args );

        // Check if the update was successful
        if ( is_wp_error( $result ) ) {
            echo 'Error updating post: ' . $result->get_error_message();die();
        } else {
            echo 'Post title updated successfully for post ID: ' . $post_id;
        }
        

    endwhile; endif; wp_reset_postdata();
} 
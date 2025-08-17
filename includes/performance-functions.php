<?php

/**
 * Bespoke functions for Performance Custom Post Type
 */

 add_filter( 'query_vars', 'add_custom_query_var' );

function add_custom_query_var( $vars ){
    $vars[] = "performance_id";
    return $vars;
}



/**
 * @since: 18 August 2023
 * Get all performance dates and post_meta values, for a specific showId
 * @param (int) showId
 * @return (array) performanceData
 */

function getPerformanceDates( $showId = NULL )
{
    if( is_null( $showId ) || $showId < 0 ) return [];
    
    $args = [
        'post_type'     => 'performance',
        'posts_per_page' => -1,
        'meta_key'   => 'show_id',
        'meta_value' => $showId
        // ],
        // 'orderby'
    ];
    $query = new WP_Query($args); //pvd($query);
    $o = [];
    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
            $date       = get_the_title();
            if( strtotime($date) < time() ) continue;
            $post_id    = get_the_ID();
            $custom     = get_post_custom($post_id);
            $date       = strtotime(get_the_title());
            $o[$post_id]  = [
                'id'        => $post_id,
                'date'      => $date,
                'preview'   => isset($custom['preview']) ? $custom['preview'][0] : '',
                'talkback'  => isset($custom['talkback']) ? $custom['talkback'][0] : '',
                'performance_time'  => isset($custom['performance_time']) ? $custom['performance_time'][0] : '',
                'sold_out'  => isset($custom['sold_out']) ? $custom['sold_out'][0] : ''
            ];
        endwhile;
    endif;
    wp_reset_postdata();

    ksort($o);

    return $o;
}

function get_show_title_by_performance_date( $date )
{
    $performance= get_post_by_title($date, '', 'performance' ); 
    $showId     = get_post_meta($performance->ID,"show_id",true);
    $show       = get_post( $showId );
    return $show->post_title;
}

function get_tickets_sold($performanceId)
{
    $tickets_sold   = get_post_meta($performanceId,'tickets_sold', TRUE); 
    if( empty($tickets_sold) )
    {
        $tickets_sold	= [
            'count'		=> 0
        ];
    }  
    return $tickets_sold;
}
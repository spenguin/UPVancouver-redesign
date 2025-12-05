<?php
/**
 * Performance Functions class
 */
class performance_fns
{
    public static function count_tickets_sold( $tickets )
    {
        $count = 0;
        if( empty($tickets) ) return $count;
        foreach( $tickets as $orderId => $order )
        {
            if( $orderId == "count" ) continue;
            foreach( $order as $order_count )
            {
                $count += $order_count;
            }
        }
        return $count;
    }

    /**
     * @since: 18 August 2023
     * Get all performance dates and post_meta values, for a specific showId
     * Function moved from performance-functions.php for clarity (24 November 2025)
     * Expand Sold Out flag where start time is close to current time
     * Expand Sold Out flag where number of tickets sold is close to size of audience for the Show
     * @param (int) showId
     * @return (array) performanceData
     */

    public static function get_performance_dates( $showId = NULL )
    {
        if( is_null( $showId ) || $showId < 0 ) return [];

        // Get ticket sales proximity value and start time proximity value (Hard coded for now)
        $tickets_sold_margin = 10;
        $performance_start_margin = 2 *60 * 60;
        $show_seats = get_post_meta( $showId, 'show_seats', TRUE );
        
        $args = [
            'post_type'     => 'performance',
            'posts_per_page' => -1,
            'meta_key'   => 'show_id',
            'meta_value' => $showId,
            'order'         => 'ASC',
            'orderby'       => 'title'
            // ],
            // 'orderby'
        ];
        $query = new WP_Query($args); //pvd($query);
        $o = [];
        $currentTimestamp   = time() - 8 * 60 * 60; //FIX!!
        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                $date_time  = get_the_title(); //pvd($date_time);
                // if( strtotime($date) < time() ) continue;
                if( $date_time < $currentTimestamp ) continue;
                $post_id    = get_the_ID();
                $custom     = get_post_custom($post_id);
                // $date       = strtotime(get_the_title());
                // $o[$post_id]  = [
                $o[$date_time]  = [
                    'id'        => $post_id,
                    'date_time' => $date_time,
                    'date'      => date('d M Y', (int) $date_time),
                    'performance_time'  => date( 'h:i a', (int) $date_time ),
                    'preview'   => isset($custom['preview']) ? $custom['preview'][0] : '',
                    'talkback'  => isset($custom['talkback']) ? $custom['talkback'][0] : '',
                    // 'performance_time'  => isset($custom['performance_time']) ? $custom['performance_time'][0] : '',
                    'sold_out'  => isset($custom['sold_out']) ? $custom['sold_out'][0] : ''
                ];
                // Challenge Sold Out
                if( empty($o[$date_time]['sold_out'] ) )
                {
                    
                    if( $currentTimestamp >= ( $date_time - $performance_start_margin ) )
                    {
                        $o[$date_time]['sold_out'] = '1';
                    }
                    $tickets_sold = get_post_meta( $post_id, 'tickets_sold', TRUE );
                    $ticket_count = \performance_fns::count_tickets_sold($tickets_sold);
                    if( ( $show_seats - $ticket_count ) < $tickets_sold_margin )
                    {
                        $o[$date_time]['sold_out'] = '1';
                        update_post_meta( $post_id, 'sold_out', TRUE );
                    }

                }
            endwhile;
        endif;
        wp_reset_postdata();

        // ksort($o);

        return $o;
    } 
    
    public static function get_tickets_sold($performanceId)
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
}
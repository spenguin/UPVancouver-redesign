<?php
/**
 * Show  Functions class
 */
class showFns
{
    /**
     * Get season based on parameter passed
     * @param $which (str) 'past'
     * @param $override (num) default 0
     * @param $shows (str) 'current' or 'past'
     * @return (obj) season
     */
    static function getSeasonShows($which, $override=0, $shows="current")
    {
        global $wpdb;

        $seasons = self::getSeason(date('Y')); 
        $compare = $shows == 'past' ? '<' : '>='; 

        $args   = [
            'post_type'         => 'show',
            'posts_per_page'    => -1,
            'tax_query'         => [
                [
                'taxonomy'      => 'season',
                'field'         => 'slug',
                'terms'         => $seasons[0]['slug']
                ]
            ],
            'meta_key'          => 'end_date',
            'meta_value'        => date('Y-m-d'),
            'meta_compare'      => $compare, //'>=',
            'orderby'           => [
                [
                    'meta_key'  => 'start_date'
                ]
            ]
        ];

        $query  = new WP_Query( $args ); 
        if( ( $query->post_count == 0 || $query->post_count == 5 ) && $which == 'past' ) return new stdClass();
        if( $query->post_count < 5 && $which == 'past' ) return $query; 
        if( $query->post_count > $override && $which != 'past' ) return $query;

        $args['tax_query'][0]['terms'] = $seasons[1]['slug'];

        $query  = new WP_Query( $args );

        return $query;
    }

    /**
     * Get Seasons from db,
     * based on current year
     * Seasons will be (Y - Y+1) or (Y-1 - Y)
     */
    static function getSeason($year)
    {
        global $wpdb;

        $table = $wpdb->prefix . "terms";
        $sql = $wpdb->prepare(
            "SELECT * FROM $table WHERE `slug` LIKE %s",
            ['%' . $year . '%']
        );
        return $wpdb->get_results( $sql , ARRAY_A ); 
    }   
    

    /**
     * Loop through the posts based on the show title
     * Return main, cast and production content
     * @param (str) Show Title
     * @returns (array) content
     */
    static function organiseShowContent($title)
    {
        $sanitized_title = sanitize_title($title); 
        $query  = new WP_Query( array( 'category_name' => $sanitized_title ) ); 
        $o      = [];
        while($query->have_posts() ): $query->the_post();
            $o[strtolower($query->post->post_title)]    = $query->post->post_content;
        endwhile;
        wp_reset_postdata();

        return $o;
    }    

    /**
     * Retrieve all Show titles
     * @param (str) filter = "full|current"
     * @return (array) titles
     */
    static function getShowTitles($filter='current')
    {
        $args = [
            'post_type'         => 'show',
            'posts_per_page'    => -1,
            'order'             => 'ASC',
            'order_by'          => 'title',
            'post_status'       => 'publish' 
        ];
        if( $filter == "current" )
        {
            $args['meta_key']   = 'end_date';
            $args['meta_value'] = date('Y-m-d');
            $args['meta_compare']   = '>=';
        }

        $query  = new WP_Query($args); 

        $o      = [];
        foreach( $query->posts as $post )
        {
            $o[$post->ID]   = $post->post_title;
        }

        wp_reset_postdata();

        return $o;
    }    

}
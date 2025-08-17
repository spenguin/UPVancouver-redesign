<?php

/**
 * Bespoke functions for Show Custom Post Type
 */

/**
 * Get season based on parameter passed
 * @param (str) 'current' or 'past'
 * @return (obj) season
 */
function get_season_shows($which, $override=0, $shows="current")
{
    global $wpdb;

    $seasons = get_seasons(date('Y')); 
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

    $query  = new WP_Query( $args ); //die(pvd($query->post_count) );
    if( ( $query->post_count == 0 || $query->post_count == 5 ) && $which == 'past' ) return new stdClass();
    if( $query->post_count < 5 && $which == 'past' ) return $query; 
    if( $query->post_count > $override && $which != 'past' ) return $query;

    $args['tax_query'][0]['terms'] = $seasons[1]['slug'];

    $query  = new WP_Query( $args );

    return $query;



    // if( $query->post_count== 0) 
    // { 
    //     if( $shows != 'past' ) {
    //         $season     = read_season(date('Y', strtotime('+1 year')));
    //     }
    // } elseif( $season == "next" ) {
    //     $season = read_season(date('Y', strtotime('+1 year')));
    // }

    // $args   = [
    //     'post_type'         => 'show',
    //     'posts_per_page'    => -1,
    //     'tax_query'         => [
    //         [
    //         'taxonomy'      => 'season',
    //         'field'         => 'slug',
    //         'terms'         => $season[0]['slug']
    //         ]
    //     ],
    //     'meta_key'          => 'end_date',
    //     'meta_value'        => date('Y-m-d'),
    //     'orderby'           => 'meta_value_num',
    //     'order'             => 'ASC'
    //     // 'meta_compare'      => '>='
    // ];    
    // switch( $shows )
    // {
    //     case 'past':
    //         // $args['meta_key']       = 'end_date';
    //         // $args['meta_value']     = date('Y-m-d');
    //         $args['meta_compare']   = '<';
    //         break;
    //     case 'active':
    //         // $args['meta_key']       = 'end_date';
    //         // $args['meta_value']     = date('Y-m-d');
    //         $args['meta_compare']   = '>=';
    //         break;
    // }
    // $query  = new WP_Query( $args ); 

    // return $query;
}

/**
 * Get Seasons from db,
 * based on current year
 * Seasons will be (Y - Y+1) or (Y-1 - Y)
 */
function get_seasons($year)
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
function organise_show_content($title)
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
 * @return (array) titles
 */
function get_show_titles()
{
    global $wpdb;

    $results = $wpdb->get_results( "SELECT ID,post_title FROM {$wpdb->prefix}posts WHERE post_type = 'show' && post_status='publish' ORDER BY post_title ASC" ); 
    
    $o      = [];
    foreach( $results as $r )
    {
        $o[$r->ID]   = $r->post_title;
    }
    return $o;
}

/**
 * Retrieve and display all production photos for the show
 * @return (string)
 */
function show_production_photos($ID)
{
    $photoURLs = get_post_meta( $ID, 'show_production_photos' );
    ob_start();
        foreach( $photoURLs as $src ): ?>
            <img src="<?php echo $src;?>" />
        <?php endforeach; 
    return ob_get_clean();
}
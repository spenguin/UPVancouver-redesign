<?php
/**
 * Present Show Tiles
 */

function ws_show_season()
{
    // First, let's get the Season
    $season  = get_current_season(); 
    
    // $args   = [
    //     'post_type' => 'show',
    //     'posts_per_page'    => -1
    // ];

    // $query = new WP_Query( $args );
    // if( $query->have_posts() ): 
        ob_start();
    ?>
        <section class="season">
            <?php
                while( $season->have_posts() ): $season->the_post(); 
                    $directing_credits  = get_post_meta($season->post->ID, 'directing_credits', true);
                    $writing_credits    = get_post_meta($season->post->ID, 'writing_credits', true);
                    // $end_date           = get_post_meta($post->ID, 'end_date', true); //var_dump($end_date);
                ?>
                    <div class="season__show">
                        <div class="season__show--image feature-image">
                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_post_thumbnail( get_the_ID() ); ?></a>
                        </div>
                        <div class="season__show--content">
                            <div class="season__show--text">
                                <h2><?php the_title(); ?></h2>
                                <p class="season__show--credits-major"><?php echo $writing_credits; ?></p>
                                <p class="season__show--credits-minor"><?php echo $directing_credits; ?></p>
                            </div>
                            <div class="season__show--action">
                                <a href="<?php echo esc_url( get_permalink() ); ?>" class="button button--information">Learn More</a>
                                <a href="<?php echo esc_url( get_permalink() ); ?>#tickets" class="button button--action">Buy Tickets</a>
                            </div>
                        </div>
                    </div>
            <?php endwhile; ?>
            <?php if( $season->post_count % 2 == 1 ): ?>
                <div class="season__show">
                        <div class="season__show--image feature-image">
                            <a href="<?php echo esc_url( get_permalink() ); ?>"><img src="<?php echo CORE_TEMPLATE_URL; ?>/assets/furniture/65th-anniversary-tile.jpg" /></a>
                        </div>
                        <div class="cta--wrapper"><a class="button button--huge" href="/past-performances"><span>Past Performances</span>this season</a></div>
                    </div>
            <?php else: ?>
                <div class="cta--wrapper"><a class="button button--huge" href="/past-performances"><span>Past Performances</span>this season</a></div>                
            <?php endif; ?>


        </section>
    <?php 
    $o = ob_get_clean();    
    // endif; 
    wp_reset_query();

    return $o;
}

function get_current_season() {
    global $wpdb;

    // Try first season
    $sql        = $wpdb->prepare(
        "SELECT * FROM `wpba_terms` WHERE `slug` LIKE %s",
        ['%' . date('Y')]
    );
    $season     = $wpdb->get_results( $sql , ARRAY_A ); die(pvd($season));

    $args   = [
        'post_type'         => 'show',
        'posts_per_page'    => -1,
        'tax_query'         => [
            [
            'taxonomy'      => 'season',
            'field'         => 'slug',
            'terms'         => $season[0]['slug']
            ]
        ],
        'meta_key'          => 'end_date',
        'meta_value'        => date('Y-m-d'),
        'meta_compare'      => '>='
    ];
    $query  = new WP_Query( $args ); 
    if( $query->post_count > 0 ) return $query;

    // Okay,that didn't work. Try next season
    $sql        = $wpdb->prepare(
        "SELECT * FROM `wpba_terms` WHERE `slug` LIKE %s",
        [date('Y'). '%']
    );
    $season     = $wpdb->get_results( $sql , ARRAY_A ); //pvd($season); 

    $args   = [
        'post_type'         => 'show',
        'posts_per_page'    => -1,
        'tax_query'         => [
            'taxonomy'      => 'season',
            'field'         => 'slug',
            'terms'         => $season[0]['slug']
        ],
        'meta_key'          => 'start_date',
        'meta_value'        => date('Y-m-d'),
        'meta_compare'      => '<='
    ];
    $query  = new WP_Query( $args );

    return $query;

}
<?php
/**
 * Present Shows
 * @param (str) season ['current','next']
 * @param (str) shows ['active', 'past', 'all']
 * @param (int) override
 * @param (str) presentation ['tiles','list']
 * @returns (str) rendered presentation
 */

function upv_show_season( $atts = [], $content = null, $tag = '' )
{
    extract(shortcode_atts(array(
        'season'        => 'current',
        'override'      => 0,
        'presentation'  => 'tiles',
        'shows'         => 'active'
     ), $atts)); 

    $display_next_season = get_option('display_next_season');
    if( $display_next_season && $presentation == "list" )
    {
        $announcement = get_post_by_title( 'Upcoming Season Announcement' );
        echo $announcement;
        return;
    }

    // First, let's get the Season
    $showObj    = get_season_shows($season, $override, $shows); 


    // return;
    // $season  = get_current_season($shows); 
    
    // $args   = [
    //     'post_type' => 'show',
    //     'posts_per_page'    => -1
    // ];

    // $query = new WP_Query( $args );
    // if( $query->have_posts() ): 
        ob_start();
    ?>
        <section class="season">
            <?php echo $content; ?>
            <?php
                while( $showObj->have_posts() ): $showObj->the_post(); 
                    $directing_credits  = get_post_meta($showObj->post->ID, 'directing_credits', true);
                    $writing_credits    = get_post_meta($showObj->post->ID, 'writing_credits', true);
                    switch($presentation): 
                        case 'tiles':
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
                                            <?php if($shows != "past"): ?>
                                                <a href="<?php echo esc_url( get_permalink() ); ?>#tickets" class="button button--action">Buy Tickets</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            break;
                        case 'list':
                            ?>
                            <div class="season__show">
                                <div class="season__show--content">
                                    <div class="season__show--text">
                                        <h2><?php the_title(); ?></h2>
                                        <p class="season__show--credits-major"><?php echo $writing_credits; ?></p>
                                        <p class="season__show--credits-minor"><?php echo $directing_credits; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php
                        break;
                        endswitch;
            endwhile; ?>
            <?php 
                if( $presentation == 'tiles' ) {
                    if( $showObj->post_count < 3 ):     // Needs to be 5
                        if( $showObj->post_count % 2 == 1 ): ?>
                        <div class="season__show">
                            <div class="season__show--image feature-image">
                                <a href="<?php echo esc_url( get_permalink() ); ?>"><img src="<?php echo CORE_TEMPLATE_URL; ?>/assets/furniture/Home-page-placeholder_2.jpg" /></a>
                            </div>
                            <div class="cta--wrapper"><a class="button button--huge" href="/past-performances"><span>Past Performances</span>this season</a></div>
                        </div>
                    <?php else: ?>
                        <div class="cta--wrapper"><a class="button button--huge" href="/past-performances"><span>Past Performances</span>this season</a></div>                
                    <?php endif; 
                    endif; 
                }   
            ?>
        </section>
    <?php 
    $o = ob_get_clean();    
    // endif; 
    wp_reset_query();

    return $o;
}

function get_current_season($shows) {
    global $wpdb;

    // Try first season
    $sql        = $wpdb->prepare(
        "SELECT * FROM `wpba_terms` WHERE `slug` LIKE %s",
        ['%' . date('Y')]
    );
    $season     = $wpdb->get_results( $sql , ARRAY_A ); 

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
    if( $query->post_count > 0 || $shows == "current" ) return $query;

    // Okay,that didn't work. Try next season
    $sql        = $wpdb->prepare(
        "SELECT * FROM `wpba_terms` WHERE `slug` LIKE %s",
        [date('Y', strtotime('+1 year')). '%']
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
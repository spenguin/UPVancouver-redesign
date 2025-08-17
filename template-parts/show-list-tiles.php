<?php
/**
*   Present the shows as tiles, noteably on the Home Page
*/

    $directing_credits  = get_post_meta($showObj->post->ID, 'directing_credits', true);
    $writing_credits    = get_post_meta($showObj->post->ID, 'writing_credits', true);
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
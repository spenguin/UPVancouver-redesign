<?php
/**
*   Present the shows as list, noteably on the Season Tickets Page
*/

    $directing_credits  = get_post_meta($showObj->post->ID, 'directing_credits', true);
    $writing_credits    = get_post_meta($showObj->post->ID, 'writing_credits', true);
?>
    <div class="season__show--list">
        <div class="season__show--list__content">
            <div class="season__show--text">
                <h2><?php the_title(); ?></h2>
                <p class="season__show--credits-major"><?php echo $writing_credits; ?></p>
                <p class="season__show--credits-minor"><?php echo $directing_credits; ?></p>
            </div>
        </div>
    </div>
<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Minimal WP Theme
 */

get_header();
?>
    <main id="primary" class="site-main">
        <div class="site-main-wrapper max-wrapper">
            <?php if( !(is_home() || is_front_page() ) ) { ?>
                <h1><?php echo get_the_title(); ?></h1>
            <?php }?> 
            
            <?php 
                switch($post->post_type) {
                    case 'show':
                        get_template_part('template-parts/show-content');
                        break;
                    default:
                        the_content();
                }
            ?>

        </div>
    </main><!-- #primary --> 
    <?php //get_sidebar(); ?>
</div><!-- end container -->

<?php
get_footer();

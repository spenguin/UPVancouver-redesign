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

get_header(); //pvd(WC()->cart);
?>
    <main id="primary" class="site-main">
        <div class="site-main-wrapper max-wrapper">
            <?php if( !(is_home() || is_front_page() ) ) { ?>
                <h1><?php echo get_the_title(); ?></h1>
            <?php }?> 
            
            <?php 
                $post_type = (!empty($post->post_type)) ? $post->post_type : NULL;
                switch($post_type) {
                    case 'show':
                        get_template_part('template-parts/show-content');
                        break;
                    case 'page':
                        if( is_page('Donate') && !isset($_POST['donation']) ) {
                            get_template_part('template-parts/donation-form');
                        }
                        the_content();
                        break;
                    default:
                    //     if(is_single('Seasons Tickets') ) {
                    //         echo 'Seasons Tickets here';
                    //     }
                        the_content();
                }
                // if(is_page('Seasons Tickets') ) { 
                //     // get_template_part('template-parts/seasons-tickets-content');
                //     // echo get_the_content();
                //     the_content();
                // }
                // if( is_home() || is_front_page() ) {
                //     the_content();
                // }

            ?>

        </div>
    </main><!-- #primary --> 
    <?php //get_sidebar(); ?>
</div><!-- end container -->

<?php
get_footer();

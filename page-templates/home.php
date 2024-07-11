<?php
/** Home Page template */


get_header();
?>
    <!-- <header>
		<?php //get_template_part( 'template-parts/header-content' ); ?>
        <?php //get_template_part( 'template-parts/header-bar' ); ?>
        <?php //get_template_part( 'template-parts/hero-image' ); ?>
        <?php //get_template_part( 'template-parts/navigation' ); ?>
    </header> -->
    <div class="container">
		<main id="primary" class="site-main"><?php //pvd( get_post_type()); ?>
            <div class="site-main-wrapper max-wrapper"><h1>Test</h1>
                <?php if( !(is_home() || is_front_page() ) ) { ?>
                    <h1><?php echo get_the_title(); ?></h1>
                <?php }?> 

                <?php the_content(); ?>

                <!-- <a href="" class="button button--special">Special</a> -->

                <section class="season">
                    <div class="season__show">
                        <div class="season__show--image feature-image">
                            <img src="https://upv.weirdspace.xyz/wp-content/uploads/2024/02/9390501233_57a7bb9ed7_k.jpg" />
                        </div>
                        <div class="season__show--content">
                            <div class="season__show--text">
                                <h2>Show Title</h2>
                                <p class="season__show--credits-major">Main credits for the show</p>
                                <p class="season__show--credits-minor">Secondary credits for the show</p>
                            </div>
                            <div class="season__show--action">
                                <a href="" class="button button--action">Action</a>
                                <a href="" class="button button--information">Information</a>
                            </div>
                        </div>
                    </div>
                </section>



            </div>
		</main><!-- #primary --> 
		<?php //get_sidebar(); ?>
		</div><!-- end container -->

<?php
get_footer();
<?php
/**
 * Generate a list of FAQs
 */

initialise();

function initialise()
{
    add_shortcode( 'upv_faqs', 'upv_faqs' );
}

function upv_faqs()
{
    $args = [
        'post_type'         => 'faq',
        'posts_per_page'    => -1
    ];

    $query = new WP_Query($args);
    if( $query->have_posts())
    {
        ?>
            <div class="faq__index">
                <ul>
                <?php
                    while( $query->have_posts() ): $query->the_post(); 
                        $postId =  get_the_ID(); ?>
                        <li class="faq__index--item"><a href="#<?php echo $postId; ?>"><?php echo get_the_title(); ?></a></li>

                    <?php endwhile;
                ?>
                </ul>
            </div>
            <div class="faq__listing">
                <?php
                    while( $query->have_posts() ): $query->the_post(); 
                        $postId =  get_the_ID(); ?>
                        <div class="faq__listing--entry">
                            <h2 id="<?php echo $postId; ?>"><?php echo get_the_title(); ?></h2>
                            <?php echo the_content(); ?>
                        </div>
                    <?php endwhile;  
                ?>              
            </div>
        <?php wp_reset_postdata();
    } else {
        echo '<p>No FAQs to display</p>';
    }
}
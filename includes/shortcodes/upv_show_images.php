<?php
/**
 * Render Show Audition details
 */
function upv_show_images( $atts = [], $content = null, $tag = '' )
{
    
    extract(shortcode_atts(array(
        'thumbnail_ids'        => [],
     ), $atts)); 

    if( empty($thumbnail_ids) ) return [];

    $thumbnail_ids  = explode(",", $thumbnail_ids);

    ob_start(); ?>

        <div class="show-page__main-images">
            <?php 
                foreach( $thumbnail_ids as $thumbnail_id )
                {
                    echo wp_get_attachment_image( $thumbnail_id, [543, 1000] );
                }
            ?>
        </div>
    <?php
    return ob_get_clean();
}
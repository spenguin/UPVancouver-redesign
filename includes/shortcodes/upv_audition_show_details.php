<?php
/**
 * Render Show Audition details
 */
function upv_audition_show_details( $atts = [], $content = null, $tag = '' )
{
    
	// // normalize attribute keys, lowercase
	// $atts = array_change_key_case( (array) $atts, CASE_LOWER ); 

	// // override default attributes with user attributes
	// $wporg_atts = shortcode_atts(
	// 	[], $atts, $tag
	// );
    
    $args   = [
        'post_type' => 'show',
        'title'     => $atts['show']
    ];

    $query  = new WP_Query( $args ); //pvd($query);
    $show_details   = $query->posts[0]; //pvd($show_details);
    $img_src        = get_the_post_thumbnail_url($show_details->ID);
    $directing_credits  = get_post_meta($show_details->ID, 'directing_credits', true);
    $writing_credits    = get_post_meta($show_details->ID, 'writing_credits', true);

    $o  = <<<EOD
        <div class="audition-details__main">
            <div class="audition-details__left">
                <h2>$show_details->post_title</h2>
                <div class="feature-image"><img src="$img_src" /></div>
            </div>
            <div class="audition-details__right">
                <p class="audition-details--credits-major">$writing_credits</p>
                <p class="audition-details--credits-minor">$directing_credits</p>
                $show_details->post_excerpt;
            </div>
        </div>
    EOD;


//     $str = <<<EOD
// Example of string
// spanning multiple lines
// using heredoc syntax.
// $var is replaced automatically.
// EOD;

//     $o[]    = '<h2>' . $show_details->post_title . '</h2>';
//     $o[]    = '<div class="feature-image"><img src="' . get_the_post_thumbnail_url($show_details->ID) . '" /></div>';
    
//     $o      = join('', $o );

    return '<section class="audition-details">' . $o . $content . '</section>';
}
<?php
/** Site functions */

function register_my_session()
{
    if( !session_id() )
    {
        session_start();
    }
    if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
}

add_action('init', 'register_my_session');


function get_post_by_title($title = NULL, $element="content", $post_type="post")
{ 
    global $wpdb;

    if (is_null($title)) return "";

    $mypostids = $wpdb->get_col("select * from $wpdb->posts where post_title LIKE '" . $title . "'"); 
    if( empty($mypostids) ) return NULL;

    $args = [
        'post__in'  => $mypostids,
        'post_type' => $post_type,
        // 'orderby'   => 'title',
        // 'order'     => 'asc'
    ];

    $query  = new WP_Query($args); 
    if( $query->found_posts == 0 ) {
        return NULL;
    }

    $post   = $query->posts[0];
    switch ($element) {
        case 'content':
            $content    = apply_filters('the_content', $post->post_content);
            $content    = str_replace(']]>', ']]&gt;', $content);
            return $content;
        default:
            return $post;
    }

}

function get_page_class_by_title($title = NULL)
{
    switch($title)
    {
        case 'About Us':
            return 'three-body';
        default:
            return '';

    }
}


// function add_current_show_in_nav_sidebar_menu( $items, $args ) {pvd($args->menu);
//     if($args->slug == "secondary-menu") return $items;
//     foreach ( $items as $k => $object ) { pvd($k); die(pvd($object));
//         // you can also target given page using this if:
//         // if ( 'page' == $object->object && 2 == $object->object_id ) {
//         if ( 30 == $object->ID ) {
//             $object->title = '<i class="fas fa-home"></i>';
//         }
//     }
//     return $items;
// }
// add_filter( 'wp_nav_menu_items', 'add_current_show_in_nav_sidebar_menu', 10, 2 );

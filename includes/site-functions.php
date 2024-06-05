<?php
/** Site functions */

function register_my_session()
{
  if( !session_id() )
  {
    session_start();
  }
}

add_action('init', 'register_my_session');


function get_post_by_title($title = NULL, $element="content")
{
    global $wpdb;

    if (is_null($title)) return "";

    $mypostids = $wpdb->get_col("select ID from $wpdb->posts where post_title = '" . $title . "'");

    $args = array(
        'post__in'  => $mypostids,
        'post_type' => 'post',
        'orderby'   => 'title',
        'order'     => 'asc'
    );

    $query  = new WP_Query($args);
    if( $query->founc_posts == 0 ) {
        return NULL;
    }

    $post   = $query->posts[0];
    switch ($element) {
        case 'content':
            $content    = apply_filters('the_content', $content);
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

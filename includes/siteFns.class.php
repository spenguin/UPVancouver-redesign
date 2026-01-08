<?php
/**
 * Site-wide functions
 */
class siteFns
{
    static function initialise()
    {
        add_action('init', ['siteFns','registerMySession']);
    }
    
    static function registerMySession()
    {
        if( !session_id() )
        {
            session_start();
        }
        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    }

    function getPageClassByTitle($title = NULL)
    {
        switch($title)
        {
            case 'About Us':
                return 'three-body';
            default:
                return '';

        }
    }

    static function getPostByTitle($title = NULL, $element="content", $post_type="post")
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

}

    

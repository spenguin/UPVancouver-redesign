<?php
/**
 * Create custom columns for custom post types
 */

namespace CustomPostColumns;

\CustomPostColumns\initialize();

function initialize()
{
    add_filter( 'manage_performance_posts_columns', '\CustomPostColumns\weirdspace_filter_posts_columns' );
    add_action( 'manage_performance_posts_custom_column', '\CustomPostColumns\weirdspace_show_column', 10, 2);
}

function weirdspace_filter_posts_columns( $columns ) {
    $columns = [
        'cb' => $columns['cb'],
            'title'     => __( 'Title' ),
            'show'      => __( 'Show' ),
            'preview'   => __( 'Preview' ),
            'talkback'  => __( 'Talkback' ),
            'sales'     => __( 'Sales'),
    ];
    return $columns;
}

function weirdspace_show_column( $column, $post_id )
{   //var_dump($column);
    $custom     = get_post_custom($post_id);
    switch ($column):
        case 'show':
            $show_id    = $custom['show_id'][0] ? $custom['show_id'][0] : '';
            $showPost   = get_post($show_id);
            echo $showPost->post_title;
            break;
        case 'preview':
            echo is_null($custom['preview'][0]) ? '' : '<span class="tick">&#10004;</span>';
            break;
        case 'talkback':
            echo is_null($custom['talkback'][0]) ? '' : '<span class="tick">&#10004;</span>';
            break;
        case 'sales':
            echo '10';
            break;
        endswitch;
}
  
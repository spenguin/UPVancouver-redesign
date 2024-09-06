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
    add_action( 'pre_get_posts', '\CustomPostColumns\performances_columns_orderby' );
}

function weirdspace_filter_posts_columns( $columns ) {
    $columns = [
        'cb' => $columns['cb'],
            'title'     => __( 'Title' ),
            'date'      => __( 'Date' ),
            'show'      => __( 'Show' ),
            'preview'   => __( 'Preview' ),
            'talkback'  => __( 'Talkback' ),
            'sales'     => __( 'Sales'),
    ];
    return $columns;
}

function weirdspace_show_column( $column, $post_id )
{   
    $custom     = get_post_custom($post_id); 
    switch ($column):
        case 'show':
            $show_id    = $custom['show_id'][0] ? $custom['show_id'][0] : '';
            $showPost   = get_post($show_id);
            echo $showPost->post_title;
            break;
        case 'preview':
            echo isset($custom['preview']) ? ($custom['preview'][0] ?  '<span class="tick">&#10004;</span>' : '' ) : '';
            break;
        case 'talkback':
            echo isset($custom['talkback']) ? ($custom['talkback'][0] ?  '<span class="tick">&#10004;</span>' : '' ) : '';
            break;
        case 'date':
            $show_id    = $custom['show_id'][0] ? $custom['show_id'][0] : '';
            $showPost   = get_post($show_id);
            echo $showPost->post_title;            
        case 'sales':
            if( isset($custom['tickets_sold'][0]) )
            {
                $tickets_sold = unserialize($custom['tickets_sold'][0]);
            }
            if( $post_id == '320' ) pvd($tickets_sold);
            
            
            // echo isset( $tickets_sold['count'] ) ? $tickets_sold['count'] : 0;
            break;
        endswitch;
}


function performances_columns_orderby( $query ) 
{

    if( ! is_admin() )
        return;

    $orderby = $query->get( 'orderby');

    switch( $orderby ){
        case 'menu_order title':
            $query->set('orderby','date'); 
            break;
        default: break;
    }

}


  
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
    add_action( 'restrict_manage_posts', '\CustomPostColumns\show_filter' );
    add_filter( 'parse_query', '\CustomPostColumns\parse_show_filter' );

}

function show_filter()
{
    $screen = get_current_screen();
    if( is_admin() && $screen->id == 'edit-performance' )
    {   
        global $post_type;  // Do I need this?
        $titles     = get_show_titles(); 
        $show_filter= isset($_GET['show_filter']) ? $_GET['show_filter'] : '';
        ?>
            <select name="show_filter">
                <option value="-1">All Shows</option>
                <?php
                    foreach( $titles as $title_id => $title )
                    {
                        $selected = $show_filter == $title_id ? 'selected' : '';
                        echo '<option value="' . $title_id . '"' . $selected . '>' . $title . '</option>';
                    }
                ?>
            </select>

        <?php
    }
}

function  parse_show_filter($query) 
{
    global $pagenow;
    $screen = get_current_screen();
   
    if( is_admin() &&
        $screen->id == 'edit-performance' &&
        isset( $_GET['show_filter'] ) &&
        $_GET['show_filter'] != '-1'
        )
    { 
        $show_id =  $_GET['show_filter'];
        $query->query_vars['meta_key']      = 'show_id';
        $query->query_vars['meta_value']    = $show_id;
        $query->query_vars['meta_compare']  = '=';
    }
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
            'report'    => __( 'Report' ),
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
            break;          
        case 'sales':
            $tickets_sold = get_post_meta( $post_id, 'tickets_sold', TRUE );
            echo empty($tickets_sold) ? 0 : $tickets_sold['count'];
            break;
        case 'report':
            echo '<a href="/performance-report/?performance_id=' . $post_id . '" target="_blank">Report</a>';
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


  
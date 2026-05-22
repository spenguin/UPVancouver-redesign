<?php
/**
 * Custom Post Type sponsors
 */

namespace CustomPosts\Sponsors;

\CustomPosts\Sponsors\initialise();

function initialise()
{
    add_action('init', '\CustomPosts\Sponsors\custom_post_type', 0);
    add_action('init', '\CustomPosts\Sponsors\custom_taxonomy_type', 0);

    // add_action('save_post_sponsor', '\CustomPosts\Sponsors/save_sponsor_');
}


function custom_post_type()
{
    // Set UI labels for Custom Post Type sponsor
    $labels = array(
        'name'                => _x('Sponsors', 'Post Type General Name', 'upv'),
        'singular_name'       => _x('Sponsor', 'Post Type Singular Name', 'upv'),
        'menu_name'           => __('Sponsors', 'upv'),
        'parent_item_colon'   => __('Parent Sponsor', 'upv'),
        'all_items'           => __('All Sponsors', 'upv'),
        'view_item'           => __('View Sponsor', 'upv'),
        'add_new_item'        => __('Add New Sponsor', 'upv'),
        'add_new'             => __('Add New', 'upv'),
        'edit_item'           => __('Edit Sponsor', 'upv'),
        'update_item'         => __('Update Sponsor', 'upv'),
        'search_items'        => __('Search Sponsor', 'upv'),
        'not_found'           => __('Not Found', 'upv'),
        'not_found_in_trash'  => __('Not found in Trash', 'upv'),
    );

    // Set other options for Custom Post Type
    $args = array(
        'label'               => __('sponsor', 'upv'),
        'description'         => __('Sponsors listings', 'upv'),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array('level'),
        'rewrite' => array('slug' => 'sponsor', 'with_front' => false),
        /* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 25,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'show_in_rest'        => TRUE

    );

    // Registering Custom Post Type show
    register_post_type('sponsor', $args);
}

function custom_taxonomy_type()
{
    register_taxonomy(
        'level',
        'sponsor',
        array(
            'labels'    => array(
                'name'  => 'Levels',
                'add_new_item'  => 'Add New Level',
                'new_item_name' => 'New Level'
            ),
            'show_ui'   => TRUE,
            'show_tagcloud' => FALSE,
            'hierarchical'  => TRUE
        )
    );
}
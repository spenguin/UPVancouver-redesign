<?php

namespace CustomPosts;

use WP_Query;

\CustomPosts\initialize();

function initialize()
{
    add_action('init', '\CustomPosts\custom_post_type', 0);
    add_action('init', '\CustomPosts\custom_taxonomy_type', 0);
    add_action('admin_init', '\CustomPosts\admin_init');
    add_action('save_post_show', '\CustomPosts\save_show_dates');
    add_action('save_post_show', '\CustomPosts\save_show_credits');
    add_action('save_post_member', '\CustomPosts\save_member_title');
    add_action('save_post_show', '\CustomPosts\save_show_seats');
    add_action('save_post_show', '\CustomPosts\save_show_production_photos');
    
    // add_action('save_post_show', '\CustomPosts\save_promote_show');
    // add_action('save_post_show', '\CustomPosts\save_show_cast');    

    add_action('save_post_performance', '\CustomPosts\save_performance_time');
    add_action('save_post_performance', '\CustomPosts\save_preview');
    add_action('save_post_performance', '\CustomPosts\save_talkback');
    add_action('save_post_performance', '\CustomPosts\save_soldout');
    // add_action('add_meta_boxes', '\CustomPosts\switch_excerpt_boxes');
    require_once 'custom-posts/custom-post-columns.php';
}

function custom_post_type()
{

    // Set UI labels for Custom Post Type Performances
    $labels = array(
        'name'                => _x('Shows', 'Post Type General Name', 'upv'),
        'singular_name'       => _x('Show', 'Post Type Singular Name', 'upv'),
        'menu_name'           => __('Shows', 'upv'),
        'parent_item_colon'   => __('Parent Show', 'upv'),
        'all_items'           => __('All Shows', 'upv'),
        'view_item'           => __('View Show', 'upv'),
        'add_new_item'        => __('Add New Show', 'upv'),
        'add_new'             => __('Add New', 'upv'),
        'edit_item'           => __('Edit Show', 'upv'),
        'update_item'         => __('Update Show', 'upv'),
        'search_items'        => __('Search Show', 'upv'),
        'not_found'           => __('Not Found', 'upv'),
        'not_found_in_trash'  => __('Not found in Trash', 'upv'),
    );

    // Set other options for Custom Post Type
    $args = array(
        'label'               => __('show', 'upv'),
        'description'         => __('Shows listings', 'upv'),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array('seasons'),
        'rewrite' => array('slug' => 'show', 'with_front' => false),
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
        'menu_position'       => 15,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'show_in_rest'        => TRUE

    );

    // Registering Custom Post Type Blogs
    register_post_type('show', $args);

    // Set UI labels for Custom Post Type Performances
    $labels = array(
        'name'                => _x('Performances', 'Post Type General Name', 'upv'),
        'singular_name'       => _x('Performance', 'Post Type Singular Name', 'upv'),
        'menu_name'           => __('Performances', 'upv'),
        'parent_item_colon'   => __('Parent Performance', 'upv'),
        'all_items'           => __('All Performances', 'upv'),
        'view_item'           => __('View Performance', 'upv'),
        'add_new_item'        => __('Add New Performance', 'upv'),
        'add_new'             => __('Add New', 'upv'),
        'edit_item'           => __('Edit Performance', 'upv'),
        'update_item'         => __('Update Performance', 'upv'),
        'search_items'        => __('Search Performance', 'upv'),
        'not_found'           => __('Not Found', 'upv'),
        'not_found_in_trash'  => __('Not found in Trash', 'upv'),
    );

    // Set other options for Custom Post Type
    $args = array(
        'label'               => __('performance', 'upv'),
        'description'         => __('Performances listings', 'upv'),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array('title'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        // 'taxonomies'          => array('seasons'),
        'rewrite' => array('slug' => 'performance', 'with_front' => false),
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
        'menu_position'       => 18,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    // Registering Custom Post Type Blogs
    register_post_type('performance', $args);


    // Set UI labels for Custom Post Type Members
    $labels = array(
        'name'                => _x('Members', 'Post Type General Name', 'upv'),
        'singular_name'       => _x('Member', 'Post Type Singular Name', 'upv'),
        'menu_name'           => __('Members', 'upv'),
        'parent_item_colon'   => __('Parent Member', 'upv'),
        'all_items'           => __('All Members', 'upv'),
        'view_item'           => __('View Member', 'upv'),
        'add_new_item'        => __('Add New Member', 'upv'),
        'add_new'             => __('Add New', 'upv'),
        'edit_item'           => __('Edit Member', 'upv'),
        'update_item'         => __('Update Member', 'upv'),
        'search_items'        => __('Search Member', 'upv'),
        'not_found'           => __('Not Found', 'upv'),
        'not_found_in_trash'  => __('Not found in Trash', 'upv'),
    );

    // Set other options for Custom Post Type
    $args = array(
        'label'               => __('member', 'upv'),
        'description'         => __('Members listing', 'upv'),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => ['title', 'editor', 'thumbnail'],
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array('capacities'),
        'rewrite' => array('slug' => 'member', 'with_front' => false),
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
        'menu_position'       => 18,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    // Registering Custom Post Type Blogs
    register_post_type('member', $args);    
}


function custom_taxonomy_type()
{
    register_taxonomy(
        'season',
        'show',
        array(
            'labels'    => array(
                'name'  => 'Seasons',
                'add_new_item'  => 'Add New Season',
                'new_item_name' => 'New Season'
            ),
            'show_ui'   => TRUE,
            'show_tagcloud' => FALSE,
            'hierarchical'  => TRUE
        )
    );
}

/**
 * Custom Fields in Posts
 */
function admin_init()
{
    add_meta_box('show_dates_meta', 'Show Dates &amp; Times', '\CustomPosts\show_dates', 'show');
    add_meta_box('show_credits_meta', 'Show Credits', '\CustomPosts\show_credits', 'show');
    add_meta_box('show_meta', 'Show Name', '\CustomPosts\showName', 'performance', 'side');
    add_meta_box('performance_meta', 'Performance Details', '\CustomPosts\performanceDetails', 'performance', 'side');
    add_meta_box('performance_preview_meta', 'Preview', '\CustomPosts\preview', 'performance', 'side');
    add_meta_box('performance_talkback_meta', 'Talkback', '\CustomPosts\talkback', 'performance', 'side');
    add_meta_box('performance_soldout_meta', 'Sold Out', '\CustomPosts\soldout', 'performance', 'side');
    add_meta_box('performance_tickets_sold', 'Tickets Sold', '\CustomPosts\tickets_sold', 'performance', 'side' );
    add_meta_box('member_title', 'Title or Position', '\CustomPosts\member_title', 'member' );
    add_meta_box('show_seats', 'Show Seats', '\CustomPosts\show_seats', 'show', 'side' );
    add_meta_box('show_production_photos', 'Show Production Photos', '\CustomPosts\show_production_photos', 'show' );
    add_meta_box('order_amend_link', 'Amend Order', '\CustomPosts\order_amend_link', 'woocommerce_page_wc-orders', 'side' );

    // add_meta_box('show_promote_meta', 'Promote Show', '\CustomPosts\promote_show', 'show', 'side', 'high' );
    // add_meta_box('show_cast_meta', 'Show Cast & Crew', '\CustomPosts\show_cast', 'show', 'side', 'high' );
    // add_meta_box('session_cart', 'Cart Data from Session', '\CustomPosts\session_cart' );

}


function show_dates()
{
    global $post;
    $custom = get_post_custom($post->ID);
    $start_date = (isset($custom['start_date'][0])) ? $custom['start_date'][0] : '';
    $end_date   = (isset($custom['end_date'][0])) ? $custom['end_date'][0] : '';
?>
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" value="<?php echo $start_date; ?>" />
    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" value="<?php echo $end_date; ?>" />

<?php
}

function save_show_dates()
{
    global $post;
    if (empty($post->ID)) return;
    $custom     = get_post_custom($post->ID);
    $pre_start_date = (isset($custom['start_date'][0])) ? $custom['start_date'][0] : '';
    $pre_end_date   = (isset($custom['end_date'][0])) ? $custom['end_date'][0] : '';
    $start_date = $_POST['start_date'];
    $end_date   = $_POST['end_date'];
    $show_id    = (string) $post->ID; //pvd($post->ID); die($show_id);

    $p         = [];


    if ($start_date != $pre_start_date || $end_date != $pre_end_date) {
        update_post_meta($post->ID, 'start_date', $start_date);
        update_post_meta($post->ID, 'end_date', $end_date);

        // Since either the Start Date or the End Date have changed, we need to regenerate all the performance dates
        // delete all posts that have something in a custom field
        \CustomPosts\delete_performances($post->ID);

        // Generate new performance dates
        $options    = get_option('performance_options');
        // var_dump($options);
        $begin      = new \DateTime($start_date);
        $end        = new \DateTime($end_date);
        $interval   = new \DateInterval('P1D');
        $daterange  = new \DatePeriod($begin, $interval, $end);

        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            $dateTime = $i->format('j M Y');
            $dayofweek  = (date('w', strtotime($dateTime)) + 6) % 7;
            if (isset($options["'m'"][$dayofweek])) {
                \CustomPosts\create_performance($dateTime, $show_id, $options['performance_field_matinee_starttime']);
            }
            if (isset($options["'e'"][$dayofweek])) {
                \CustomPosts\create_performance($dateTime, $show_id, $options['performance_field_evening_starttime']);
            }
        }
    }
}

function show_credits() 
{
    global $post;
    $custom = get_post_custom($post->ID);
    $writing_credits    = isset($custom['writing_credits'][0]) ? $custom['writing_credits'][0] : '';
    $directing_credits  = isset($custom['directing_credits'][0]) ? $custom['directing_credits'][0] : '';
?>
    <label for="writing_credits">Writing Credits:</label>
    <textarea name="writing_credits"><?php echo $writing_credits; ?></textarea>
    <label for="directing_credits">Directing Credits:</label>
    <textarea name="directing_credits" ><?php echo $directing_credits; ?></textarea>

<?php
}

function save_show_credits()
{
    global $post;
    if (empty($post->ID)) return; 
    $writing_credits    = $_POST['writing_credits']; 
    $directing_credits  = $_POST['directing_credits'];
    update_post_meta($post->ID, 'directing_credits', $directing_credits);
    update_post_meta($post->ID, 'writing_credits', $writing_credits);
}


function showName()
{
    global $post;
    $custom     = get_post_custom($post->ID);
    $show_id    = $custom['show_id'][0] ? $custom['show_id'][0] : '';
    $showPost   = get_post($show_id);
?>
    <p><?php echo $showPost->post_title; ?></p>
<?php
}

function tickets_sold()
{
    global $post;
    $tickets_sold       = get_post_meta($post->ID, 'tickets_sold', TRUE ); //pvd($tickets_sold);

?>
    <p><?php  echo isset( $tickets_sold['count'] ) ? $tickets_sold['count'] : 0; ?></p>
<?php
}

function performanceDetails()
{
    global $post;
    $custom             = get_post_custom($post->ID);
    $performance_time   = $custom['performance_time'][0] ? $custom['performance_time'][0] : '';
?>
    <label for="performance_time">Performance Time:</label>
    <input type="time" name="performance_time" value="<?php echo $performance_time; ?>" />

<?php
}

function save_performance_time()
{
    global $post;
    $performance_time   = $_POST['performance_time'];
    update_post_meta($post->ID, 'performance_time', $performance_time);
}


function create_performance($date, $show_id, $time)
{
    $post_id = wp_insert_post(array(
        'post_type' => 'performance',
        'post_title' => $date,
        'post_content' => '',
        'post_status' => 'publish',
        'comment_status' => 'closed',   // if you prefer
        'ping_status' => 'closed',      // if you prefer
    ));

    if ($post_id) {
        add_post_meta($post_id, 'show_id', $show_id);
        add_post_meta($post_id, 'performance_time', $time);
    }
}

function delete_performances($show_id)
{
    $args = array(
        'posts_per_page'    => -1,
        'post_type'         => 'performance',
        'meta_key'          => 'show_id',
        'meta_value'        => $show_id
    );
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) :
            $the_query->the_post();
            wp_delete_post(get_the_ID());
        endwhile;
    }
    wp_reset_postdata();
}

function preview()
{
    global $post;
    $custom             = get_post_custom($post->ID);
    $preview   = isset($custom['preview']) ? $custom['preview'][0] : '';
?>
    <label for="preview">Preview performance:</label>
    <input type="checkbox" name="preview" value="1" <?php echo ((int) $preview == 1) ? 'checked="checked"' : ''; ?> />

<?php

}

function save_preview()
{
    global $post;
    $preview   = isset($_POST['preview']) ? $_POST['preview'] : '';
    update_post_meta($post->ID, 'preview', $preview);
}

function talkback()
{
    global $post;
    $custom             = get_post_custom($post->ID);
    $talkback   = isset($custom['talkback']) ? $custom['talkback'][0] : '';
?>
    <label for="talkback">Talkback performance:</label>
    <input type="checkbox" name="talkback" value="1" <?php echo ((int) $talkback == 1) ? 'checked="checked"' : ''; ?> />

<?php

}

function save_talkback()
{
    global $post;
    $talkback   = isset($_POST['talkback']) ? $_POST['talkback'] : '';
    update_post_meta($post->ID, 'talkback', $talkback);
}

function promote_show()
{
    global $post;
    $custom         = get_post_custom( $post->ID ); 
    $promote_show   = isset( $custom['promote_show'] ) ? $custom['promote_show'][0] : '';
?>
    <label for="promote_show">Promote Show:</label>
    <input type="checkbox" name="promote_show" value="1" <?php echo ((int) $promote_show == 1 ) ? 'checked="checked"' : ''; ?> />
<?php

}

function save_promote_show()
{
    global $post;
    $promote_show   = isset($_POST['promote_show']) ? $_POST['promote_show'] : ''; 
    update_post_meta($post->ID, 'promote_show', $promote_show);
}


function show_cast()
{
    global $post;
    $custom         = get_post_custom( $post->ID );
    $show_cast      = isset( $custom['show_cast'] ) ? $custom['show_cast'][0] : '';
?>
    <label for="show_cast">Show Cast & Crew:</label>
    <textarea name="show_cast"><?php echo $show_cast; ?></textarea>
<?php
}

function save_show_cast()
{
    global $post;
    $show_cast  = isset( $_POST['show_cast'] ) ? $_POST['show_cast'] : '';
    update_post_meta($post->ID, 'show_cast', $show_cast );
}


function member_title()
{
    global $post;
    $custom         = get_post_custom( $post->ID );
    $member_title   = isset( $custom['member_title'] ) ? $custom['member_title'][0] : '';
?>
    <label for="member_title">Member Title or Position:</label>
    <input type="text" name="member_title" value="<?php echo $member_title; ?>" />
<?php    
}

function save_member_title()
{
    global $post;
    $member_title  = isset( $_POST['member_title'] ) ? $_POST['member_title'] : '';
    update_post_meta($post->ID, 'member_title', $member_title );
}

function show_seats()
{
    global $post;
    $custom = get_post_custom( $post->ID );
    $show_seats  = isset( $custom['show_seats'] ) ? $custom['show_seats'][0] : 100; // Should be in settings
?>
    <label for="show_seats">Number of Seats for Show:</label>
    <input type="number" name="show_seats" value="<?php echo $show_seats; ?>" />
<?php
}

function save_show_seats()
{
    global $post;
    $show_seats  = isset( $_POST['show_seats'] ) ? $_POST['show_seats'] : 100;
    update_post_meta($post->ID, 'show_seats', $show_seats );
}

function show_production_photos()
{
    global $post;
    $custom = get_post_custom( $post->ID );
    $show_production_photos  = isset( $custom['show_production_photos'] ) ? $custom['show_production_photos'][0] : '';
?>
    <label for="show_production_photos">Photos from Show:</label>
    <textarea name="show_production_photos"><?php echo $show_production_photos; ?></textarea>
<?php
}

function save_show_production_photos()
{
    global $post;
    $show_production_photos  = isset( $_POST['show_production_photos'] ) ? $_POST['show_production_photos'] : '';
    update_post_meta($post->ID, 'show_production_photos', $show_production_photos );
}

function soldout()
{
    global $post;
    $custom = get_post_custom( $post->ID );
    $sold_out  = isset( $custom['sold_out'] ) ? $custom['sold_out'][0] : '';
?>
    <label for="sold_out">Performance Sold Out:</label>
    <input type="checkbox" name="sold_out" value="1" <?php echo ((int) $sold_out == 1 ) ? 'checked="checked"' : ''; ?> />
<?php
}

function save_soldout()
{
    global $post;
    $sold_out = isset( $_POST['sold_out'] ) ? $_POST['sold_out'] : '';
    update_post_meta($post->ID, 'sold_out', $sold_out );
}

function order_amend_link()
{
?>
    <p><a href="/ticket-admin?orderId=<?php echo $_GET['id']; ?>" target="_blank">Amend order</a></p>
<?php
    
}


/**
 * Switches out Excerpt box and adds in one with TinyMCE
 * https://wordpress.stackexchange.com/questions/58261/adding-a-rich-text-editor-to-excerpt
 */
function switch_excerpt_boxes()
{
    if ( ! post_type_supports( $GLOBALS['post']->post_type, 'excerpt' ) )
    {
        return;
    }  
    if ( $GLOBALS['post']->post_type != "show") {
        return;
    }

    remove_meta_box(
        'postexcerpt',
        'show',
        'normal'
    );

    add_meta_box(
        'postexcerpt2',
        __('Excerpt'),
        '\CustomPosts\showNewExcerpt',
        'show',
        'normal',
        'core'
    );
}

/**
     * Output for the meta box.
     *
     * @param  object $post
     * @return void
     */
    function showNewExcerpt( $post )
    { 
    ?>
        <label class="screen-reader-text" for="excerpt"><?php
        _e( 'Excerpt' )
        ?></label>
        <?php
        // We use the default name, 'excerpt', so we don’t have to care about
        // saving, other filters etc.
        wp_editor(
            \CustomPosts\unescape( $post->post_excerpt ),
            'excerpt',
            array (
            'textarea_rows' => 15
        ,   'media_buttons' => FALSE
        ,   'teeny'         => TRUE
        ,   'tinymce'       => TRUE
            )
        );
    }

    /**
     * The excerpt is escaped usually. This breaks the HTML editor.
     *
     * @param  string $str
     * @return string
     */
    function unescape( $str )
    {
        return str_replace(
            array ( '&lt;', '&gt;', '&quot;', '&amp;', '&nbsp;', '&amp;nbsp;' )
        ,   array ( '<',    '>',    '"',      '&',     ' ', ' ' )
        ,   $str
        );
    }


				
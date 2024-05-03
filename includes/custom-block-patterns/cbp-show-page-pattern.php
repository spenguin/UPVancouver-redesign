<?php
/**
 * Custom Block Pattern: Three Body Pattern
 */

$show_page_pattern = [
    'title'         => __('Show Page Pattern', 'upv'),
    'categories'    => ['custom'],
    'description'   => _x('Show Page Pattern', 'Block pattern description', 'upv'),
    'content'       => '
    <!-- wp:group {"className":"show-page"} -->
    <div class="wp-block-group show-page">
        <!-- wp:group {"className":"show-page__main"} -->
        <div class="wp-block-group show-page__main">
            <!-- wp:heading {"level":3} -->
            <h3 class="wp-block-heading">Main</h3>
            <!-- /wp:heading -->
    
            <!-- wp:paragraph -->
            <p>Main content</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
    
        <!-- wp:group {"className":"show-page__sidebar"} -->
        <div class="wp-block-group show-page__sidebar">
            <!-- wp:group {"className":"show-page__sidebar--cast"} -->
            <div class="wp-block-group show-page__sidebar--cast">
                <!-- wp:heading {"level":3} -->
                <h3 class="wp-block-heading">Sidebar</h3>
                <!-- /wp:heading -->
        
                <!-- wp:paragraph -->
                <p>Cast</p>
                <!-- /wp:paragraph -->
            </div><!-- /wp:group -->

            <!-- wp:group {"className":"show-page__sidebar--production"} -->
            <div class="wp-block-group show-page__sidebar--production">
                <!-- wp:heading {"level":3} -->
                <h3 class="wp-block-heading">Sidebar</h3>
                <!-- /wp:heading -->
        
                <!-- wp:paragraph -->
                <p>Production</p>
                <!-- /wp:paragraph -->
            </div><!-- /wp:group -->            

        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->'
];
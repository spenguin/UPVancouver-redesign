<?php
/**
 * Custom Block Pattern: Three Body Pattern
 */

$three_body_pattern = [
    'title'         => __('Three Body Pattern', 'upv'),
    'categories'    => ['custom'],
    'description'   => _x('Three Body Pattern', 'Block pattern description', 'upv'),
    'content'       => '
    <!-- wp:group {"className":"three-body"} -->
    <div class="wp-block-group three-body">
        <!-- wp:group {"className":"three-body__top"} -->
        <div class="wp-block-group three-body__top">
            <!-- wp:heading {"level":3} -->
            <h3 class="wp-block-heading">Top</h3>
            <!-- /wp:heading -->
    
            <!-- wp:paragraph -->
            <p>Top</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
    
        <!-- wp:group {"className":"three-body__sidebar"} -->
        <div class="wp-block-group three-body__sidebar">
            <!-- wp:heading {"level":3} -->
            <h3 class="wp-block-heading">Sidebar</h3>
            <!-- /wp:heading -->
    
            <!-- wp:paragraph -->
            <p>Sidebar</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
    
        <!-- wp:group {"className":"three-body__bottom"} -->
        <div class="wp-block-group three-body__bottom">
            <!-- wp:heading {"level":3} -->
            <h3 class="wp-block-heading">Bottom</h3>
            <!-- /wp:heading -->
    
            <!-- wp:paragraph -->
            <p>Bottom</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->'
];

//  // Register your own category
// register_block_pattern_category('custom', array(
//     'label' => __('Custom', 'my-plugin')
// ));

// // Register block pattern
// register_block_pattern('my-plugin/heading-para-img-buttons', array(
//     'title' => __('Heading, Paragraph, Image with Buttons', 'my-plugin'),
//     'categories' => array(
//         'custom'
//     ),
//     'description' => _x('One heading, paragraph, image with buttons in a group', 'Block pattern description', 'my-plugin'),
//     'content' => '<!-- wp:group {"layout":{"type":"constrained"}} -->
//                     <div class="wp-block-group"><!-- wp:heading {"level":3} -->
//                     <h3 class="wp-block-heading">Heading</h3>
//                     <!-- /wp:heading -->
                    
//                     <!-- wp:paragraph -->
//                     <p>Paragraph</p>
//                     <!-- /wp:paragraph -->
                    
//                     <!-- wp:image -->
//                     <figure class="wp-block-image"><img alt=""/></figure>
//                     <!-- /wp:image -->
                    
//                     <!-- wp:buttons -->
//                     <div class="wp-block-buttons"><!-- wp:button -->
//                     <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Button A</a></div>
//                     <!-- /wp:button -->
                    
//                     <!-- wp:button -->
//                     <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Button B</a></div>
//                     <!-- /wp:button --></div>
//                     <!-- /wp:buttons --></div>
//                  <!-- /wp:group -->'
// ));
<?php
/**
 * Custom Block Patterns
 */

require_once ('custom-block-patterns/cbp-three-body-pattern.php');
require_once ('custom-block-patterns/cbp-show-page-pattern.php');

// Register your own category
register_block_pattern_category( 'custom', [
    'label' => __('UPV', 'upv')
]);


// Register block pattern

register_block_pattern('upv/three-body-pattern', $three_body_pattern);
register_block_pattern('upv/show-page-pattern', $show_page_pattern);
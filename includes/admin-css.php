<?php
/**
 * CSS for Admin pages
 */

 add_action('admin_head', 'upv_admin_css');

function upv_admin_css() {
    echo '<style>
        .preview.column-preview {
            width: 100%;
        }  
    </style>';
}
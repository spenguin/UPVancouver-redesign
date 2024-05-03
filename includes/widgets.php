<?php
/**
 * Widgets
 */

add_action( 'widgets_init', 'register_widget_areas' ); 

function register_widget_areas() {

    register_sidebar( array(
      'name'          => 'Footer Social Media',
      'id'            => 'footer_social_media',
      'description'   => 'Social Media Widget for Footer',
      'before_widget' => '<section class="footer-social-media">',
      'after_widget'  => '</section>',
      'before_title'  => '<h4>',
      'after_title'   => '</h4>',
    ));
    
}
  

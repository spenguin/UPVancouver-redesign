<?php

add_theme_support( 'post-thumbnails' );


// add_filter( 'the_content', function ($content) 
// {   die(var_dump($content));
//     if( empty($content) ) return "";
//     $doc = new DOMDocument();
//     $doc->loadHTML($content, );
//     $imgs = $doc->getElementsByTagName('img');   die(var_dump($imgs));

//     $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
//     $featured_image = get_the_post_thumbnail_url($post->ID);


//     for($i = $imgs->length; --$i >= 0;){
//         $node = $imgs->item($i);
//         if (strpos($node->getAttribute('src'), $featured_image) !== false) {
//             $node->parentNode->removeChild($node);
//         }
//     }
//     return $doc->savehtml();
// });


// /**
//  * Strip feature image from the_content
//  * @param (int) ID 
//  * @return (string) content
//  */
// public function strip_feature_image( $content, $ID )
// {

// }
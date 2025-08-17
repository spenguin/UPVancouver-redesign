<?php
/**
 * Display production photos as a srcset
 */
function upv_production_photos( $atts = [], $content = null, $tag = '' )
{
    if( empty($content)) return NULL;

    // $pattern = "/src=([^\\\"]+)/";

    // preg_match_all( $pattern, $content, $imgsrc );
    // pvd($imgsrc);

    $content = explode( '<br />', $content ); 

    foreach( $content as $c )
    {
        if(empty($c)) continue;
        $parsedFoo  = json_decode(json_encode(simplexml_load_string($c)), true);
        $src        = $parsedFoo['@attributes']['src']; var_dump($src);
        $id         = attachment_url_to_postid( "https://upv.weirdspace.xyz/wp-content/uploads/2024/12/DSC_2047-Enhanced-NR-1006x1024" );
        var_dump( $id );
        // var_dump(); // output: "http://example.com/img/image.jpg"

    }

    // $html = str_get_html($content); 

}
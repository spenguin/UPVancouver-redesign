<?php
/**
 * Create and use End Points
 */

// namespace restRoutes;

// \restRoutes\initialize();

// function initialize()
// {

// }

add_action('rest_api_init', function () {
    register_rest_route('my-app/v1', '/amend-cart', array(
        'methods' => 'POST',
        'callback' => 'amendCartSessionVariable',
        'permission_callback' => '__return_true', // Caution: Set real permissions for production
    ));
});


function amendCartSessionVariable( $request )
{
    $params = $request->get_json_params(); 
    // Do your custom manipulation...
    return array('status' => 'success', 'result' => 'Data processed!');    
}
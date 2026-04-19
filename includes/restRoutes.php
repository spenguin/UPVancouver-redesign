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
    extract( $params );
    $localTickets = json_decode($localTickets);
    if( empty( $showId ))
    {
        return ['status' => 'error', 'message' => 'There was an error with the order. Please try again. <span class="error-message">Err: 001</span>'];
    } elseif( $showId == -1 )
    {
        // Season Ticket order
    } else {
        // Performance purchase
        if( empty( $selectedPerformance ) )
        {
            return ['status' => 'error', 'message' => 'There was an error with the order. Please try again. <span class="error-message">Err: 002</span>'];
        }
    }

    // Do your custom manipulation...
    return array('status' => 'success', 'result' => 'Data processed!', 'params' => $localTickets);    
}
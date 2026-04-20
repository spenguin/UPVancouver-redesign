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
    $params         = $request->get_json_params(); 
    extract( $params );
    $ticketsOrdered = json_decode($localTickets);
    $isTicketSpecialAvailable   = FALSE;

    if( empty( $showId ))
    {
        return ['status' => 'error', 'message' => 'Err: 001'];
    } elseif( $showId == -1 )
    {
        // Season Ticket order
        $showTitle  = "Seasons Ticket";
        $showTime   = ""; 
        $performanceDate = "";
        // Test for promo
        $isTicketSpecialAvailable   = isTicketSpecialAvailable(); 

    } else {
        // Performance purchase
        if( empty( $selectedPerformance ) )
        {
            return ['status' => 'error', 'message' => 'Err: 002'];
        }
        // Performance Ticket order        
        $selectedPerformance    = siteFns::getPostByTitle($selectedPerformanceTitle);
        $performanceDate        = date( 'd M Y', (int) $selectedPerformanceTitle );
        $performanceTime        = date( 'h:i a', (int) $selectedPerformanceTitle );
        $showTitle              = performanceFns::getShowTitleByPerformanceDate($selectedPerformanceTitle);
    }

    $seasonTicketsOrdered       = [];

    foreach( $ticketsOrdered as $t )
    {
        if( $t->quantity == 0 ) continue;

        $args  = [
            'product_id'=> $t->ticketid,
            'quantity'  => $t->quantity,
            'performance_title' => $selectedPerformanceTitle,
            'date'      => $performanceDate,
            'time'      => $performanceTime,
            'showTitle' => $showTitle,  
            'misha_custom_price' => $t->charge,
            'name'      => $t->name
        ];   

        if( $isTicketSpecialAvailable )
        {
            $array                  = array_fill( 0, $t->quantity, $t->charge );
            $seasonTicketsOrdered   = array_merge( $seasonTicketsOrdered, $array );
        }
        $_SESSION['cart'][] = $args;
    }

    if( count( $seasonTicketsOrdered ) >= 3 )   // If there are fewer than three tickets ordered, the promo doesn't apply anyway
    {
        rsort($seasonTicketsOrdered);
        $discountTotal = 0;
        foreach( $seasonTicketsOrdered as $k => $s )
        {
            if( ($k+1)%3 == 0 )
            {
                $discountTotal += $s/2;
            }
        }
        $_SESSION['cart']['promoDiscount'] = [
            'product_id'            => getPromoProduct(),
            'showTitle'             => 'Promotional Discount',
            'quantity'              => 1,
            'misha_custom_price'    => -1 * $discountTotal,
            'name'                  => 'Promotional Discount'
        ];
    }     
    
    // Do your custom manipulation...
    return array('status' => 'success', 'result' => 'Data processed!');    
}




    // if( isset($_POST['ticketData'] ) && ($_POST['ticketData'] != "null" ) ) 
    // { //die(pvd($_POST ) );
    //     email_fns::emailAdmin( 'Post data', serialize($_POST) );
    //     $ticketsOrdered = decodeTicketData($_POST['ticketData']); 
    //     $selectedPerformanceTitle  = $_POST['selectedPerformance']; 
    //     $isTicketSpecialAvailable   = FALSE;
    //     if( empty($selectedPerformanceTitle) )
    //     {
    //         $showTitle  = "Seasons Ticket";
    //         $showTime   = ""; 
    //         $performanceDate = "";
    //         // Test for promo
    //         $isTicketSpecialAvailable   = isTicketSpecialAvailable(); 
    //         $seasonTicketsOrdered       = [];

    //     } else {
    //         $selectedPerformance    = siteFns::getPostByTitle($selectedPerformanceTitle);
    //         $performanceDate        = date( 'd M Y', (int) $selectedPerformanceTitle );
    //         $performanceTime        = date( 'h:i a', (int) $selectedPerformanceTitle );
    //         $showTitle              = performanceFns::getShowTitleByPerformanceDate($selectedPerformanceTitle);
    //     }

    //     $seasonTicketsOrdered   = [];
    //     foreach( $ticketsOrdered as $t ) 
    //     { 
    //         if( $t->quantity == 0 ) continue;
    //         $args  = [
    //             'product_id'=> $t->ticketid,
    //             'quantity'  => $t->quantity,
    //             'performance_title' => $selectedPerformanceTitle,
    //             'date'      => $performanceDate,
    //             'time'      => $performanceTime,
    //             'showTitle' => $showTitle,  
    //             'misha_custom_price' => $t->charge,
    //             'name'      => $t->name
    //         ];
            
    //         if( $isTicketSpecialAvailable )
    //         {
    //             $array                  = array_fill( 0, $t->quantity, $t->charge );
    //             $seasonTicketsOrdered   = array_merge( $seasonTicketsOrdered, $array );
    //         }
    //         $_SESSION['cart'][] = $args;
    //     }
    //     if( count( $seasonTicketsOrdered ) >= 3 )   // If there are fewer than three tickets ordered, the promo doesn't apply anyway
    //     {
    //         rsort($seasonTicketsOrdered);
    //         $discountTotal = 0;
    //         foreach( $seasonTicketsOrdered as $k => $s )
    //         {
    //             if( ($k+1)%3 == 0 )
    //             {
    //                 $discountTotal += $s/2;
    //             }
    //         }
    //         $_SESSION['cart']['promoDiscount'] = [
    //             'product_id'            => getPromoProduct(),
    //             'showTitle'             => 'Promotional Discount',
    //             'quantity'              => 1,
    //             'misha_custom_price'    => -1 * $discountTotal,
    //             'name'                  => 'Promotional Discount'
    //         ];
    //     } 
        
    // }
<?php

/**
 * Render Cart for UPV
 */

function upv_cart()
{ 
    if( isset($_POST['ticketData'] ) ) {
        $ticketsOrdered = decodeTicketData($_POST['ticketData']); //die(pvd($ticketsOrdered));
    $selectedPerformanceId  = $_POST['selectedPerformance'];
    $selectedPerformance    = get_post($selectedPerformanceId); 
    // Get show that corresponds to the selected Date
    $performanceMeta        = get_post_meta($selectedPerformanceId); 
    $showTitle              = get_the_title($performanceMeta['show_id'][0]);            
        foreach( $ticketsOrdered as $t ) 
        {
            if( $t->quantity == 0 ) continue;
            $varations  = [
                'date'      => $selectedPerformance->post_title,
                'time'      => $performanceMeta['performance_time'][0],
                'showTitle' => $showTitle,  
                'misha_custom_price' => $t->charge
            ];
            WC()->cart->add_to_cart( $t->ticketid, $t->quantity, 0, [], $varations );
        }
    }

    if( isset($_POST['donation']) ){
        // Do something with the donation
        $donationProductId  = getDonationProduct(); 
        WC()->cart->add_to_cart($donationProductId, 1, 0, [], ['misha_custom_price' => $_POST['donation']] );
    }

    if( isset($_GET['del']) ){
        // Remove item from cart
        WC()->cart->remove_cart_item( $_GET['del'], 0 );
    }
        //die(pvd(WC()->cart->cart_contents));
    echo do_shortcode('[woocommerce_cart]');
    // 
}
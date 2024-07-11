<?php

/**
 * Render Cart for UPV
 */

function upv_cart()
{ 
    // updateTicketOrder(); //pvd($_SESSION['ticketsOrdered']);
    // die(pvd($_POST));
    $ticketsOrdered = decodeTicketData($_POST['ticketData']); //die(pvd($ticketsOrdered));
    foreach( $ticketsOrdered as $t ) 
    {
        if( $t->quantity == 0 ) continue;
        WC()->cart->add_to_cart( $t->ticketid, $t->quantity );
    }
    echo do_shortcode('[woocommerce_cart]');
}


function decodeTicketData($ticketData)
{
    return json_decode(str_replace( "\\","", $ticketData ) );
}
 
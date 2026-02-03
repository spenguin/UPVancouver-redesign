<?php
/**
 * Correct Order Note data
 */

function upv_correct_order_notes()
{
    $args   = [
        'limit' => 10,
        'return'    => 'ids'
    ];

    $orderIds = wc_get_orders( $args );
    foreach( $orderIds as $orderId )
    {
        $orderNote  = new Order_note($orderId); 
        $note       = $orderNote->_note;
        if( empty($note) ) continue;
        $changed    = FALSE;
        foreach( $note as $key => $entry )
        {
            if( !is_numeric($key) ) continue;
            if( !array_key_exists('performance_title', $entry ) )
            {
                $note[$key]['performance_title']    = strtotime( $note[$key]['date'] . ' ' . $note[$key]['time'] );
                $changed = TRUE;
                
            }
        }
        if( $changed )
        {
            echo '<p>' . $orderId . '</p>';
            $orderNote->set_order_note( $orderId, $note );
        }
    }
}
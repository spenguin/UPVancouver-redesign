<?php
/**
 * Performance Functions class
 */
class performance_fns
{
    public static function count_tickets_sold( $tickets )
    {
        $count = 0;
        foreach( $tickets as $orderId => $order )
        {
            if( $orderId == "count" ) continue;
            foreach( $order as $order_count )
            {
                $count += $order_count;
            }
        }
        return $count;
    }
}
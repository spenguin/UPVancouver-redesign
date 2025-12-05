<?php
/**
 * Add single purchases (or upload purchases as a spreadsheet)
 * Or Edit an existing order
 */

function upv_delete_order()
{
    if( !isset($_GET['order_id'] ) ) 
    {
        header('Location: ' . site_url() . '/wp-admin/admin.php?page=wc-orders' );
        exit();
    }

    $order_id = filter_var($_GET['order_id'], FILTER_SANITIZE_NUMBER_INT); 
        
    // Get the order details from the orderId
    $order = wc_get_order( $order_id ); 
    $order_note     = get_order_note( $order_id ); //die(pvd($order_note));

    // Just to double check that the order is deletable
    if( confirm_deleteable($order_note) )
    {
        $order_line = reset( $order_note ); 
        // Remove order from Performance ticket count
        $date_time      = strtotime( $order_line['date'] . ' ' . $order_line['time'] );
        $performance    = get_post_by_title( $date_time, '', 'performance' ); //pvd($performance);
        $tickets_sold   = performance_fns::get_tickets_sold( $performance->ID );//pvd($tickets_sold);
        $tickets_sold['count'] -= $order_line['quantity'];
        unset($tickets_sold[$order_id]); //pvd($tickets_sold);
        update_post_meta( $performance->ID, 'tickets_sold', $tickets_sold );

        // Change status of order to Cancelled; should trigger an automatic email
        $order->update_status('cancelled');
        echo '<p>Order has been cancelled</p>';

    } else {
        ?>
        <p>This order cannot be deleted. Please check the Order Id.</p>
        <?php
    }

}

function confirm_deleteable($order_note)
{
    $delete = TRUE;
    foreach( $order_note as $key => $order_line )
    {
        if( !in_array( $order_line['name'], ["Seasons", "Season", "Comp"] ) ) $delete = FALSE;
        
    }
    return $delete;
}
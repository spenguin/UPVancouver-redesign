<?php
/**
 * Create a report of tickets sold or ordered for a specific performance
 */

function upv_performance_report()
{
    $performance_id = get_query_var( 'performance_id' );
    $performance    = get_post( $performance_id );
    $show_id        = get_post_meta( $performance_id, 'show_id', TRUE );
    $show           = get_post( $show_id );
    echo '<h3>Tickets sold for ' . date( 'd M Y h:i a', $performance->post_title ) . ' performance of ' . $show->post_title . '</h3>';
    if( isset($_REQUEST['download']) )
    {
        array_csv_download( $performance );
    }
    
    $tickets_sold   = get_post_meta($performance_id,'tickets_sold', TRUE); //pvd($tickets_sold);
    $ticket_types   = ticketFns::getSingleShowTickets(); 
    $statuses       = [
        'processing'    => 'Pay at Box Office',
        'complete'      => 'Paid',
        'completed'     => 'Paid'
    ];
    unset( $tickets_sold['count'] );
    if( empty($tickets_sold) )
    {
        return '<p>No tickets sold.</p>';
    }
    ?>
    <p><a href="<?php echo site_url(); ?>/performance-report/?performance_id=<?php echo $performance_id; ?>&download=true">Download CSV</a><p>
    <table class="upv-table order-table">
        <thead>
            <tr>
                <td>Name</td>
                <td>Paid status</td>
                <td>Ticket Qty</td>
                <td>Notes</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach( $tickets_sold as $order_id => $tickets )
                {  
                    if( $order_id == "2427" ) continue;
                    $order          = new WC_Order( $order_id ); 
                    $last_name      = $order->get_billing_last_name();
                    $first_name     = $order->get_billing_first_name();
                    $name           = empty( $last_name . $first_name ) ? $order_id : $last_name . ', ' . $first_name;
                    $status         = $order->get_status();
                    $note           = $order->get_customer_note();
                    ?>
                    <tr>
                        <td><a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=wc-orders&action=edit&id=<?php echo $order_id; ?>" target="_blank"><?php echo $name; ?></a></td>
                        <td><?php echo $statuses[$status]; ?></td>
                        <?php if( is_array($tickets)) $tickets = array_sum($tickets); ?>
                        <td><?php echo $tickets; ?> <!--array_sum($tickets); ?>--></td>
                        <td><?php echo $note; ?></td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
    <?php
}
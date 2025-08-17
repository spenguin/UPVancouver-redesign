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
    echo '<h3>Tickets sold for ' . $performance->post_title . ' performance of ' . $show->post_title . '</h3>';
    if( isset($_REQUEST['download']) )
    {
        array_csv_download( $performance );
    }
    
    $tickets_sold   = get_post_meta($performance_id,'tickets_sold', TRUE);
    $ticket_types   = getSingleShowTickets(); 
    $statuses       = [
        'processing'    => 'Pay at Box Office',
        'complete'      => 'Paid'
    ];
    unset( $tickets_sold['count'] );
    if( empty($tickets_sold) )
    {
        return '<p>No tickets sold.</p>';
    }
    ?>
    <p><a href="/performance-report/?performance_id=<?php echo $performance_id; ?>&download=true">Download CSV</a><p>
    <!-- <table class="upv-table order-table">
        <thead>
            <tr>
                <td>Name</td>
                <td>Paid status</td>
                <td>Season</td>
                <td>Preview</td>
                <td>Student</td>
                <td>Senior</td>
                <td>Adult</td>
                <td>Comp</td>
                <td>Order Note</td>
                <td>Order Note (Admin)</td>
                <td>Customer Note (Admin)</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach( $tickets_sold as $order_id => $tickets )
                {
                    $order          = new WC_Order( $order_id ); 
                    $name           = $order->get_billing_last_name() . ', ' . $order->get_billing_first_name(); 
                    $status         = $order->get_status();
                    $note           = $order->get_customer_note();
                    ?>
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $statuses[$status]; ?></td>
                        <?php
                            foreach( $ticket_types as $ticket_type_id => $ticket_name )
                            {
                                echo '<td>';
                                if( array_key_exists( $ticket_type_id, $tickets ) )
                                {
                                    echo $tickets[$ticket_type_id]; 
                                } else {
                                    echo "&nbsp;";
                                }
                                echo '</td>';
                            }

                        ?>
                        <td><?php echo $note; ?></td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
    </table> -->
    <?php
}
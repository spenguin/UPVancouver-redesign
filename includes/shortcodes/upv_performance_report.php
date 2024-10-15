<?php
/**
 * Create a report of tickets sold or ordered for a specific performance
 */

function upv_performance_report()
{
    $performance_id = get_query_var( 'performance_id' );
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
    <table class="upv-table order-table">
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
                <td>Note</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach( $tickets_sold as $order_id => $tickets )
                {
                    $order          = new WC_Order( $order_id ); 
                    $name           = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); 
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
    </table>
    <?php
}
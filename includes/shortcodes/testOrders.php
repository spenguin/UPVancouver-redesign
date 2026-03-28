<?php
/** Test Orders shortcode
 * 
 */
function testOrders()
{
// Ensure WooCommerce functions are available, especially if used outside a standard WC request
if ( function_exists( 'wc_get_orders' ) ) {

    // Arguments to retrieve all orders
    $args = array(
        'limit'   => 10, // Retrieve all orders without pagination
        'status'  => 'wc-completed', //array_keys( wc_get_order_statuses() ), // Include all order statuses
        'orderby' => 'date_created',
        'order'   => 'ASC', // Or 'DESC' for most recent first
    );

    // Get an array of WC_Order objects
    $orders = wc_get_orders( $args );

    if ( ! empty( $orders ) ) {
        // Loop through each order object
        foreach ( $orders as $order ) {
            // Access order data
            $order_id = $order->get_id(); // Get the order ID
            $order_status = $order->get_status(); // Get the order status
            $customer_id = $order->get_customer_id(); // Get the customer ID
            $total = $order->get_total(); // Get the order total

            // Perform actions with order data, e.g., print details
            echo "Order ID: " . esc_html( $order_id ) . " | Status: " . esc_html( $order_status ) . " | Total: " . esc_html( $total ) . "<br>";

            // Loop through order items (products) within the order loop
            foreach ( $order->get_items() as $item_id => $item ) {
                $product_name = $item->get_name();
                $quantity = $item->get_quantity();
                echo " - Product: " . esc_html( $product_name ) . " (Qty: " . esc_html( $quantity ) . ")<br>";
            }

            $orderNoteClass = new Order_note($order_id);
            $orderNote      = $orderNoteClass->get_order_note();
            echo  print_r($orderNote) . '<br>';
        }
    } else {
        echo "No orders found.";
    }
}

}
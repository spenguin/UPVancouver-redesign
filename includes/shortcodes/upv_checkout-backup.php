<?php
/**
 * Render Checkout for UPV
 */

function upv_checkout()
{ 
    // Test if there is an order in the $_SESSION vars
    if( empty($_SESSION['ticketsOrdered'] ) ) { 
        ob_start();
        ?>
        
        <div class="shopping-cart__buttons">

            <p>You haven't ordered anything.</p>
            <a href="/current-season" class="button button--information">Continue Shopping</a> 
        </div>
        <?php 
        return ob_get_clean();
    } else {
        // $wcClass = new WC(); die(pvd($wc));

// $available_gateways = WC()->payment_gateways->payment_gateways(); die(pvd($available_gateways));

    // $address = array(
    //     'first_name' => $_POST['notes']['domain'],
    //     'last_name'  => '',
    //     'company'    => $_POST['customer']['company'],
    //     'email'      => $_POST['customer']['email'],
    //     'phone'      => $_POST['customer']['phone'],
    //     'address_1'  => $_POST['customer']['address'],
    //     'address_2'  => '', 
    //     'city'       => $_POST['customer']['city'],
    //     'state'      => '',
    //     'postcode'   => $_POST['customer']['postalcode'],
    //     'country'    => 'NL'
    // );

    $address = [
        'first_name'    => 'Test',
        'last_name'     => 'Testerton',
        'company'       => '',
        'email'         => 'test@testerton.com',
        'phone'         => '604 861 1234',
        'address_1'     => '123 Any Street',
        'address_2'     => '',
        'city'          => "Vancouver",
        'state'         => 'BC',
        'postcode'      => 'V1A 1A1',
        'country'       => 'CA'
    ];


    // $order = wc_create_order();
    // // foreach ($_POST['product_order'] as $productId => $productOrdered) :
    // //     $order->add_product( get_product( $productId ), 1 );
    // // endforeach;

    $order = new WC_Order();
    $order->set_created_via( 'admin' );
    $order->set_customer_id( 1 );    

    foreach($_SESSION['ticketsOrdered'] as $t ) 
    {
        $order->add_product( wc_get_product( $t['ticketId'] ), $t['quantity'] );
        WC()->cart->add_to_cart( $t['ticketId'], $t['quantity']);

    }

    

    $order->set_address( $address, 'billing' );
    $order->set_address( $address, 'shipping' );

    $order->calculate_totals();
    $order->set_status( 'wc-processing' );	
    //$order->payment_method = 'square_credit_card';
    //$order->payment_method_title = "Square";
    $orderId = $order->save(); //die(pvd($order));
// die(pvd(WC()->payment_gateways->payment_gateways()));
    $available_gateways = WC()->payment_gateways->get_available_payment_gateways(); die(pvd($available_gateways));
    //die(method_exists($available_gateways[ 'square_credit_card' ], 'process_payment'));

    
    update_post_meta( $orderId, '_payment_method', 'square_credit_card' );
    update_post_meta( $orderId, '_payment_method_title', 'Square' );
	//die(pvd($order));
    // Store Order ID in session so it can be re-used after payment failure
    // WC()->session->order_awaiting_payment = $order->id;

    // Process Payment
    $result = $available_gateways[ 'square_credit_card' ]->process_payment( $orderId ); //die(pvd($result));

    // Redirect to success/confirmation/payment page
    /*if ( $result['result'] == 'success' ) {

        $result = apply_filters( 'woocommerce_payment_successful_result', $result, $order->id );

        wp_redirect( $result['redirect'] );
        exit;
    }*/


        // Render order 

        // Render Coupon form

        // Render Login form (modal?)

        // Render Billing Address

        // Render Postal Address

        // Render Payment Gateway button
    }
}
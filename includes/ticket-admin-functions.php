<?php
/**
 * Functions specific for the Ticket Admin page
*/

function get_order_note($order_id)
{
    $tmp    = get_post_meta( $order_id, 'custom_field_name', TRUE ); 

    if(empty($tmp)) return '';
    $tmp    = unserialize(base64_decode($tmp)); 

    return $tmp;
}

function set_order_note( $order_id, $note )
{
    $tmp    = base64_encode(serialize($note)); 
    update_post_meta( $order_id, 'custom_field_name', $tmp );
}


function get_order_customer( $order )
{
    $billing_email  = $order->get_billing_email(); 
    return get_user_by( 'email', $billing_email ); 
}


function get_admin_order_note($order_id)
{
    $admin_order_note   = '';
    $admin_order_notes  = wc_get_order_notes([
        'order_id' => $order_id
     ]); 
    if( !empty($admin_order_notes) && strpos($admin_order_notes[0]->content, '[ta]') !== FALSE )
    {
        $admin_order_note = trim(substr($admin_order_notes[0]->content, 4 )); 
    }
    return $admin_order_note;
}

function amend_tickets_sold( $date, $quantity, $order_id )
{
    $performance    = SiteFns::getPostByTitle( $date, NULL, 'performance' ); 
    $tickets_sold   = get_post_meta( $performance->ID, 'tickets_sold', TRUE ); 
    
    if( empty($tickets_sold) )
    {
        $tickets_sold           = [];
        // $tickets_sold['count']  = 0;
    } 
    // $tickets_sold['count'] += $quantity;

    if( !array_key_exists( $order_id, $tickets_sold ))
    {
        $tickets_sold[$order_id]    = $quantity;
    } else {
        if(is_array($tickets_sold[$order_id] ) )
        {
            $tickets_sold[$order_id]    = $tickets_sold[$order_id][0];
        }
        $tickets_sold[$order_id]    += $quantity;
    }
    if( 0 == $tickets_sold[$order_id] ) unset($tickets_sold[$order_id]);
    update_post_meta( $performance->ID, 'tickets_sold', $tickets_sold );
}

function email_cart($cart, $orderId='')
{
    $to      = 'info@weirdspace.com'; //'info@soaringpenguin.com';//'weirdspace.business@gmail.com';
    $subject = 'cart';
    $message = serialize($cart); 

    $_res = wp_mail($to, $subject, $message); 
    if(!$_res)
    {
        wp_mail($to, 'Order issue', $orderId); 
    }
}

function test_cart( $cart )
{ 
    foreach( $cart as $key => $item )
    {
        if( isset($item['showTitle']) && $item['showTitle'] == 'Seasons Ticket' ) continue;
        if( $item['name'] == 'Donation' ) continue;
        if( empty($item['performance_title'] ) )
        {
            return FALSE;
        }
    }
    return TRUE;
}
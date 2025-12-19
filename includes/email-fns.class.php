<?php
/**
 * Email  Functions class
 */
class email_fns
{
    public static function customer_delete_order( $order_id, $order )
    {
        $to      = $order->get_billing_email();
        $name    = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); 
        $subject = 'Your Order ' . $order_id . ' has been cancelled';
        $message = '<p>Dear ' . $name . '</p><p>' . $subject . '</p><p>If you think this is in error. please contact United Players at <a href="mailto:patronservices@unitedplayers.com">patronservices@unitedplayers.com</a></p>'; 
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );

        $_res = wp_mail($to, $subject, $message, $headers); 
        if(!$_res)
        {
            wp_mail($to, 'Delete issue', $order_id); 
        }

    }

}
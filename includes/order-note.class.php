<?php
/**
 * A class to maintain Order notes
 */

class Order_note 
{
    public $_note  = [];
    
    function __construct($order_id)
    {
        $this->_note    = $this->get_order_note($order_id);
    }

    function get_order_note($order_id)
    {
        $tmp    = get_post_meta( $order_id, 'custom_field_name', TRUE ); 

        if(empty($tmp)) return '';
        $tmp    = unserialize(base64_decode($tmp)); 

        return $tmp;
    }

    function render_order_note_table()
    {
        ob_start(); ?>
            <table style="width:100%;">
                <thead>
                    <tr>
                        <td class="shopping-cart__tickets" colspan="2">Tickets</td>
                        <td class="shopping-cart__qty">Qty</td>
                        <td class="shopping-cart__price">Price</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orderTotal = 0; 
                    foreach($this->_note  as $key => $args ) { 
                        if( $args['quantity'] == 0 ) continue;
                        $showCharge = $args['quantity'] * $args['misha_custom_price'];
                        $orderTotal += $showCharge;
                        ?>
                        <tr style="border-bottom:1px solid black;">
                            <td style="width:2%">&nbsp;</td>
                            <td>
                                <?php if( $args['name'] != 'Donation' ): ?>
                                    <?php echo $args['showTitle']; ?><br />
                                    <?php 
                                        if( isset($args['showTitle']) && $args['showTitle'] != 'Seasons Ticket' && $args['showTitle'] != 'Promotional Discount')
                                        {
                                            echo $args['date']  . ' '  . date("g:i a", strtotime($args['time'])) . '<br />';
                                        } ?>
                                <?php endif; ?>
                                <?php echo $args['name'] . ($args['misha_custom_price'] < 0 ) ? '(&dollar;' . abs($args['misha_custom_price']) . ')' : ' &dollar;' . $args['misha_custom_price']; ?>
                            </td>
                            <td>
                                <?php echo $args['quantity']; ?>
                            </td>
                            <td>
                                <?php echo $showCharge < 0 ? '(&dollar;' . abs($showCharge) . ')' : '&dollar;' . $showCharge; ?>
                            </td>
                        </tr>
                <?php    } ?>
                <tr>
                    <td class="cart-total__label">Total:</td>
                    <td>&nbsp;</td>
                    <td class="cart-total">&dollar;<?php echo $orderTotal; ?></td>
                </tr>                        
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    }
}
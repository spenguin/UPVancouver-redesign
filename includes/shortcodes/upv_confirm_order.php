<?php
/**
 * Confirm Order where order is only season ticket subscription applied to a specific performance
 */

function upv_confirm_order()
{ ?>
    <form action="" method="post">
        <label>Name: <input type="text" name="name" /></label>
        <label>Phone number: <input type="phone" name="phone" /></label>
        <label>Email: <input type="email" name="email" /></label>
        <label>Notes:</label>
        <textarea name="notes" ></textarea>
        <input type="submit" class="button button--action" value="Confirm Order" />
    </form>
<?php
}
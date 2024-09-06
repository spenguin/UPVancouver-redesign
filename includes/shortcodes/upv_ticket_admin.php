<?php
/**
 * Add single purchases or upload purchases as a spreadsheet
 */

function upv_ticket_admin()
{
    ?>
    <h2>Single Performance Ticket Purchases</h2>
    <form action="/" method="post">
        <label for="show">Which show:&nbsp;<input type="text" name="show" placeholder="Name of show?" /></label>
        <label for="date">Which performance date:&nbsp;<input type="date" name="date" placeholder="Performance date" /></label>
        
        <input type="button" class="button" value="Submit" />
    </form>

    <?php
}


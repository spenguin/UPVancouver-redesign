<?php
/**
 * Season Tickets content
 */

?>
<h4>Ticket Packages</h4>
<p>A seasons ticket will cover a single performance of each of the following shows:</p>


<?php
    echo upv_show_season(['presentation'=>'list']);
    echo upv_season_tickets();
?>

<?php
/** Render performance dates and corresponding tickets for a specific show */
$showId         = $post->post_type == "show" ? $post->ID : -1; 
$performances   = getPerformanceDates( $post->ID ); 
$tickets        = getTickets($showId);
$string         = $showId < 0 ? "Season Tickets" : "Show Tickets";

// var_dump($tickets);
// var_dump($show_dates);
?>
    <p><?php echo $string; ?></p>
    <div id="TicketSales"></div>

    <script>
        var showId = '<?php echo $showId; ?>'; 
        var performances = <?php echo json_encode($performances); ?>;
        var tickets = <?php echo json_encode($tickets); ?>;
        // console.log('tickets', tickets);
    </script>
    <script type="text/javascript" src="<?php echo CORE_DIST; ?>ticketsales.js"></script>



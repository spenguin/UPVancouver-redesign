<?php
/** Render performance dates and corresponding tickets for a specific show */
$showId         = $post->post_type == "show" ? $post->ID : -1; 
$performances   = performanceFns::getPerformanceDates( $post->ID );
$tickets        = ticketFns::getTickets($showId);
$string         = $showId < 0 ? "Season Tickets" : "Show Tickets";
$isTicketSpecialAvailable   = $showId < 0 ? ticketFns::isTicketSpecialAvailable() : FALSE;

// pvd($tickets);
// pvd($performances);
?>
    <p><?php echo $string; ?></p>
    <div id="TicketSales"></div>

    <script>
        var showId          = '<?php echo $showId; ?>'; 
        var performances    = <?php echo json_encode($performances); ?>;
        var tickets         = <?php echo json_encode($tickets); ?>;
        var isTicketSpecialAvailable    = '<?php echo $isTicketSpecialAvailable; ?>';
        var currentURL      = '<?php echo site_url(); ?>';
        // console.log('currentURL', currentURL);
    </script>
    <script type="text/javascript" src="<?php echo CORE_DIST; ?>ticketsales.js?v=1770251037"></script>
<?php
/**
 * Show Content layout
 */

$directing_credits  = get_post_meta($post->ID, 'directing_credits', true);
$writing_credits    = get_post_meta($post->ID, 'writing_credits', true);
$end_date           = get_post_meta($post->ID, 'end_date', true); //var_dump($end_date);

?>
<div class="credits">
    <div class="credits__writing"><?php echo $writing_credits; ?></div>
    <div class="credits__directing"><?php echo $directing_credits; ?></div>
</div>
<?php if( $end_date >= date('Y-m-d') ) { ?>
    <a href="#tickets" class="button button--action">Buy Tickets</a>
<?php } else { ?>
    <p>This show is no longer available. Thank you for joining us!</p>
<?php } ?>
<?php the_content(); ?>
<div id="tickets" class="show-ticketing">
    <h4>Ticket Ordering</h4>
    <p>First select the date of show</p>
    <div class="select-performance__list-item">
        <div class="performance__select--wrapper">
            <div class="performance__select--radio">
                <input type="radio" id="{performance.date}" value="{performance.date}" name="selectedPerformance"/>
                <label for={performance.date}></label>
            </div>
            <div class="performance__select--datetime">
                14th April 2024 
            </div>               
        </div>
        <div class="performance__notes">
            Preview Performance
        </div>
    </div>
    <div class="ticket-list">
            <!-- {ticketData.map((ticket, index) => { -->
                <!-- return( -->
                    <div class="ticket-list__ticket" key={ticket.id}>
                        <div class="ticket-list__ticket--select">
                            <div class="ticket-select__name">
                                Adult
                            </div>
                            <div class="ticket-select__quantity">
                                <div class="ticket-select__quantity--block">
                                    <i class="fa-solid fa-minus"></i><input type="text" value="1" name="quantity" /><i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                            <div class="ticket-select__charge">
                                $15
                            </div>
                        </div>
                    </div>
                <!-- ) -->
            <!-- })} -->
            <!-- <TicketSalesTotal
                ticketData={ticketData}
                ticketSpecial={ticketSpecial}
            /> -->
        </div>    

    <!-- <div class="show-ticketing__dates">
        <ul>
            <li><label><input type="radio" name="show-ticketing__date" value="12-4-2024" class="show-ticketing__date">12th April</input></label>
            <li><label><input type="radio" name="show-ticketing__date" value="13-4-2024" class="show-ticketing__date">13th April</input></label>
            <li><label><input type="radio" name="show-ticketing__date" value="14-4-2024" class="show-ticketing__date">14th April</input></label>
            <li><label><input type="radio" name="show-ticketing__date" value="15-4-2024" class="show-ticketing__date">15th April</input></label>
        </ul>
    </div> -->
    <a href="" class="button button--special">Place Order</a>
    <div class="show-ticketing__tickets">

    </div>
</div>
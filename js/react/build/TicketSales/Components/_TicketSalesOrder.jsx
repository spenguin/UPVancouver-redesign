/** Ticket Sales Order component */
// Called from Ticket Sales

// import nodes
import React, { useState, useEffect } from "react";

const TicketSalesOrder = ({selectedPerformance, localTickets}) => {//console.log('selectedPerformance', selectedPerformance); //console.log('ticketData', ticketData);


    return (
        <div className="ticket-totals__order">
            <form method="post" action="/cart">
                {/* <input type="hidden" name="ticketData" value={tickets} /> */}
                <input type="hidden" name="ticketData" value={JSON.stringify(localTickets)} />
                <input type="hidden" name="selectedPerformance" value={selectedPerformance} />
                <input type="submit" className="button button--action" name="order" value="Place Order" />
            </form>
        </div>
    )
}

export default TicketSalesOrder;
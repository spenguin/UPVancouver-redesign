// Ticket Total component
// called from _TicketSalesTickets.jsx

// import nodes
import React, { useState } from "react";


const TicketSalesTotal = ({ localTickets, isTicketSpecialAvailable }) => {

const ticketCount = localTickets.reduce(function (prev, ticket) { return prev + ticket.quantity; }, 0);
const ticketCharge = localTickets.reduce(function (acc, ticket) { return acc + ticket.quantity * ticket.charge; }, 0);

return (
    <div className="ticket-totals">
        <div className="ticket-totals__text">
            {ticketCount} ordered totalling ${ticketCharge}
            {isTicketSpecialAvailable && ticketCount > 2 &&
                <span> less 50% discount (applied at Cart)</span>
            }
        </div>
    </div>
)


}

export default TicketSalesTotal;
// Tickets component
// called from index.js

// import nodes
import React, { useState } from "react";

// import components
import TicketTotal from "./_TicketTotal.jsx";

// import css
import "../css/tickets.css";


const Tickets = ({ tickets, ticketSpecial }) => { 

    // set State vars
    const [ticketData, setTicketData] = useState(tickets);

    // // set functions
    const adjustCount = (keyname, value) => { 
        var ticket = tickets[keyname];
        ticket.quantity = (ticket.quantity + value) < 0 ? 0 : ticket.quantity + value;

        setTicketData({
            ...ticketData,
            [keyname]: ticket
        });
    }

    return (
        <div className="ticket-list">
            {tickets.map((ticket, index) => {
                return(
                    <div className="ticket-list__ticket" key={ticket.id}>
                        <div className="ticket-list__ticket--select">
                            <div className="ticket-select__name">
                                {ticket.name}
                            </div>
                            <div className="ticket-select__quantity">
                                <div className="ticket-select__quantity--block">
                                    <i className="fa-solid fa-minus" onClick={() => adjustCount(index, -1)}></i><input type="text" value={ticket.quantity} name="quantity" /><i className="fa-solid fa-plus" onClick={() => adjustCount(index, 1)}></i>
                                </div>
                            </div>
                            <div className="ticket-select__charge">
                                ${ticket.charge}
                            </div>
                        </div>
                    </div>
                )
            })}
            <TicketTotal
                tickets={tickets}
                ticketSpecial={ticketSpecial}
            />
        </div>

    );
}

export default Tickets;

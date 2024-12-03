// Tickets component
// called from TicketSales.jsx

// import nodes
import React, { useState, useEffect } from "react";

// import components
import TicketSalesTotal from "./_TicketSalesTotal.jsx";


const TicketSalesTickets = ({ ticketData, isTicketSpecialAvailable, setTicketData, setLocalTickets }) => { 

    // set State vars
    // const [localTickets, setLocalTickets]   = useState(ticketData);

    // set vars
    var localTickets = ticketData;
    var studentStr  = "(Must have Student ID)";

    // set functions
    const adjustCount = (keyname, value) => {
        var ticket      = ticketData[keyname];
        ticket.quantity = (ticket.quantity + value) < 0 ? 0 : ticket.quantity + value;
        
        setLocalTickets({
            ...localTickets,
            [keyname]:ticket
        })
        // setTicketData(localTickets);
    }

    return (
        <div className="ticket-list">
            {ticketData.map((ticket, index) => {
                return(
                    <div className="ticket-list__ticket" key={ticket.id}>
                        <div className="ticket-list__ticket--select">
                            <div className="ticket-select__name">
                                {ticket.name}
                                {ticket.name == "Student" &&
                                    <div className="ticket--note">{studentStr}</div>
                                }
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
            <TicketSalesTotal
                localTickets            ={localTickets}
                isTicketSpecialAvailable={isTicketSpecialAvailable}
            />
        </div>

    )
}

export default TicketSalesTickets;

// Tickets Sales component
// called from index.js

// import nodes
import React, { useState, useEffect } from "react";

// import components
import TicketSalesPerformances from "./_TicketSalesPerformances.jsx";
import TicketSalesTickets from "./_TicketSalesTickets.jsx";
import TicketSalesOrder from "./_TicketSalesOrder.jsx";
// import Tickets from "../../Tickets/Components/Tickets.jsx";


// import css
import "../../TicketSales/css/ticketsales.css";


const TicketSales = ({showId, performances, tickets, isTicketSpecialAvailable}) => {

    // set State vars
    const [selectedPerformance, setSelectedPerformance] = useState('');
    const [ticketData, setTicketData]                   = useState(showId > 0 ? null : tickets); 
    const [localTickets, setLocalTickets]               = useState(ticketData);

    useEffect(()=>{//console.log('selectedPerformance', selectedPerformance );
        if(selectedPerformance.length) {
            var tmp = {};
            {performances[selectedPerformance].preview
                ? tmp = tickets.filter( ticket => ticket.name.indexOf('Preview') == 0 )
                : tmp = tickets.filter( ticket => ticket.name.indexOf('Preview') != 0 )
            }
            setTicketData(tmp)

        }
    },[selectedPerformance])

    return (
        <>
            {showId > 0 &&
                <TicketSalesPerformances
                    performances            = {performances}
                    setSelectedPerformance  = {setSelectedPerformance}
                    selectedPerformance     = {selectedPerformance}
                ></TicketSalesPerformances>
            }
            {ticketData &&
                <>
                    <h3>Please select your tickets</h3>
                    {!(performances instanceof Array) &&
                        <p>Note: You must already be a Season Subscriber to select a Season Subscriber Ticket.<br></br><a href="/seasons-tickets">Seasons Tickets</a></p>
                    }
                    <TicketSalesTickets
                        ticketData      = {ticketData}
                        isTicketSpecialAvailable   = {isTicketSpecialAvailable}
                        // setTicketData   = {setTicketData}
                        setLocalTickets = {setLocalTickets}
                    ></TicketSalesTickets>

                    <TicketSalesOrder
                        selectedPerformance = {selectedPerformance}
                        localTickets        = {localTickets}
                    >
                    </TicketSalesOrder>
                </>
            }            
        </>
    )
}

export default TicketSales;
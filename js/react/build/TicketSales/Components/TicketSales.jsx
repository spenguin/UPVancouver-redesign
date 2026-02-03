// Tickets Sales component
// called from index.js

// import nodes
import React, { useState, useEffect } from "react";

// import components
import TicketSalesPerformances from "./_TicketSalesPerformances.jsx";
import TicketSalesTickets from "./_TicketSalesTickets.jsx";
import TicketSalesOrder from "./_TicketSalesOrder.jsx";

// import css
import "../../TicketSales/css/ticketsales.css";


const TicketSales = ({showId, performances, tickets, isTicketSpecialAvailable, currentURL}) => {

    // set State vars
    const [selectedPerformance, setSelectedPerformance] = useState('');
    const [ticketData, setTicketData]                   = useState(showId > 0 ? null : tickets); 
    const [localTickets, setLocalTickets]               = useState(ticketData);

    var linkURL = currentURL + '/seasons-tickets'; console.log('link', linkURL);

    useEffect(()=>{
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
                        <p>Note: You must already be a Season Subscriber to select a Season Subscriber Ticket.<br></br><a href={linkURL}>Seasons Tickets</a></p>
                    }
                    <TicketSalesTickets
                        // tickets         ={performanceTickets}
                        ticketData      = {ticketData}
                        isTicketSpecialAvailable   = {isTicketSpecialAvailable}
                        setTicketData   = {setTicketData}
                        setLocalTickets = {setLocalTickets}
                    ></TicketSalesTickets>

                    <TicketSalesOrder
                        selectedPerformance = {selectedPerformance}
                        localTickets        = {localTickets}
                        currentURL          = {currentURL}
                    >
                    </TicketSalesOrder>
                </>
            }            
        </>
    )
}

export default TicketSales;
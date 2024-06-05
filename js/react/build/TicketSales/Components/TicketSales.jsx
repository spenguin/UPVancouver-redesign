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


const TicketSales = ({showId, performances, tickets}) => { 

    // set State vars
    const [selectedPerformance, setSelectedPerformance] = useState('');
    // const [performanceTickets, setPerformanceTickets]   = useState([]);
    const [ticketData, setTicketData]                   = useState(showId > 0 ? null : tickets); //console.log('ticketData', ticketData);
    const [localTickets, setLocalTickets]               = useState(ticketData);

    useEffect(()=>{
        if(selectedPerformance.length) {
            var tmp = {};
            {performances[selectedPerformance].preview
                ? tmp = tickets.filter( ticket => ticket.name.indexOf('Preview') == 0 )
                : tmp = tickets.filter( ticket => ticket.name.indexOf('Preview') != 0 )
            }
            // setPerformanceTickets(tmp);
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
                    <TicketSalesTickets
                        // tickets         ={performanceTickets}
                        ticketData      = {ticketData}
                        ticketSpecial   = {false}
                        setTicketData   = {setTicketData}
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
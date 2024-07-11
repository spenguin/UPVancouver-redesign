// Ticket Sales component
// created 23 August 2023

// import nodes
import React from "react";
import ReactDOM from "react-dom";

// import components
import TicketSales from "./Components/TicketSales.jsx";

ReactDOM.render(
    <TicketSales
        showId      = {showId}
        performances= {performances}
        tickets     = {tickets}
        isTicketSpecialAvailable    = {isTicketSpecialAvailable}
    />,
    document.getElementById('TicketSales')
);
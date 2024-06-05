// Ticket component
// created 02 June 2023

// import nodes
import React from "react";
import ReactDOM from "react-dom";

// import components
import Tickets from "./Components/Tickets.jsx";

ReactDOM.render(
    <Tickets
        tickets={tickets}
        ticketSpecial={ticketSpecial}
    />,
    document.getElementById('Tickets')
);
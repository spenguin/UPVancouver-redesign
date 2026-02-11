// Checkout component
// created 8 June 2024

// import nodes
import React from "react";
import ReactDOM from "react-dom";

// import components
import Checkout from "./Components/Checkout.jsx";

ReactDOM.render(
    <Checkout
        ticketsOrdered  = {ticketsOrdered}
    />,
    document.getElementById('Checkout')
);
// Show component
// created 31 May 2023

// import nodes
import React from "react";
import ReactDOM from "react-dom";

// import components
import Show from "./Components/Show.jsx"; 

ReactDOM.render( 
    <Show 
        show_dates = {show_dates}
    />,
    document.getElementById('Show')
);
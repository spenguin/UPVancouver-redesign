// Show component
// Called from index.js

// import nodes
import React from "react";

// import components
import Show_date from "./_Show_date.jsx";

const Show = ({show_dates}) => {//console.log( 'dates', show_dates );

    return (
        <ul className="show-dates__list">
            {Object.keys(show_dates).map( ( keyname ) => ( 
                <Show_date
                    show_date={show_dates[keyname]}
                />            
            ))}
        </ul>
    );
}

export default Show;
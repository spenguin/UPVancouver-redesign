// Ticket Sales Performances
// Called from TicketSales.jsx

// import nodes
import React, { useState, useEffect } from "react";

// import components
import TicketSalesPerformance from "./_TicketSalesPerformance.jsx";


const TicketSalesPerformances = ({performances, setSelectedPerformance, selectedPerformance}) => { //console.log('performances', performances);


    // set vars

    // set functions
    const revealPerformances = () => {
        setSelectedPerformance('');
    }

    return (
        <div className="select-performance">
            <h3>Please select the performance</h3>
            {selectedPerformance &&
                <button className="select-performance__button button button--action" onClick={revealPerformances}>Change the date</button>
            }
            <div className="select-performance__list">
                {Object.keys(performances).map((p, i)=>{ //console.log(performances[p].date);
                    return (
                    <TicketSalesPerformance
                        performance         = {performances[p]}
                        selectedPerformance = {selectedPerformance}
                        setSelectedPerformance={setSelectedPerformance}
                    ></TicketSalesPerformance>
                    )
                })}

            </div>

        </div>
    )
}

export default TicketSalesPerformances;
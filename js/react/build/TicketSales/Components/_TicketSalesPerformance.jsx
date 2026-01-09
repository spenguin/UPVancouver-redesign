// Ticket Sales Performance (singular)
// called from _TicketSalesPerformances.jsx

// import nodes
import React, { useState, useEffect } from "react";

const TicketSalesPerformance = ({performance, selectedPerformance, setSelectedPerformance}) => { //console.log('performance', performance.preview );

    // set vars
    // const options           = { month: "short", day: "numeric", year: "numeric" };
    // const performanceClass  = performance.preview ? " show-date--preview" : "";
    const previewMsg        = performance.preview ? "Preview performance" : "";
    const talkbackMsg       = performance.talkback ? "Talkback performance" : ""; 
    const sold_out          = performance.sold_out ? "Sold Out" : ""; 
    const itemClass         = selectedPerformance ? (selectedPerformance == performance.id ? "active" : "unselected") : ""; 
    
    // set functions
    const onSelectPerformance = (e) => { 
        setSelectedPerformance(e.target.value); 
    }

    return (
        <div className={`select-performance__list-item ${itemClass}`} key={performance.id}>
            <div className="performance__select--wrapper">
                <div className="performance__select--radio">
                    {!sold_out.length &&
                        <>
                            <input type="radio" id={performance.id} value={performance.date_time} name="selectedPerformance" onChange={(e)=>onSelectPerformance(e)} />
                            <label for={performance.id}></label>
                        </>
                    }
                </div>
                <div className="performance__select--datetime">
                    {performance.performance_date}<br />
                    {performance.performance_time}
                </div>               
            </div>
            <div className="performance__notes">
                    {sold_out.length > 0 && <span>{sold_out}</span>}
                    {!sold_out.length &&
                        <span>{previewMsg}{talkbackMsg}</span>
                    }
            </div>
        </div>
    )

}

export default TicketSalesPerformance;
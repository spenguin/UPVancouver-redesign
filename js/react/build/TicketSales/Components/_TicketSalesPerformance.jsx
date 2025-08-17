// Ticket Sales Performance (singular)
// called from _TicketSalesPerformances.jsx

// import nodes
import React, { useState, useEffect } from "react";

const TicketSalesPerformance = ({performance, selectedPerformance, setSelectedPerformance}) => { //console.log('performance', performance );

    // set vars
    const dateFormat        = new Date(performance.date * 1000);
    dateFormat.setDate(dateFormat.getDate() + 1); // Kludge to get correct date - I hope.
    const options           = { month: "short", day: "numeric", year: "numeric" };
    const performanceClass  = performance.preview ? " show-date--preview" : "";
    const previewMsg        = performance.preview ? "Preview performance" : "";
    const talkbackMsg       = performance.talkback ? "Talkback performance" : ""; 
    const sold_out          = performance.sold_out ? "Sold Out" : ""; 
    const itemClass         = selectedPerformance ? (selectedPerformance == performance.id ? "active" : "unselected") : ""; 
    const performanceTime   = formatTime(performance.performance_time);
    
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
                            <input type="radio" id={performance.id} value={performance.id} name="selectedPerformance" onChange={(e)=>onSelectPerformance(e)} />
                            <label for={performance.id}></label>
                        </>
                    }
                </div>
                <div className="performance__select--datetime">
                    {new Intl.DateTimeFormat('en-ca', options).format(dateFormat)}<br />
                    {performanceTime} 
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

function formatTime(timeString) {
    const [hourString, minute] = timeString.split(":");
    const hour = +hourString % 24;
    return (hour % 12 || 12) + ":" + minute + (hour < 12 ? "AM" : "PM");
}
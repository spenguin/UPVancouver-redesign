/** Show Date component */
/* Called from Shows.jsx */

// import nodes
import React from "react";


const Show_date = ({ show_date, onSelectPerformance }) => {
    const dateFormat = new Date(show_date.date * 1000);
    dateFormat.setDate(dateFormat.getDate() + 1); // Kludge to get correct date - I hope.
    const options = { month: "short", day: "numeric", year: "numeric" };

    // set variables
    const performanceClass = show_date.preview ? " show-date--preview" : "";
    const previewMsg = show_date.preview ? "Preview performance" : "";
    const talkbackMsg = show_date.talkback ? "Talkback performance" : "";

    return (
        <li className={`show-date ${performanceClass}`} key={show_date.date}>
            <div className="show-date__select">
                <input type="radio" value={show_date.date} name="selectedPerformance" onChange={onSelectPerformance} />
            </div>
            <div className="show-date__date">
                {new Intl.DateTimeFormat('en-ca', options).format(dateFormat)}<br />
                {show_date.performance_time}
            </div>
            <div className="show-date__notes">
                <p>{previewMsg}<br />{talkbackMsg}</p>
            </div>
        </li>
    )
}

export default Show_date;
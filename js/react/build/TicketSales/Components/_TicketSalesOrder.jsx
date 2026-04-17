/** Ticket Sales Order component */
// Called from Ticket Sales

// import nodes
import React, { useState } from "react";

const TicketSalesOrder = ({selectedPerformance, localTickets, currentURL, showId}) => {

    // const [formData, setFormData] = useState({ ticketData: JSON.stringify(localTickets), selectedPerformance: selectedPerformance, showId: showId });
    const [formData, setFormData] = useState({  selectedPerformance: selectedPerformance, showId: showId });

    // const [status, setStatus] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault(); // Prevents the page from reloading
        // setStatus('Sending...'); 
// console.log( 'formData', formData );
        try {
            const response = await fetch( currentURL + '/wp-json/my-app/v1/amend-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // 'X-WP-Nonce': window.wpApiSettings.nonce // Add if you need authentication
                },
                body: JSON.stringify(formData),
            });

            const result = await response.json();
        
            if (response.ok) {
                console.log( 'Wordpress received the data' );
                // setStatus('Success! WordPress received the data.');
                // setFormData({ name: '', message: '' }); // Clear form
            } else {
                console.log('Error');
                // setStatus(`Error: ${result.message}`);
            }
        } catch (error) {
            console.log('Failed to connect to Wordpress');
            // setStatus('Failed to connect to WordPress.');
        }
    };

    return (
        <div className="ticket-totals__order">
            <form onSubmit={handleSubmit} >
                {/* <input type="hidden" name="ticketData" value={formData.ticketData} onChange={(e) => setFormData({...formData, ticketData: e.target.value})}  /> */}
                <input type="hidden" name="selectedPerformance" value={selectedPerformance} />
                <input type="hidden" name="showId" value={showId} />
                <input type="submit" className="button button--action" name="order" value="Place Order" />
            </form>
        </div>
    );
};

export default TicketSalesOrder;
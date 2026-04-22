/** Ticket Sales Order component */
// Called from Ticket Sales

// import nodes
import React, { useState, useEffect } from "react";

const TicketSalesOrder = ({selectedPerformance, localTickets, currentURL, showId}) => {

    const [formData, setFormData] = useState({ localTickets: '', selectedPerformanceTitle: selectedPerformance, showId: showId });

    useEffect(() => {
        setFormData({...formData, localTickets: JSON.stringify(localTickets)})
    }, [localTickets]);

    const [message, setMessage] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault(); 
console.log( 'formData', formData );
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
                console.log('data', result.data );
                if( result.status == "error")
                {
                    setMessage(result.message);
                } else {
                    window.location.href = currentURL + '/cart';
                }
            } else {
                setMessage('Err: 005');
                console.log('Error');
            }
        } catch (error) {
            setMessage('Err: 004');
            console.log('Failed to connect to Wordpress');
        }
    };

    return (
        <div className="ticket-totals__order">
            <form onSubmit={handleSubmit} >
                <input type="hidden" name="ticketData" value={JSON.stringify(localTickets)}  />
                <input type="hidden" name="selectedPerformance" value={selectedPerformance} />
                <input type="hidden" name="showId" value={showId} />
                <input type="submit" className="button button--action" name="order" value="Place Order" />
                {message.length > 0 &&
                    <div className="error-message">There was an error with the order. Please try again. If the error persists, please contact Patron Services to complete your order.<span className="error-message__code">({message})</span></div>
                }
            </form>
        </div>
    );
};

export default TicketSalesOrder;
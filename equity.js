const apiBaseUrl = 'https://cloud.iexapis.com/stable';
const apiKey = 'YOUR_API_KEY';

async function fetchEquityData(symbol) {
    const response = await fetch(`${apiBaseUrl}/stock/${symbol}/quote?token=${apiKey}`);
    const data = await response.json();
    return data;
}

// Example function to fetch trends for an equity
async function fetchEquityTrends(symbol) {
    const data = await fetchEquityData(symbol);
    // Process data as needed
    return data;
}

// Initialize the data and chart
async function init() {
    const symbol = 'AAPL'; // Example equity symbol
    const data = await fetchEquityTrends(symbol);
    // Update your UI with data
}

document.addEventListener('DOMContentLoaded', init);

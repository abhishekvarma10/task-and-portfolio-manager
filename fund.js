const apiBaseUrl = 'https://www.alphavantage.co/query';
const apiKey = 'YOUR_API_KEY';

async function fetchFundData(symbol) {
    const response = await fetch(`${apiBaseUrl}?function=OVERVIEW&symbol=${symbol}&apikey=${apiKey}`);
    const data = await response.json();
    return data;
}

// Example function to fetch trends for a fund
async function fetchFundTrends(symbol) {
    const data = await fetchFundData(symbol);
    // Process data as needed
    return data;
}

// Initialize the data and chart
async function init() {
    const symbol = 'MFSTX'; // Example mutual fund symbol
    const data = await fetchFundTrends(symbol);
    // Update your UI with data
}

document.addEventListener('DOMContentLoaded', init);

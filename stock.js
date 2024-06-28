const apiBaseUrl = 'https://www.alphavantage.co/query';
const apiKey = 'YOUR_API_KEY';

async function fetchStockData(symbol) {
    const response = await fetch(`${apiBaseUrl}?function=TIME_SERIES_DAILY&symbol=${symbol}&apikey=${apiKey}`);
    const data = await response.json();
    return data['Time Series (Daily)'];
}

// Example function to fetch trends for a stock
async function fetchStockTrends(symbol) {
    const data = await fetchStockData(symbol);
    const dates = Object.keys(data).slice(0, 30).reverse();
    const prices = dates.map(date => ({
        x: new Date(date),
        y: parseFloat(data[date]['4. close'])
    }));
    return prices;
}

// Initialize the data and chart
async function init() {
    const symbol = 'IBM'; // Example stock symbol
    const trends = await fetchStockTrends(symbol);

    const ctx = document.getElementById('trend-chart').getContext('2d');
    window.trendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: trends.map(point => point.x.toLocaleDateString()),
            datasets: [{
                label: `${symbol} Price Trends`,
                data: trends.map(point => point.y),
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day'
                    }
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', init);

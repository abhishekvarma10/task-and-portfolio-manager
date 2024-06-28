const apiBaseUrl = 'https://www.quandl.com/api/v3/datasets';
const apiKey = 'YOUR_API_KEY';

async function fetchCommodityData(dataset) {
    const response = await fetch(`${apiBaseUrl}/${dataset}.json?api_key=${apiKey}`);
    const data = await response.json();
    return data.dataset.data;
}

// Example function to fetch trends for a commodity
async function fetchCommodityTrends(dataset) {
    const data = await fetchCommodityData(dataset);
    const dates = data.map(item => item[0]);
    const prices = data.map(item => ({
        x: new Date(item[0]),
        y: parseFloat(item[1])
    }));
    return prices;
}

// Initialize the data and chart
async function init() {
    const dataset = 'CHRIS/CME_CL1'; // Example commodity dataset
    const trends = await fetchCommodityTrends(dataset);

    const ctx = document.getElementById('trend-chart').getContext('2d');
    window.trendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: trends.map(point => point.x.toLocaleDateString()),
            datasets: [{
                label: `Commodity Price Trends`,
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

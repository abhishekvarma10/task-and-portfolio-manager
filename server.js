const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const axios = require('axios');
const app = express();
const server = http.createServer(app);
const io = socketIo(server);

io.on('connection', (socket) => {
    console.log('New client connected');
    socket.on('disconnect', () => {
        console.log('Client disconnected');
    });
});

setInterval(async () => {
    try {
        const response = await axios.get('http://localhost/your_existing_website/fetch_data.php');
        const investmentData = response.data;
        io.emit('investmentData', investmentData);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}, 5000); // Fetch data every 5 seconds

server.listen(3000, () => console.log('Server running on port 3000'));

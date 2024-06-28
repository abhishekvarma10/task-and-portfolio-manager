// serverlessFunction.js (or chatbot.py in Flask)

const openai = require('openai'); // Assuming you use Node.js for serverless function

// Set your OpenAI API key (this should be stored securely, not hard-coded here in production)
const apiKey = 'put your api key here';

// Initialize OpenAI API client
const openaiClient = new openai.OpenAI(apiKey);

// Handle POST requests from the front-end
exports.handler = async function(event) {
    const requestBody = JSON.parse(event.body);
    const userMessage = requestBody.message;

    try {
        // Send user message to OpenAI API
        const response = await openaiClient.completions.create({
            engine: 'text-davinci-003',
            prompt: userMessage,
            max_tokens: 150
        });

        const botResponse = response.data.choices[0].text.trim();
        
        // Return bot's response
        return {
            statusCode: 200,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ response: botResponse })
        };
    } catch (error) {
        console.error('Error:', error);
        return {
            statusCode: 500,
            body: JSON.stringify({ error: 'Internal Server Error' })
        };
    }
};

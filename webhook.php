<?php
// Ensure request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit();
}

// Retrieve the raw POST data
$payload = file_get_contents('php://input');

// Example: Log the incoming payload to a file
file_put_contents('plaid_webhook.log', $payload . PHP_EOL, FILE_APPEND);

// Optionally, process the payload as needed
$payloadArray = json_decode($payload, true);

// Example: Send acknowledgment response
echo json_encode(['status' => 'ok']);
?>

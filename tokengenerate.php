<?php
require_once 'vendor/autoload.php'; // Adjust path as needed

use Plaid\PlaidClient;
use Plaid\PlaidException;
use Plaid\PlaidRequestException;
use Plaid\PlaidServers;

// Replace with your Plaid API credentials and desired environment
$PLAID_CLIENT_ID = '';
$PLAID_SECRET = '';
$PLAID_ENV = PlaidServers::SANDBOX; // or PlaidServers::DEVELOPMENT or PlaidServers::PRODUCTION

// Initialize Plaid client
$client = new PlaidClient($PLAID_CLIENT_ID, $PLAID_SECRET, $PLAID_PUBLIC_KEY, $PLAID_ENV);

try {
    // Create Link token request parameters
    $params = [
        'user' => [
            'client_user_id' => 'unique_user_id', // Replace with your unique user identifier
        ],
        'client_name' => 'Your App Name',
        'products' => ['transactions'],
        'country_codes' => ['US'], // Replace with your desired country code
        'language' => 'en', // Replace with your desired language
    ];

    // Create the Link token
    $response = $client->linkTokenCreate($params);
    $linkToken = $response['link_token'];

    // Return the Link token as JSON
    header('Content-Type: application/json');
    echo json_encode(['link_token' => $linkToken]);
} catch (PlaidRequestException $e) {
    // Plaid request failed due to invalid parameters or other issues
    http_response_code(400); // Bad request
    echo json_encode(['error' => $e->getMessage()]);
} catch (PlaidException $e) {
    // General Plaid SDK error
    http_response_code(500); // Internal server error
    echo json_encode(['error' => $e->getMessage()]);
}
?>

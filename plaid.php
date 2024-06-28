<?php
require_once '../autoload.php'; // Adjust path as needed

use Plaid\PlaidClient;

// Plaid credentials
$PLAID_CLIENT_ID = '';
$PLAID_SECRET = '';
$PLAID_ENV = 'sandbox'; // Use 'development' or 'production' for real environments

$client = new PlaidClient($PLAID_CLIENT_ID, $PLAID_SECRET, $PLAID_ENV);

// MySQL credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['public_token'])) {
    $publicToken = $_POST['public_token'];

    try {
        $response = $client->exchangePublicToken($publicToken);
        $accessToken = $response['access_token'];
        $_SESSION['access_token'] = $accessToken; // Save the access token in session

        echo json_encode(['message' => 'Access token received']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['access_token'])) {
    try {
        $accessToken = $_SESSION['access_token'];
        $response = $client->getTransactions($accessToken, '2021-01-01', '2022-01-01');
        
        foreach ($response['transactions'] as $transaction) {
            $stmt = $conn->prepare("INSERT INTO transactions (account_id, name, amount, date, category) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdss", $transaction['account_id'], $transaction['name'], $transaction['amount'], $transaction['date'], implode(', ', $transaction['category']));
            $stmt->execute();
        }

        echo json_encode(['transactions' => $response['transactions']]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

$conn->close();
?>

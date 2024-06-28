<?php
require_once '../autoload.php'; // Adjust path as needed

use Plaid\PlaidClient;

// Plaid credentials (replace with your actual Plaid credentials)
$PLAID_CLIENT_ID = '<YOUR_PLAID_CLIENT_ID>';
$PLAID_SECRET = '<YOUR_PLAID_SECRET>';
$PLAID_ENV = 'sandbox'; // Use 'development' or 'production' for real environments

// MySQL credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database"; // Replace with your actual database name

// Initialize Plaid client
$client = new PlaidClient($PLAID_CLIENT_ID, $PLAID_SECRET, $PLAID_ENV);

// Sample function to generate fake transactions
function generateFakeTransactions($numTransactions = 10)
{
    $transactions = [];
    $categories = ['Food', 'Shopping', 'Utilities', 'Entertainment', 'Transportation'];
    
    for ($i = 0; $i < $numTransactions; $i++) {
        $transaction = [
            'account_id' => 'fake_account_id',
            'name' => 'Fake Merchant ' . ($i + 1),
            'amount' => rand(10, 1000),
            'date' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days')),
            'category' => [$categories[array_rand($categories)]],
        ];
        $transactions[] = $transaction;
    }
    
    return $transactions;
}

// Function to insert transactions into database
function insertTransactionsIntoDatabase($transactions)
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    foreach ($transactions as $transaction) {
        $account_id = $transaction['account_id'];
        $name = $transaction['name'];
        $amount = $transaction['amount'];
        $date = $transaction['date'];
        $category = implode(', ', $transaction['category']);

        $stmt = $conn->prepare("INSERT INTO transactions (account_id, name, amount, date, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $account_id, $name, $amount, $date, $category);
        $stmt->execute();
    }

    $conn->close();
}

// Generate fake transactions
$fakeTransactions = generateFakeTransactions();

// Insert fake transactions into database
insertTransactionsIntoDatabase($fakeTransactions);

// Output fake transactions as JSON response (optional for testing purposes)
echo json_encode(['transactions' => $fakeTransactions]);
?>

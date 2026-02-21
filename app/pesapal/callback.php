<?php
$trackingId = $_GET['pesapal_transaction_tracking_id'] ?? '';
$reference  = $_GET['pesapal_merchant_reference'] ?? '';

if (!$trackingId || !$reference) {
    http_response_code(400);
    echo "Missing parameters.";
    exit;
}


$config = require __DIR__ . '/config.php';
require __DIR__ . '/PesapalClient.php';
require __DIR__ . '/db.php';

$client = new PesapalClient($config);
$token  = $client->getToken();

if (!$token) {
    http_response_code(502);
    echo "Failed to authenticate with Pesapal.";
    exit;
}

$url = $config['base_url'][$config['environment']] . "/api/Transactions/GetTransactionStatus?orderTrackingId=" . urlencode($trackingId);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer {$token}",
    "Accept: application/json"
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    file_put_contents(__DIR__ . '/callback.log', "cURL error: " . curl_error($ch) . "\n", FILE_APPEND);
    http_response_code(502);
    echo "Error contacting Pesapal.";
    exit;
}
curl_close($ch);

$status = json_decode($response, true);
file_put_contents(__DIR__ . '/callback.log', date('c') . " Response: " . print_r($status, true) . "\n", FILE_APPEND);

$db = new DB($config['db']);
$db->upsertPaymentStatus($reference, $trackingId, $status['status'], $status);

echo "Callback processed. Status: " . htmlspecialchars($status['status']);
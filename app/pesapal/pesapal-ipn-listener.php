<?php
include_once('oauth.php');

$consumer_key    = '6JdMvJRXbriqxfNmysvgcD0rGCjefFN3';
$consumer_secret = 'jy3XgaKw9nK0Pwr2+nllq0/KTu4=';

$statusrequestAPI= 'https://www.pesapal.com/API/QueryPaymentStatus';

$pesapal_notification_type       = $_GET['pesapal_notification_type'] ?? '';
$pesapal_transaction_tracking_id = $_GET['pesapal_transaction_tracking_id'] ?? '';
$pesapal_merchant_reference      = $_GET['pesapal_merchant_reference'] ?? '';

if ($pesapal_notification_type == 'CHANGE' && $pesapal_transaction_tracking_id) {
    $token = $params = NULL;
    $consumer = new OAuthConsumer($consumer_key, $consumer_secret);
    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

    $request_status = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $statusrequestAPI, $params);
    $request_status->set_parameter('pesapal_merchant_reference', $pesapal_merchant_reference);
    $request_status->set_parameter('pesapal_transaction_tracking_id', $pesapal_transaction_tracking_id);
    $request_status->sign_request($signature_method, $consumer, $token);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_status);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    $elements = preg_split("/=/", substr($response, strpos($response, "=")));
    $status = $elements[1] ?? 'PENDING';

    // Update DB
    require __DIR__ . '/db.php';
    $db = new DB(require __DIR__ . '/config.php')['db'];
    $db->upsertPaymentStatus($pesapal_merchant_reference, $pesapal_transaction_tracking_id, $status, []);

    // Respond back to Pesapal
    $resp = "pesapal_notification_type=$pesapal_notification_type&pesapal_transaction_tracking_id=$pesapal_transaction_tracking_id&pesapal_merchant_reference=$pesapal_merchant_reference";
    echo $resp;
    exit;
}
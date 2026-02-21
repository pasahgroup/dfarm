<?php
include_once('oauth.php');

// Sandbox vs Live

$config = require __DIR__ . '/config.php';
$consumer_key = $config['pesapal']['consumer_key'];
$consumer_secret = $config['pesapal']['consumer_secret'];


// $consumer_key    = '6JdMvJRXbriqxfNmysvgcD0rGCjefFN3';
// $consumer_secret = 'jy3XgaKw9nK0Pwr2+nllq0/KTu4=';
$iframelink      = 'https://www.pesapal.com/API/PostPesapalDirectOrderV4'; // use demo.pesapal.com for sandbox

// Order details
$currency   = "TZS";
$amount     = 1000;
$desc       = "Test Payment";
$type       = "MERCHANT";
$reference  = uniqid("ORDER_");
$first_name = "John";
$last_name  = "Doe";
$email      = "john@example.com";
$phonenumber= "0712345678";

// Callback URL (must be HTTPS in production)
$protocol   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$base_url   = $protocol . $_SERVER['HTTP_HOST'] . "/";
// $callback_url = $base_url . "callback.php";

$callback_url = $base_url . "pesapal/callback";
// $callback_url = route('pesapal.callback');


// Build XML
$post_xml = '<?xml version="1.0" encoding="utf-8"?>';
$post_xml .= '<PesapalDirectOrderInfo ';
$post_xml .= 'Amount="'.$amount.'" ';
$post_xml .= 'Description="'.$desc.'" ';
$post_xml .= 'Type="'.$type.'" ';
$post_xml .= 'Reference="'.$reference.'" ';
$post_xml .= 'FirstName="'.$first_name.'" ';
$post_xml .= 'LastName="'.$last_name.'" ';
$post_xml .= 'Email="'.$email.'" ';
$post_xml .= 'PhoneNumber="'.$phonenumber.'" ';
$post_xml .= 'xmlns="http://www.pesapal.com" />';
$post_xml = htmlentities($post_xml);

// OAuth signing
$token = $params = NULL;
$consumer = new OAuthConsumer($consumer_key, $consumer_secret);
$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

$iframe_src = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $iframelink, $params);
$iframe_src->set_parameter("oauth_callback", $callback_url);
$iframe_src->set_parameter("pesapal_request_data", $post_xml);
$iframe_src->sign_request($signature_method, $consumer, $token);
?>
<iframe src="<?php echo $iframe_src; ?>" width="100%" height="800px" scrolling="no" frameBorder="0">
    <p>Browser unable to load iFrame</p>
</iframe>
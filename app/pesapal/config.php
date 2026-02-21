<?php
return [
    // Environment: set to 'live' for production
    'environment' => 'live',

    // Pesapal base URLs
    'base_url' => [
        'sandbox' => 'https://demo.pesapal.com',
        'live'    => 'https://www.pesapal.com'
    ],

    // Pesapal credentials (replace with your live merchant keys)
    'pesapal' => [
        'consumer_key'    => '6JdMvJRXbriqxfNmysvgcD0rGCjefFN3',
        'consumer_secret' => 'jy3XgaKw9nK0Pwr2+nllq0/KTu4='
    ],

    // Database connection (production DB settings)
    'db' => [
        'host'     => 'localhost',          // or your DB server hostname
        'dbname'   => 'dfarmdbb',  // production database name
        'user'     => 'root',  // production DB user
        'password' => ''   // production DB password
    ],

    // Callback & IPN URLs (must be HTTPS and publicly accessible)
    'urls' => [
        'callback' => 'https://localhost/callback.php',
        'ipn'      => 'https://localhost/pesapal-ipn-listener.php'
    ]
];
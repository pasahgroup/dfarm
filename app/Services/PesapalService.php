
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PesapalService
{
    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;

    public function __construct()
    {
        $this->baseUrl       = config('pesapal.base_url');
        $this->consumerKey   = config('pesapal.consumer_key');
        $this->consumerSecret= config('pesapal.consumer_secret');
    }

    public function queryStatus(string $trackingId, string $merchantRef): string
    {
        $url = "{$this->baseUrl}/api/querypaymentstatus";
        $response = Http::asForm()->post($url, [
            'pesapal_transaction_tracking_id' => $trackingId,
            'merchant_reference'              => $merchantRef,
            'consumer_key'                    => $this->consumerKey,
            'consumer_secret'                 => $this->consumerSecret,
        ]);

        if ($response->failed()) {
            Log::error('Pesapal query failed', ['body' => $response->body()]);
            return 'pending';
        }

        return strtolower($response->json()['status'] ?? 'pending');
    }
}
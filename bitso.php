<?php
require 'vendor/autoload.php'; // Include Guzzle library

// Replace with your Bitso API key and secret
$apiKey = 'YOUR_API_KEY';
$apiSecret = 'YOUR_API_SECRET';

$symbol = 'btc_usd'; // BTC/USD trading pair

$client = new GuzzleHttp\Client();

try {
    $response = $client->request('GET', 'https://api.bitso.com/v3/ticker/', [
        'query' => ['book' => $symbol],
    ]);

    $data = json_decode($response->getBody(), true);

    if (isset($data['payload']['last'])) {
        $bitcoinPrice = $data['payload']['last'];
        echo "Bitso Bitcoin Price ({$symbol}): $bitcoinPrice USD";
    } else {
        echo "Unable to fetch Bitcoin price.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

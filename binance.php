<?php
require 'vendor/autoload.php'; // Include Guzzle library

// Replace with your Binance API key and secret
$apiKey = 'YOUR_API_KEY';
$apiSecret = 'YOUR_API_SECRET';

$symbol = 'BTCUSDT'; // BTC/USDT trading pair

$client = new GuzzleHttp\Client();

try {
    $response = $client->request('GET', 'https://api.binance.com/api/v3/ticker/price', [
        'query' => ['symbol' => $symbol],
    ]);

    $data = json_decode($response->getBody(), true);

    if (isset($data['price'])) {
        $bitcoinPrice = $data['price'];
        echo "Bitcoin Price ({$symbol}): $bitcoinPrice USDT";
    } else {
        echo "Unable to fetch Bitcoin price.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

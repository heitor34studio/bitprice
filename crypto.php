<?php
require 'vendor/autoload.php';
//CORRETORA BITSO
use ccxt\bitso;

$bitso = new bitso;

try {
    $ticker = $bitso->fetch_ticker('BTC/USDT');
    $btcPrice = $ticker['last'];
    echo "Preço do Bitcoin-BITSO: $btcPrice USDT";
} catch (\ccxt\NetworkError $e) {
    echo 'Erro de rede: ' . $e->getMessage();
} catch (\ccxt\ExchangeError $e) {
    echo 'Erro na exchange: ' . $e->getMessage();
}
echo '<br>---------<br>';
//FIM CORRETORA BITSO

/*

//CORRETORA KRAKEN
use ccxt\kraken;

$kraken = new kraken;

try {
    $ticker = $kraken->fetch_ticker('BTC/USDT');
    $btcPrice = $ticker['last'];
    echo "Preço do Bitcoin-KRAKEN: $btcPrice USDT";
} catch (\ccxt\NetworkError $e) {
    echo 'Erro de rede: ' . $e->getMessage();
} catch (\ccxt\ExchangeError $e) {
    echo 'Erro na exchange: ' . $e->getMessage();
}
echo '<br>---------<br>';
//FIM CORRETORA KRAKEN



//CORRETORA BINANCE
use ccxt\binance;

$binance = new binance;

try {
    $ticker = $binance->fetch_ticker('BTC/USDT');
    $btcPrice = $ticker['last'];
    echo "Preço do Bitcoin-BINANCE: $btcPrice USDT";
} catch (\ccxt\NetworkError $e) {
    echo 'Erro de rede: ' . $e->getMessage();
} catch (\ccxt\ExchangeError $e) {
    echo 'Erro na exchange: ' . $e->getMessage();
}
echo '<br>---------<br>';
//FIM CORRETORA BINANCE



//CORRETORA NOVADAX
use ccxt\novadax;

$novadax = new novadax;

try {
    $ticker = $novadax->fetch_ticker('BTC/USDT');
    $btcPrice = $ticker['last'];
    echo "Preço do Bitcoin-NOVADAX: $btcPrice USDT";
} catch (\ccxt\NetworkError $e) {
    echo 'Erro de rede: ' . $e->getMessage();
} catch (\ccxt\ExchangeError $e) {
    echo 'Erro na exchange: ' . $e->getMessage();
}
echo '<br>---------<br>';
//FIM CORRETORA NOVADAX



//CORRETORA MERCADO
use ccxt\mercado;

$mercado = new mercado;

try {
    $ticker = $mercado->fetch_ticker('BTC/BRL');
    $btcPrice = $ticker['last'];
    echo "Preço do Bitcoin-MERCADO: $btcPrice REAIS";
} catch (\ccxt\NetworkError $e) {
    echo 'Erro de rede: ' . $e->getMessage();
} catch (\ccxt\ExchangeError $e) {
    echo 'Erro na exchange: ' . $e->getMessage();
}
echo '<br>---------<br>';
//FIM CORRETORA MERCADO=


//CORRETORA OKX
use ccxt\okex5;

$okex5 = new okex5;

try {
    $ticker = $okex5->fetch_ticker('BTC/USDT');
    $btcPrice = $ticker['last'];
    echo "Preço do Bitcoin-OKX: $btcPrice USDT";
} catch (\ccxt\NetworkError $e) {
    echo 'Erro de rede: ' . $e->getMessage();
} catch (\ccxt\ExchangeError $e) {
    echo 'Erro na exchange: ' . $e->getMessage();
}
echo '<br>---------<br>';
//FIM CORRETORA OKX
*/
?>
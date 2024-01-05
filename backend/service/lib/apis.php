<?php
require 'vendor/autoload.php'; // Include Guzzle library
$precosCriptomoedas = array(
    "BTC"=>'<div class="col-sm-12 mb-4 mb-xl-0"><h4 class="font-weight-bold text-dark">Bitcoin!<img src="images/btc-logo.png" class="icon-big"/></h4></div>',"ETH"=>'<div class="col-sm-12 mb-4 mb-xl-0"><h4 class="font-weight-bold text-dark">Ethereum!<img src="images/eth-logo.png" class="icon-big"/></h4></div>',"YFI"=>'<div class="col-sm-12 mb-4 mb-xl-0"><h4 class="font-weight-bold text-dark">Year.Finance!<img src="images/yfi-logo.png" class="icon-big"/></h4></div>',"XRP"=>'<div class="col-sm-12 mb-4 mb-xl-0"><h4 class="font-weight-bold text-dark">XRP!XRP<img src="images/xrp-logo.png" class="icon-big"/></h4></div>',"SOL"=>'<div class="col-sm-12 mb-4 mb-xl-0"><h4 class="font-weight-bold text-dark">Solana!<img src="images/solana-logo.svg" class="icon-big"/></h4></div>',"existErr"=>false,"ERROR"=>'<div class="col-sm-12 mb-4 mb-xl-0"><h4 class="font-weight-bold text-dark">ERRO!</h4></div>');
function Guzzle($api){
    $client = new GuzzleHttp\Client();
    try {
        $response = $client->request('GET', $api);
        $data = json_decode($response->getBody(), true);
    } catch (Exception $e) {
        $data =  "Error: " . $e->getMessage();
    }
    return $data;
}
function binance($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.binance.com/api/v3/ticker/price';
    $res = Guzzle($minhaApi);
    $moedasCorretas = array("BTC" => "BTCBRL","ETH" => "ETHBRL","YFI" => "YFIUSDT","XRP" => "XRPBRL","SOL" => "SOLBRL");
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora BINANCE:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 3);
            $indice = array_search($moedasCorretas[$moeda], array_column($res, 'symbol'));
            $preco = number_format($res[$indice]['price'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">BINANCE</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">R$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
    
}
function bitso($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.bitso.com/v3/ticker/';
    $res = Guzzle($minhaApi);
    $moedasCorretas = array("BTC" => "btc_brl","ETH" => "eth_brl","XRP" => "xrp_brl","SOL" => "sol_brl");
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora BITSO:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 3);
            $indice = array_search($moedasCorretas[$moeda], array_column($res['payload'],'book'));
            $preco = number_format($res['payload'][$indice]['last'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">BITSO</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">R$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function novadax($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.novadax.com/v1/market/tickers';
    $moedasCorretas = array("BTC" => "BTC_BRL","ETH" => "ETH_BRL","XRP" => "XRP_BRL","YFI"=>"YFI_BRL","SOL" => "SOL_BRL");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora NOVADAX:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 4);
            $indice = array_search($moedasCorretas[$moeda], array_column($res['data'],'symbol'));
            $preco = number_format($res['data'][$indice]['lastPrice'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">NOVADAX</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">R$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function mercadobitcoin($moedasRequisitadas){
    global $precosCriptomoedas;
    //!!!!!!!!!!!!!!!!!!
    $moedasCorretas = array("BTC"=>"BTC-BRL","ETH" => "ETH-BRL","XRP" => "XRP-BRL","YFI" => "YFI-BRL","SOL" => "SOL-BRL");
    //!!!!!!!!!!!!!!!!!!
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $minhaApi = "https://api.mercadobitcoin.net/api/v4/tickers?symbols=$moedasCorretas[$moeda]"; //SÍMBOLO REQUISITADO
            $res = Guzzle($minhaApi);
            if(!is_array($res)){
                $precosCriptomoedas["existErr"] = true;
                $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora MERCADOBITCOIN:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
                return;
            }
            $cedula = substr($moedasCorretas[$moeda], 4);
            $preco = number_format($res[0]['last'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">MERCADOBITCOIN</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">R$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function foxbit($moedasRequisitadas){
    global $precosCriptomoedas;
    //SÍMBOLO REQUISITADO
    //!!!!!!!!!!!!!!!!!!
    $moedasCorretas = array("BTC"=>"btc","ETH" => "eth","XRP" => "xrp","YFI" => "yfi","SOL" => "sol");
    //!!!!!!!!!!!!!!!!!!
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $minhaApi = "https://api.foxbit.com.br/rest/v3/markets/quotes?side=buy&base_currency=$moedasCorretas[$moeda]&quote_currency=brl&amount=1";//SÍMBOLO REQUISITADO
            $res = Guzzle($minhaApi);
            if(!is_array($res)){
                $precosCriptomoedas["existErr"] = true;
                $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora FOXBIT:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
                return;
            }
            $preco = number_format($res['price'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">FOXBIT</h4><p>'.$moeda.' em Real-BRL:</p><h4 class="text-dark font-weight-bold mb-2">R$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function okx($moedasRequisitadas){
    global $precosCriptomoedas;
    //SÍMBOLO REQUISITADO
    //!!!!!!!!!!!!!!!!!!
    $moedasCorretas = array("BTC"=>"BTC-USDT","ETH" => "ETH-USDT","XRP" => "XRP-USDT","YFI" => "YFI-USDT","SOL" => "SOL-USDT");
    //!!!!!!!!!!!!!!!!!!

    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $minhaApi = "https://www.okx.com/api/v5/market/index-tickers?instId=$moedasCorretas[$moeda]";//SÍMBOLO REQUISITADO
            $res = Guzzle($minhaApi);
            if(!is_array($res)){
                $precosCriptomoedas["existErr"] = true;
                $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora OKX:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
                return;
            }
            $cedula = substr($moedasCorretas[$moeda], 4);
            $preco = number_format($res['data'][0]['idxPx'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">OKX</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function ripiotrade($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.ripiotrade.co/v4/public/tickers';
    $moedasCorretas = array("BTC"=>"BTC_BRL","ETH" => "ETH_BRL","XRP" => "XRP_BRL","SOL" => "SOL_BRL");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora RIPIOTRADE:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 4);
            $indice = array_search($moedasCorretas[$moeda], array_column($res['data'],'symbol'));
            $preco = number_format($res['data'][$indice]['last'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">RIPIOTRADE</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">R$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function bitpreco($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.bitpreco.com/all-brl/ticker';
    $moedasCorretas = array("BTC"=>"BTC-BRL","ETH" => "ETH-BRL","XRP" => "XRP-BRL","SOL" => "SOL-BRL");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora BITPRECO:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 4);
            $preco = number_format($res[$moedasCorretas[$moeda]]['last'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">BITPRECO</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">R$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function coinex($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.coinex.com/v1/market/ticker/all';
    $moedasCorretas = array("BTC"=>"BTCUSDT","ETH" => "ETHUSDT","YFI"=>"YFIUSDT","XRP" => "XRPUSDT","SOL" => "SOLUSDT");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora COINEX:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 3);
            $preco = number_format($res['data']['ticker'][$moedasCorretas[$moeda]]['last'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">COINEX</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function kucoin($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.kucoin.com/api/v1/market/allTickers';
    $moedasCorretas = array("BTC"=>"BTC-BRL","ETH" => "ETH-BRL","YFI"=>"YFI-USDT","XRP" => "XRP-USDT","SOL" => "SOL-USDT");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora KUCOIN:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cifrao = '$';
            if($moeda == 'BTC'){
                $cifrao = 'R$';
            }
            $cedula = substr($moedasCorretas[$moeda], 4);
            $indice = array_search($moedasCorretas[$moeda], array_column($res['data']['ticker'],'symbol'));
            $preco = number_format($res['data']['ticker'][$indice]['last'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">KUCOIN</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">'.$cifrao.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function bitnuvem($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://bitnuvem.com/api/BTC/ticker';
    //SÓ ACEITA BITCOIN
    $moedasCorretas = array("BTC"=>"BRL");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora BITNUVEM:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = $moedasCorretas[$moeda];
            $preco = number_format($res['ticker']['last'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">BITNUVEM</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">R$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function mexc($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.mexc.com/api/v3/ticker/price';
    $moedasCorretas = array("BTC"=>"BTCUSDT","ETH" => "ETHUSDT","YFI"=>"YFIUSDT","XRP" => "XRPUSDT","SOL" => "SOLUSDT");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora MEXC:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 3);
            $indice = array_search($moedasCorretas[$moeda], array_column($res,'symbol'));
            $preco = number_format($res[$indice]['price'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">MEXC</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function bybit($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.bybit.com/v5/market/tickers?category=inverse';
    $moedasCorretas = array("BTC"=>"BTCUSD","ETH" => "ETHUSD","XRP" => "XRPUSD");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora BYTBIT:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 3);
            $indice = array_search($moedasCorretas[$moeda], array_column($res['result']['list'],'symbol'));
            $preco = number_format($res['result']['list'][$indice]['lastPrice'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">BYBIT</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function bitstamp($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://www.bitstamp.net/api/v2/ticker/';
    $moedasCorretas = array("BTC"=>"BTC/USD","ETH" => "ETH/USD","XRP" => "XRP/USD","YFI"=>"YFI/USD","SOL"=>"SOL/USD");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora BITSTAMP:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 4);
            $indice = array_search($moedasCorretas[$moeda], array_column($res,'pair'));
            $preco = number_format($res[$indice]['last'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">BITSTAMP</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function bitfinex($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api-pub.bitfinex.com/v2/tickers?symbols=ALL';
    $moedasCorretas = array("BTC"=>"tBTCUSD","ETH" => "tETHUSD","XRP" => "tXRPUSD","YFI"=>"tYFIUSD","SOL"=>"tSOLUSD");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora BITFINEX:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 4);
            $indice = array_search($moedasCorretas[$moeda], array_column($res,0));
            $preco = number_format($res[$indice][7], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">BITFINEX</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function cryptocom($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.crypto.com/exchange/v1/public/get-tickers';
    $moedasCorretas = array("BTC"=>"BTC_USDT","ETH" => "ETH_USDT","XRP" => "XRP_USDT","YFI"=>"YFI_USDT","SOL"=>"SOL_USDT");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora CRYPTOCOM:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 4);
            $indice = array_search($moedasCorretas[$moeda], array_column($res['result']['data'],'i'));
            $preco = number_format($res['result']['data'][$indice]['a'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">CRYPTOCOM</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function huobi($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.huobi.pro/market/tickers';
    $moedasCorretas = array("BTC"=>"btcbrl","ETH" => "ethusdt","XRP" => "xrpusdt","YFI"=>"yfiusdt","SOL"=>"solusdt");
    $res = Guzzle($minhaApi);
    if(!is_array($res)){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora HUOBI:</h4><p>Erro: '.$res.':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 3);
            $indice = array_search($moedasCorretas[$moeda], array_column($res['data'],'symbol'));
            $preco = number_format($res['data'][$indice]['open'], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">HUOBI</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
function kraken($moedasRequisitadas){
    global $precosCriptomoedas;
    $minhaApi = 'https://api.kraken.com/0/public/Ticker';
    $moedasCorretas = array("BTC"=>"TBTCUSD","ETH" => "ETHUSDT","XRP" => "XRPUSDT","YFI"=>"YFIUSD","SOL"=>"SOLUSDT");
    $res = Guzzle($minhaApi);
    if(!empty($res['error'])){
        $precosCriptomoedas["existErr"] = true;
        $precosCriptomoedas["ERROR"] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">Erro com a corretora KRAKEN:</h4><p>Erro: '.$res['error'][0].':</p></div></div></div></div></div>';
        return;
    }
    foreach ($moedasRequisitadas as $moeda) {
        // Verificar se a moeda existe no array $moedasCorretas
        if (isset($moedasCorretas[$moeda])) {
            $cedula = substr($moedasCorretas[$moeda], 3);
            if($moeda == "BTC"){
                $cedula = substr($moedasCorretas[$moeda], 4);
            }
            $preco = number_format($res['result'][$moedasCorretas[$moeda]]['c'][0], 2, '.', '');
            $precosCriptomoedas[$moeda] .= '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card"><div class="row flex-grow"><div class="col-sm-12 grid-margin stretch-card"><div class="card"><div class="card-body"><h4 class="card-title">KRAKEN</h4><p>'.$moeda.' em '.$cedula.':</p><h4 class="text-dark font-weight-bold mb-2">$'.$preco.'</h4></div></div></div></div></div>';
        } else {
            continue;
        }
    }
}
?>
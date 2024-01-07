<?php
require '../service/BuscaApiService.php';

class BuscaApiController{
    const MOEDAS = array("BTC","YFI","ETH","XRP","SOL");
    const CORRETORAS = array("binance","bitso","novadax","mercadobitcoin","foxbit","okx","ripiotrade","bitpreco","coinex","kucoin","bitnuvem","mexc","bybit","bitstamp","bitfinex","cryptocom","huobi","kraken");
    public static function handle(){
        if(!isset($_POST['moedas']) || !isset($_POST['corretoras'])){
            echo "Moeda ou corretora nulo";
            die();
        }
        if (!is_array($_POST['moedas']) || !is_array($_POST['corretoras'])) {
            die();
        }
        foreach($_POST['moedas'] as $moeda){
            if(in_array($moeda,self::MOEDAS)){
                continue;
            }else{
                die();
            }
        }
        foreach($_POST['corretoras'] as $corretora){
            if(in_array($corretora,self::CORRETORAS)){
                continue;
            }else{
                die();
            }
        }
        $moedas = $_POST['moedas'];
        $corretoras = $_POST['corretoras'];
        if(count($moedas) >= 3 && count($corretoras) >= 6 ){
            die();
        }elseif(count($moedas) == 2 && count($corretoras) >= 11 ){
            die();
        }
        return BuscaApiService::execute($moedas,$corretoras);
    }
}

$html = BuscaApiController::handle();
$ids = array("BTC"=>'bitcoin',"ETH"=>'ethereum',"XRP"=>'xrp',"SOL"=>'solana',"YFI"=>'year');
foreach($_POST['moedas'] as $moeda){
    echo "<script>$('#".$ids[$moeda]."').html('".$html[$moeda]."');</script>";
}
if($html["existErr"] === true){
    echo "<script>$('#error').html('".json_encode($html["ERROR"], JSON_HEX_QUOT | JSON_HEX_TAG)."');</script>";
}else{
    echo "<script>$('#error').html('');</script>";
}
?>
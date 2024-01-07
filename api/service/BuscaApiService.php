<?php 
require 'lib/apis.php';
class BuscaApiService{
    public static function execute($moedas, $corretoras){
        global $precosCriptomoedas;
        foreach ($corretoras as $corretora) {
            if (function_exists($corretora)) {
                call_user_func($corretora,$moedas);
            }
        }
        return $precosCriptomoedas;
    }
}
?>
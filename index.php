<?php

require_once __DIR__ . '/inc/all.php';

$fetcher = new \App\Weather\Fake\FakeWeatherFetcher();
$weather = $fetcher->getWeatherForCity('Budapest');


render(__DIR__ . '/views/index.view.php', [
    'weather' => $weather
]);

//API ersatz
//$URL = 'https://downloads.codingcoursestv.eu/052%20-%20php/wetter.json';

$fp = fsockopen("ssl://downloads.codingcoursestv.eu", 443, $errno, $errstr, 30);

if(!$fp){
    echo "$errstr ($errno)<br>\n";
}else{
    $out = "GET /052%20-%20php/wetter.json HTTP/1.1\r\n";
    $out .= "Host: downloads.codingcoursestv.eu\r\n";
    $out .= "Connection: Close\r\n\r\n";
    fwrite($fp, $out);
    while (!feof($fp)){
        echo fgets($fp, 128);
    }
    fclose($fp);
}
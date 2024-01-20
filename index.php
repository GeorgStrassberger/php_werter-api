<?php

require_once __DIR__ . '/inc/all.php';

$fetcher = new \App\Weather\Remote\RemoteWeatherFetcher();
$weather = $fetcher->getWeatherForCity('Budapest');


render(__DIR__ . '/views/index.view.php', [
    'weather' => $weather
]);



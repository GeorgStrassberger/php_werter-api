<?php

namespace App\Weather\Fake;

use App\Weather\WeatherInfo;
use App\Weather\WeatherContract;

// Dummy um das weiterentwickeln nicht zu blockiern.
// Backend team erstellt diesen part.
class FakeWeatherFetcher implements  WeatherContract
{
    public function getWeatherForCity(string $cityName): ?WeatherInfo
    {
        return new WeatherInfo(21, false);
    }

}

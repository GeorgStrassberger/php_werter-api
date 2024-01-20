<?php

namespace App\Weather\Remote;

use App\Weather\WeatherContract;
use App\Weather\WeatherInfo;

class RemoteWeatherFetcher implements WeatherContract
{
    public function getWeatherForCity(string $cityName): ?WeatherInfo
    {
        $fp = fsockopen("ssl://downloads.codingcoursestv.eu", 443, $errno, $errstr, 30);

        if(!$fp){
            echo "$errstr ($errno)<br>\n";
            return null;
        }
        else
        {
            $out = "GET /052%20-%20php/wetter.json HTTP/1.1\r\n";
            $out .= "Host: downloads.codingcoursestv.eu\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);

            $responseArray = [];
            while (!feof($fp)){
                $responseArray[] = fgets($fp, 128);
            }
            fclose($fp);

            $response = implode('',$responseArray);

            $responseFirstSplit = explode("\r\n", $response, 2);

            if ($responseFirstSplit[0] === 'HTTP/1.1 200 OK'){

                // In [0] liegen die gesamten Header, in [1] der eigentliche Inhalt der
                // Antwort vom Server
                $responseSecondSplit = explode("\r\n\r\n", $responseFirstSplit[1],2);
                $actualResponseContent = trim($responseSecondSplit[1]);

                $decodedResponse = json_decode($actualResponseContent, true);
                if (!empty($decodedResponse)){
                    return new WeatherInfo($decodedResponse['temperature'], $decodedResponse['status'] === 'raining');
                    var_dump($decodedResponse);
                }

            }

        }
        return null;
    }
}



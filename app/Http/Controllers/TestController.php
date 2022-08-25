<?php

namespace App\Http\Controllers;

use App\Models\FavouritePlace;
use App\Models\WeatherDataLog;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index() {

       // $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather'
       // . '?id=763829&appid=7aef87c2b6d81812c53c536b5a1d715c');

        /*
        dd(
        $response->getStatusCode(),
        $response->getHeaderLine('content-type'),
        json_decode($response->getBody())
        );
        */

        $client = new Client();
        $favouritePlacesIds = FavouritePlace::all()->pluck('id')->toArray();
        foreach ($favouritePlacesIds as $id) {
            $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather'
                . '?id='. $id . '&appid=7aef87c2b6d81812c53c536b5a1d715c&units=metric');
            $data = json_decode($response->getBody());


            $log = WeatherDataLog::create([
                'temperature' => (int) number_format(round($data->main->temp)),
                'humidity' => $data->main->humidity,
                'favourite_place_id' => $data->id,
            ]);
             //dd($data, $data->id, (int) number_format(round($data->main->temp),0), $data->main->humidity, $log);
        }



    }
}

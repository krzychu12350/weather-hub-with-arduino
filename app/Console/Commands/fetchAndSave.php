<?php

namespace App\Console\Commands;

use App\Models\FavouritePlace;
use App\Models\WeatherDataLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;

class fetchAndSave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:thirty-minutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will fetch data from OpenWeatherMap API
        for specific places and save temperature and humidity into database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $favouritePlacesIds = FavouritePlace::all()->pluck('id')->toArray();
        try {
            foreach ($favouritePlacesIds as $id) {
                $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather'
                    . '?id='. $id . '&appid=7aef87c2b6d81812c53c536b5a1d715c&units=metric');
                $data = json_decode($response->getBody());
                WeatherDataLog::create([
                    'temperature' => (int) number_format(round($data->main->temp)),
                    'humidity' => $data->main->humidity,
                    'favourite_place_id' => $data->id,
                ]);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            echo $response->getBody()->getContents();
        }
        return 0;
    }
}

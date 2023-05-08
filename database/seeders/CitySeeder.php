<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::truncate();

        $json = File::get(database_path('cities.list.json'));
        $cities = json_decode($json);

        foreach ($cities as $key => $city) {
            City::create([
                'id' => $city->id,
                'name' => $city->name,
                'state' => $city->state,
                'country' => $city->country,
                'coord_lon' => $city->coord->lon,
                'coord_lat' => $city->coord->lon,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\FavouritePlace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavouritePlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        "id": 759734,
        "name": "Rzeszów",
        "state": "",
        "country": "PL",

                "id": 756135,
        "name": "Warsaw",
        "state": "",
        "country": "PL",

            "id": 2950159,
        "name": "Berlin",
        "state": "",
        "country": "DE",
        */
        $favouritePlaces = [
            [
                'id' => 759734,
                'name' => 'Rzeszów',
                'state' => '',
                'country' => 'PL',
            ],
            [
                'id' => 756135,
                'name' => 'Warsaw',
                'state' => '',
                'country' => 'PL',
            ],
            [
                'id' => 2950159,
                'name' => 'Berlin',
                'state' => '',
                'country' => 'DE',
            ]
        ];

        foreach ($favouritePlaces as $favouritePlace) {
            FavouritePlace::create($favouritePlace);
        }
    }
}

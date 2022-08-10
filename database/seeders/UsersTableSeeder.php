<?php

namespace Database\Seeders;

use App\Models\FavouritePlace;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Tom Cruise',
                'email' => 't.cruise@gmail.com',
                'password' => bcrypt('tcruise12?3'),
                //'password_confirmation' => 'tcruise12?3',
            ],
            [
                'name' => 'Adam Lambert',
                'email' => 'a.lambert@gmail.com',
                'password' => bcrypt('alambert12?3'),
                //'password_confirmation' => 'alambert12?3',
            ],
        ];

        foreach ($users as $user) {
            $u = User::create($user);
            //$favouritesPlaces = FavouritePlace::find([759734, 756135, 2950159]);
            //$u->favouritePlaces()->attach($favouritesPlaces);
        }
    }
}

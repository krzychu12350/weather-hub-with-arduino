<?php

namespace Database\Seeders;

use App\Models\User;
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
            ],
            [
                'name' => 'Adam Lambert',
                'email' => 'a.lambert@gmail.com',
                'password' => bcrypt('alambert12?3'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

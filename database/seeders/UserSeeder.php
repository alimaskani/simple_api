<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Faker\Factory;
use Faker\Guesser\Name;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $faker = Faker::create('App\Article');

        $users = [
            ['name' => $faker->firstName,
                'family' => $faker->lastName,
                'address' => $faker->address(),
                'username' => $faker->unique()->userName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'image' => $faker->image,
                'phone' => $faker->e164PhoneNumber(),
                'permission_id' => 1
            ],
            ['name' => $faker->firstName,
                'family' => $faker->lastName,
                'address' => $faker->address(),
                'username' => $faker->unique()->userName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'image' => $faker->image,
                'phone' => $faker->e164PhoneNumber(),
                'permission_id' => 2
            ],
            ['name' => $faker->firstName,
                'family' => $faker->lastName,
                'address' => $faker->address(),
                'username' => $faker->unique()->userName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'image' => $faker->image,
                'phone' => $faker->phoneNumber(),
                'permission_id' => 3
            ],
        ];

        User::query()->insert($users);

    }
}

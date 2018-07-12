<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Access;

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
                'username' => 'TheAnarchoX',
                'password' => Hash::make('runescape2012K'),
                'first_name' => 'Jim',
                'adverb' => 'de Vries',
                'sur_name' => 'de Vries',
                'email' => 'jimdvries@gmail.com',
                'is_active' => '1',
                'is_admin' => '4',
                'notice' => 'OG Admin'
            ],
            [
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'first_name' => 'admin',
                'adverb' => 'admin',
                'sur_name' => 'admin',
                'email' => 'jimdvries@gmai;l.com',
                'is_active' => '1',
                'is_admin' => '4',
                'notice' => 'Admin'
            ]
        ];
        foreach ($users as $u) {
            print_r("Creating: {$u['username']}\n");
            $user = User::create($u);

            foreach (range(1, Access::all()->count()) as $index) {
                $user->access()->attach($index);
            }
            foreach (range(1, \App\Models\Group::all()->count()) as $index) {
                $user->groups()->attach($index);
            }
        }

        $count = 10;
        foreach (range(3, $count) as $index) {
            print_r( "Seeding {$index} of  {$count}\r");
            $user = User::create([
                'username' => "user{$index}",
                'password' => Hash::make("user{$index}"),
                'first_name' => "User",
                'adverb' => "{$index}",
                'sur_name' => "{$index}",
                'email' => "User{$index}@starfish.nl",
                'is_active' => "1",
                'is_admin' => rand(1,4),
                'notice' => "Test user {$index}"
            ]);
           $user->attachDefaults();
        }
        echo "\n";
    }
}

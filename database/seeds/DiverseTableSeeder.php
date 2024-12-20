<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Diverse;

/**
 * Class DiverseTableSeeder
 */
class DiverseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_Us');
        $count = 20;
        foreach (range(1, $count) as $index) {
            print_r( "Seeding {$index} of {$count}\r");
            Diverse::create([
                'name' => $faker->word,
                'type' => $faker->mimeType,
                'target' => $faker->image('public\diverses', 256, 256),
            ]);
        }
        foreach (range(1, $count) as $index) {
            print_r( "Attaching  {$index} of {$count} to specialist\r");
            DB::table('specialists_diverses')->insert([
                'specialist_id' => rand(1, $count),
                'diverse_id' => $faker->unique()->numberBetween(1, $count)
            ]);
        }
        echo "\n";
    }
}

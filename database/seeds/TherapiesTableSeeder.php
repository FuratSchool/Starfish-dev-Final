<?php
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Therapy;

/**
 * Class TherapiesTableSeeder
 */
class TherapiesTableSeeder extends Seeder {
    public function run() {
        $faker = Faker::create('en_Us');
        $count = 20;
        foreach (range(1, $count) as $index) {
            print_r( "Seeding {$index} of  {$count}\r");
            Therapy::create([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'short_description' => $faker->sentence,
                'therapy_image' => $faker->image('public\images\avatars\therapies', 256, 256, 'business')
            ]);
        }
        echo "\n";
    }
}

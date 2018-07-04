<?php
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Complaint;

/**
 * Class ComplaintsTableSeeder
 */
class ComplaintsTableSeeder extends Seeder {
    public function run() {
        $faker = Faker::create('en_Us');
        $count = 100;
        foreach (range(1, $count) as $index) {
            print_r( "Seeding {$index} of {$count}\r");
            Complaint::create([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'short_description' => $faker->sentence,
                'complaint_image' => $faker->image('public\images\avatars\complaints', 256, 256, 'nature')
            ]);
        }
        echo "\n";

    }
}

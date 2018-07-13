<?php
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Image;

/**
 * Class ImagesTableSeeder
 */
class ImagesTableSeeder extends Seeder {
    public function run() {
        $faker = Faker::create('en_Us');
        $count = 20;
        foreach (range(1, $count) as $index) {
            print_r( "Seeding {$index} of {$count}\r");
            Image::create([
                'path' => $faker->image('public\images\avatars\specialists\images', 256, 256, 'nature'),
                'caption' => $faker->sentence
            ]);
        }
        echo "\n";
        foreach(range(1, $count) as $index)
        {
            print_r( "Attaching {$index} of {$count} to specialists\r");
            DB::table('specialists_images')->insert([
                'specialist_id' =>  $index,
                'image_id' => $index
            ]);
            DB::table('complaints_images')->insert([
                'complaint_id' => $index,
                'image_id' => $index
            ]);
        }
        echo "\n";
    }
}

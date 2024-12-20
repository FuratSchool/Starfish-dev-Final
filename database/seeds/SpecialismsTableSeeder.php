<?php
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Specialism;

/**
 * Class SpecialismsTableSeeder
 */
class SpecialismsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('en_Us');
        $count = 20;
        foreach (range(0, $count) as $index) {
            print_r( "Seeding {$index} of {$count}\r");
            Specialism::create([
                'name' => $faker->unique()->jobTitle,
                'description' => $faker->sentence,
                'short_description' => $faker->sentence
            ]);
        }
        foreach (range(1, $count) as $index) {
            print_r( "Attaching  {$index} of {$count} to specialisms\r");

            $prio_value = [1, 2, 3, 4, 5];
            $spec_value = range(1, $count);
            shuffle($spec_value);
            shuffle($prio_value);
            for ($x = 0; $x <= 4; ++$x) {
                DB::table('specialists_specialisms')->insert([
                    'specialist_id' => $index,
                    'specialism_id' => $spec_value[$x],
                    'prio' => $prio_value[$x]
                ]);
            }
        }
        echo "\n";
    }
}




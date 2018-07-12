<?php
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Specialist;
use App\Models\Dummy;

/**
 * Class SpecialistsTableSeeder
 */
class SpecialistsTableSeeder extends Seeder {

    /**
     * @throws \App\Models\TypeError
     */
    public function run() {
        $faker = Faker::create('en_US');
        $count = 20;
        foreach (range(1, $count) as $index) {
            print_r( "Seeding {$index} of {$count}\r");
            Specialist::create([
                'name' => $faker->name(),
                'adverb' => $faker->name(),
                'sur_name' => $faker->name(),
                'gender' => $faker->randomElement(['male', 'female']),
                'occupation' => $faker->jobTitle,
                'map_lat' => $faker->latitude(),
                'map_lng' => $faker->longitude(),
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'postal_code' => $faker->postcode,
                'region' => $faker->state,
                'country' => $faker->country,
                'is_anonymous' => Dummy::generateBiasedBetween(),
                'url_name' => str_slug($faker->company.$index, "-"),
                'profile_image'=> $faker->image('public\images\avatars\specialists', 256, 256, 'people'),
                'company' => $faker->company,
                'story' => Dummy::dummyHTML(1, ['']),
                'mission' => $faker->text('150'),
                'phone_number' => $faker->phoneNumber,
                'mobile_phone' => $faker->phoneNumber,
                'url'=> $faker->domainName,
                'email' => $faker->safeEmail
            ]);
        }
        echo "\n";
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Dummy;
use App\Models\Group;

/**
 * Class GroupsTableSeeder
 */
class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 20;
        $defaultGroups = ['Alle Gebruikers', 'Moderatoren', 'Administratoren', 'Webmasters'];
        foreach ($defaultGroups as $defaultGroup) {
            Group::create(['name' => $defaultGroup]);
        }
        foreach (range(1, $count) as $index) {
            print_r( "Seeding {$index} of {$count}\r");
            $group = Group::create([
                'name' => "Groep {$index}",
            ]);
        }
        echo "\n";
    }

    /**
     * @param $min
     * @param $max
     * @param $quantity
     * @return array
     */
    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}

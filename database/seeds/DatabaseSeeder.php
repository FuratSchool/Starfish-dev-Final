<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        echo "\nStarting seeders\n";
        Auth::attempt(['username' => 'admin', 'password' => 'admin']);
        $start = microtime(true);
        $this->call(AccessesTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TherapiesTableSeeder::class);
        $this->call(ComplaintsTableSeeder::class);
        $this->call(SpecialistsTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(SpecialismsTableSeeder::class);
        $this->call(DiverseTableSeeder::class);
        echo "\nSeeders finished in  ".round((microtime(true) - $start), 2)." seconds";
    }
}

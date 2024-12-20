<?php

use Illuminate\Database\Seeder;
use  App\Models\Access;
/**
 * Class AccessesTableSeeder
 */
class AccessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lines = explode( "\n", file_get_contents( __DIR__."/accessList.csv") );
        $headers = str_getcsv( array_shift( $lines ) );
        $data = array();
        foreach ( $lines as $line ) {
            $row = array();
            foreach ( str_getcsv( $line ) as $key => $field )
                $row[ $headers[ $key ] ] = $field;
            $row = array_filter( $row );
            $data[] = $row;
            }
        $count = count($data);
        $x = 1;
        foreach ($data as $access) {
            print_r( "Seeding {$x} of {$count}\r");
            Access::create($access);
            $x++;
        }
        echo "\n";
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Specialist;
use App\Models\Task;
use App\Models\Group;
/**
 * Class FillCoordinates
 *
 * @package App\Console\Commands
 */
class FillCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geocoder:fill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill empty specialist coordinates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tasks = [];
        $specialists = Specialist::where("country",  "LIKE","TODO")->get();
        $count = count($specialists);
        $this->info("Found: {$count} specialists");
        foreach ($specialists as $specialist) {
            $lat = $lng = $region = $country = "";
            $address = urlencode($specialist->address);
            $zip = urlencode($specialist->postal_code);
            $city = urlencode($specialist->city);
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address},{$zip},{$city}&language=nl&sensor=false&key=AIzaSyDTMGtzFUNyyV3YICxx0aGCag3eryHThEc";
            $geocoded = json_decode(file_get_contents($url), true);
            switch ($geocoded['status']) {
                case "OK":
                    $region = $geocoded['results'][0]['address_components'][4]['long_name'];
                    $country = $geocoded['results'][0]['address_components'][5]['long_name'];
                    foreach ($geocoded['results'][0]['geometry']['location'] as $key => $value) {
                        $$key = $value;
                    }
                    break;
                case "ZERO_RESULTS":
                    $region = "Niet beschikbaar";
                    $country = "Niet beschikbaar";
                    $lat = $lng = "0";
                    array_push($tasks, [
                        "title"  =>"Adres controler voor: {$specialist->name}",
                        "description" =>"Het systeem kon de volgende gegevens niet vinden: <i>Provincie, Land, Coordinaten</i>, dit betekent dat het adres een foutief adres is, graag controleren",
                        "type" => "edit",
                        "status" => 0,
                        "assigner_id" => "1",
                    ]);
                    break;
                case "OVER_QUERY_LIMIT":
                    $region = "Niet beschikbaar";
                    $country = "Niet beschikbaar";
                    $lat = $lng = 0.1;
                    break;
            }
            $specialist->map_lat = $lat;
            $specialist->map_lng = $lng;
            $specialist->region = $region;
            $specialist->country = $country;
            $specialist->save();

            foreach ($tasks as $task) {
                $task = Task::create([
                    "title" => $task["title"],
                    "description" => $task["description"],
                    "type" => $task['type'],
                    "assigner_id" => "1",
                    "status" => 0,
                ]);
                $group = Group::find(1);
                $group->tasks()->attach($task);
            }
        }
    }
}

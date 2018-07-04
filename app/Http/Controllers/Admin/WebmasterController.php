<?php

namespace App\Http\Controllers\Admin;

use App\Models\Complaint;
use App\Models\Dummy;
use App\Models\Specialism;
use App\Models\Specialist;
use App\Models\Task;
use App\Models\Therapy;
use DebugBar\Bridge\MonologCollector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel as Excel;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Monolog\Logger;

/**
 * Class WebmasterController
 * @package App\Http\Controllers\Admin
 */
class WebmasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        return view("admin.webmaster.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     *
     * @return bool
     */

    public function batchUpload(Request $request) {
        $logger = new Logger("TestLog");
        $logger->addAlert("Testing 1, 2 ,3");
        $useMock = false;
        $mockURL = true;
        $date = Carbon::now();
        $dt = $date->format("Y_m_d_H_i_s");
        $fileName = "BATCH_FILE_{$dt}.xlsx";
        $path = $request->file('batch_file')->storeAs('\batchUploads\\' , $fileName);
        if($path) {
                $files = [];
                Excel::load("storage\app\batchUploads\\$fileName", function ($reader) use ($dt, &$files) {
                    $reader->each(function ($sheet) use ($dt, &$files) {
                        $filename = "BATCH_" . $sheet->getTitle() . "_" . $dt;
                        $fullFilename = "{$filename}.csv";
                        $valid = $fullFilename == "BATCH_Uitleg_{$dt}.csv" ? null : $fullFilename;
                        if ($valid) {
                            switch ($sheet->getTitle()) {
                                case "Specialisten":
                                    $filetype = "specialists";
                                    break;
                                case "Werkgebieden":
                                    $filetype = "specialisms";
                                    break;
                                case "Therapieen":
                                    $filetype = "therapies";
                                    break;
                                case "Klachten":
                                    $filetype = "complaints";
                                    break;
                                default:
                                    $filetype = null;
                            }
                            $filedata = [
                                "filename" => $fullFilename,
                                'filetype' => $filetype
                            ];
                            array_push($files, $filedata);

                            Excel::create($filename, function ($excel) use ($sheet) {
                                $excel->sheet($sheet->getTitle(), function ($newSheet) use ($sheet) {
                                    $newSheet->fromArray($sheet->toArray(), null);
                                });
                            })->store("csv", "..\storage\app\batchUploads");
                        }
                    });
                });


                foreach ($files as $file) {
                    $fname = $file['filename'];
                    $lines = explode("\n", file_get_contents("..\storage\app\batchUploads\\$fname"));
                    if (count($lines) > 2) {
                        array_pop($lines);
                        $headers = str_getcsv(array_shift($lines));
                        $newHeaders = [];
                        foreach ($headers as $header) {
                            if ($header == "naam") {
                                $newHeader = "name";
                            } else if ($header == "beroep") {
                                $newHeader = "occupation";
                            } else if ($header == "stad") {
                                $newHeader = "city";
                            } else if ($header == "postcode") {
                                $newHeader = "postal_code";
                            } else if ($header == "bedrijf") {
                                $newHeader = "company";
                            } else if ($header == "verhaal") {
                                $newHeader = "story";
                            } else if ($header == "missieleader") {
                                $newHeader = "mission";
                            } else if ($header == "telefoonnummer") {
                                $newHeader = "phone_number";
                            } else if ($header == "mobielnummer") {
                                $newHeader = "mobile_phone";
                            } else if ($header == "website") {
                                $newHeader = "url";
                            } else if ($header == "e_mail") {
                                $newHeader = "email";
                            } else if ($header == "beschrijving") {
                                $newHeader = "description";
                            } else if ($header == "korte_beschrijving") {
                                $newHeader = "short_description";
                            } else {
                                $newHeader = $header;
                            }
                            array_push($newHeaders, $newHeader);
                        }
                        $dataRows = array();
                        foreach ($lines as $line) {
                            $dataRow = array();
                            foreach (str_getcsv($line) as $key => $field) {
                                $dataRow[$newHeaders[$key]] = $field;
                            }
                            $dataRow = array_filter($dataRow);
                            $dataRows[] = $dataRow;
                        }
                        $faker = Faker::create('en_Us');
                        $tasks = [];
                        switch ($file['filetype']) {
                            case "specialists":
                                foreach ($dataRows as $dataRow) {
                                    $region = $country = $lat = $lng = "";
                                    if($useMock) {
                                        $lat = $faker->latitude;
                                        $lng = $faker->longitude;
                                    } else {
                                        $address = urlencode($dataRow['address']);
                                        $zip = urlencode($dataRow['postal_code']);
                                        $city = urlencode($dataRow['city']);
                                        $aCount = Specialist::where([["address", $dataRow['address']], ["postal_code", $dataRow['postal_code']], ["city", $dataRow['city']]])->count();
                                        if($aCount) {
                                            $ref = Specialist::where([["address", $dataRow['address']], ["postal_code", $dataRow['postal_code']], ["city", $dataRow['city']]])->first();
                                            $lat = $ref->map_lat;
                                            $lng = $ref->map_lng;
                                            $region = $ref->region;
                                            $country = $ref->country;
                                        } else {
                                            $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address},{$zip},{$city}&sensor=false&key=AIzaSyDTMGtzFUNyyV3YICxx0aGCag3eryHThEc";
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
                                                        "title"  =>"Adres controler voor: {$dataRow['name']}",
                                                        "description" =>"Het systeem kon de volgende gegevens niet vinden: Provincie, Land, Coordinaten, dit betekent dat het adres een foutief adres is, graag controleren",
                                                        "type" => "edit",
                                                        "status" => 0,
                                                        "assigner_id" => "1",
                                                        "assignee_type" => "groups",
                                                        "assignee_id" => "1",
                                                    ]);
                                                    break;
                                                case "OVER_QUERY_LIMIT":
                                                    $region = "TODO";
                                                    $country = "TODO";
                                                    $lat = $lng = 200;
                                                    break;
                                            }

                                        }
                                    }
                                    if(isset($dataRow['story'])) {
                                        $rawStory = $dataRow["story"];
                                        $almostCleanStory = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $rawStory);
                                        $dataRow["story"] = preg_replace('/on[.]+=(?:\'|\")?[.]+(?:\'|\")?/is', "",  $almostCleanStory);
                                    }
                                    $dataRow["map_lat"] = $lat;
                                    $dataRow["map_lng"] = $lng;
                                    $dataRow["region"] = $region;
                                    $dataRow["country"] = $country;
                                    $dataRow['url_name'] = $mockURL ? str_slug($dataRow['name'].$faker->unique()->numberBetween()) : str_slug($dataRow['name']);
                                    $specialist = Specialist::create($dataRow);
                                }
                                break;
                            case "specialisms":
                                foreach ($dataRows as $dataRow) {
                                    if ($mockURL) {
                                        $dataRow['name'] = str_shuffle($dataRow['name'] . Dummy::generateSeed(10));
                                    }
                                    $dataRow['description'] = substr($dataRow['description'], 0, 30);
                                    $dataRow['short_description'] = substr($dataRow['short_description'], 0, 30);
                                    $specialist = Specialism::create($dataRow);
                                }
                                break;
                            case "therapies":
                                foreach ($dataRows as $dataRow) {
                                    if ($mockURL) {
                                        $dataRow['name'] = str_shuffle($dataRow['name'] . Dummy::generateSeed(10));
                                    }
                                    $dataRow['description'] = substr($dataRow['description'], 0, 30);
                                    $dataRow['short_description'] = substr($dataRow['short_description'], 0, 30);
                                }
                                  break;
                            case "complaints":
                                foreach ($dataRows as $dataRow) {
                                    if ($mockURL) {
                                        $dataRow['name'] = str_shuffle($dataRow['name'] . Dummy::generateSeed(10));
                                    }
                                    $dataRow['description'] = substr($dataRow['description'], 0, 30);
                                    $dataRow['short_description'] = substr($dataRow['short_description'], 0, 30);
                                    $specialist = Complaint::create($dataRow);
                                }
                                break;
                        }
                        if(Storage::delete("app\batchUploads\\$fname")) {
                            \Session::flash("{$fname} deleted ", "Cool");
                        } else {
                            echo("Couldn't delete file: $fname. <br> Reason: Who knows");
                        }
                    } else {
                        if(Storage::delete("app\batchUploads\\$fname")) {
                            \Session::flash("{$fname} deleted ", "Cool");
                        } else {
                            echo("Couldn't delete file: $fname. <br> Reason: Who knows");
                        }
                    }
                }
            }

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
        \Storage::delete("storage\app\batchUploads\\$fileName");
        return redirect()->back();
    }
}

<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Message;

/**
 * Class MessagesTableSeeder
 */
class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('nl_NL');
        foreach (range(0, 30) as $index) {
            $rec = rand(1,2);
            if($rec == 1) {
                $send = 2;
            } else {
                $send = 1;
            }
            Message::create([
                'uuid' => $faker->uuid,
                'subject' => $faker->sentence,
                'body' => $faker->text(255),
                'read' => 0,
                'recipient_id' =>  $rec,
                'sender_id' => $send,
            ]);
        }
    }
}
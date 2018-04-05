<?php

use Illuminate\Database\Seeder;
use PlanIt\Event;

class DummyEvents extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Let's truncate our existing records to start from scratch.
     PlanIt\Event::truncate();

     $faker = \Faker\Factory::create();

     // And now, let's create a few articles in our database:
     for ($i = 0; $i < 500; $i++) {
         Event::create([
          'name' => $faker->name,
          'user_id' => 1,
          'type' => 'Test Event',
          'description' => $faker->text,
          'start_date' => $faker->date,
          'end_date' => $faker->date,
          'start_time' => $faker->time,
          'end_time' => $faker->time,
          'location' => $faker->city
         ]);
     }
    }
}

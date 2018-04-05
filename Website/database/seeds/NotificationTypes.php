<?php

use Illuminate\Database\Seeder;

class NotificationTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('notificationtypes')->insert([
        ['id' => '0', 'name' => 'Event'],
        ['id' => '1', 'name' => 'Follow'],
        ['id' => '2', 'name' => 'Subscription']
      ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class NotificationTemplates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('notificationtemplates')->insert([
        ['id' => '0', 'body' => 'This event has been updated.', 'type' => '0'],
        ['id' => '1', 'body' => 'This event has been cancelled.', 'type' => '0'],
        ['id' => '2', 'body' => 'A user has followed you.', 'type' => '1'],
        ['id' => '3', 'body' => 'A user has subscribed to your event.', 'type' => '2'],
      ]);
    }
}

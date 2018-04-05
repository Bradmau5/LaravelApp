<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //$this->call(DummyEvents::class);
      $this->call(NotificationTemplates::class);
      $this->call(NotificationTypes::class);
    }
}

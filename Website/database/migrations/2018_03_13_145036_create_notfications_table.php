<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotficationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notfications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notificationtemplate_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->text('body');
            $table->timestamps();
        });
        Schema::create('notificationtemplates', function (Blueprint $table) {
          $table->integer('id');
          $table->text('body');
          $table->integer('type');
        });
        Schema::create('notificationtypes', function (Blueprint $table) {
          $table->integer('id');
          $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notfications');
        Schema::dropIfExists('notficationtemplates');
        Schema::dropIfExists('notficationtypes');
    }
}

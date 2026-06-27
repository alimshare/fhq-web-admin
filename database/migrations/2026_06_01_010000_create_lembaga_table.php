<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLembagaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lembaga', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('name', 60);
            $table->string('address', 150)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->integer('since')->nullable();
            $table->string('longitude', 30)->nullable();
            $table->string('latitude', 30)->nullable();
            $table->string('picture', 100)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('province', 50)->nullable();
            $table->string('region', 50)->nullable();
            $table->string('status', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('reference', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lembaga');
    }
}

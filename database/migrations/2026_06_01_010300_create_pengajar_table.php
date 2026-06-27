<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengajarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajar', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('nip', 100)->nullable();
            $table->string('name', 60);
            $table->string('address', 150)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('phone', 15)->nullable();
            $table->date('join_date')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place', 30)->nullable();
            $table->string('educational_background', 60)->nullable();
            $table->string('educational_field', 60)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->integer('marital_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('father_name', 100)->nullable();
            $table->string('spouse', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('village', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajar');
    }
}

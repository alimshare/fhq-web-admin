<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendidikanSantriOldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendidikan_santri_old', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->integer('santri_id')->index();
            $table->integer('halaqoh_id')->index();
            $table->integer('nilai_uts_teori')->nullable();
            $table->integer('nilai_uts_praktek')->nullable();
            $table->integer('nilai_uas_teori')->nullable();
            $table->integer('nilai_uas_praktek')->nullable();
            $table->integer('nilai_latihan')->nullable();
            $table->string('khatam', 50)->nullable();
            $table->integer('kehadiran')->nullable();
            $table->string('status', 30)->nullable();
            $table->string('note', 150)->nullable();
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
        Schema::dropIfExists('pendidikan_santri_old');
    }
}

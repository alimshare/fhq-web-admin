<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHalaqohTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('halaqoh', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';

            $table->increments('id');
            $table->integer('semester_id')->index();
            $table->integer('program_id')->nullable()->index();
            $table->integer('pengajar_id')->nullable()->index();
            $table->enum('day', ['AHAD', 'SABTU'])->nullable();
            $table->char('start_hour', 8)->nullable();
            $table->string('jenis_kbm', 100)->nullable();
            $table->string('lokasi_kbm', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('reference', 100)->nullable();
            $table->string('gender', 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('halaqoh');
    }
}

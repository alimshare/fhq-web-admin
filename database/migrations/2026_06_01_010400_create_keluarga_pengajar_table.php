<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeluargaPengajarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluarga_pengajar', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';

            $table->increments('id');
            $table->integer('pengajar_id')->index();
            $table->string('name', 60);
            $table->string('relationship', 60)->nullable();
            $table->string('occupation', 60)->nullable();
            $table->integer('santri_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keluarga_pengajar');
    }
}

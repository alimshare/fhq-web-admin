<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->integer('santri_id')->index();
            $table->integer('halaqoh_id')->index();
            $table->decimal('nilai_uts_teori', 11, 2)->nullable();
            $table->decimal('nilai_uts_praktek', 11, 2)->nullable();
            $table->decimal('nilai_uts_hafalan', 11, 2)->nullable()->comment('tahfidz');
            $table->decimal('nilai_uas_teori', 11, 2)->nullable();
            $table->decimal('nilai_uas_praktek', 11, 2)->nullable();
            $table->decimal('nilai_uas_hafalan', 11, 2)->nullable()->comment('tahfidz');
            $table->decimal('nilai_latihan', 11, 2)->nullable();
            $table->string('khatam', 50)->nullable();
            $table->integer('kehadiran')->nullable();
            $table->string('status', 30)->nullable();
            $table->text('note')->nullable();
            $table->text('management_note')->nullable();
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
        Schema::dropIfExists('peserta');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDaftarUlang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_ulang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('peserta_id');

            $table->string('jenis_kbm', 50)->nullable()->comment("Jenis KBM Offline or Online");
            $table->string('hari', 50)->nullable()->comment("Jenis KBM Offline or Online");

            $table->string('upload_file', 50)->nullable()->comment("Bukti Daftar Ulang");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daftar_ulang');
    }
}

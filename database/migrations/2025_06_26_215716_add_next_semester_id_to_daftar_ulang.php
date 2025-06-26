<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNextSemesterIdToDaftarUlang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daftar_ulang', function (Blueprint $table) {
            $table->bigInteger('next_semester_id')->nullable()->comment('Semester Daftar Ulang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daftar_ulang', function (Blueprint $table) {
            $table->dropColumn('next_semester_id');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNextSemesterIdToSemester extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('semester', function (Blueprint $table) {
            $table->bigInteger('next_semester_id')->nullable()->comment('ID Semester Selanjutnya');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('semester', function (Blueprint $table) {
            $table->dropColumn('next_semester_id');
        });
    }
}

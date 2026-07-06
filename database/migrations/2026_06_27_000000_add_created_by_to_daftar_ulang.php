<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByToDaftarUlang extends Migration
{
    public function up()
    {
        Schema::table('daftar_ulang', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('next_semester_id')->comment('User ID who created this record');
        });
    }

    public function down()
    {
        Schema::table('daftar_ulang', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotesToDaftarUlang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daftar_ulang', function (Blueprint $table) {
            $table->string('notes', 200)->nullable()->comment('Catatan untuk data DU');
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
            $table->dropColumn('notes');
        });
    }
}

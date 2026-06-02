<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_report', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';

            $table->increments('id');
            $table->integer('halaqoh_id')->index();
            $table->date('tgl')->nullable();
            $table->text('description')->nullable()->collation('utf8mb3_unicode_ci');
            $table->text('management_note')->nullable()->collation('utf8mb3_unicode_ci');
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('updated_at')->nullable();
            $table->enum('status', ['NORMAL', 'BADAL', 'GABUNG'])->nullable();
            $table->integer('badal_id')->nullable()->index('fk_badal');
            $table->integer('pengajar_badal_id')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
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
        Schema::dropIfExists('activity_report');
    }
}

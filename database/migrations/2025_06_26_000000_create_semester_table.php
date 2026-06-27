<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semester', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('name', 60);
            $table->string('description', 150)->nullable();
            $table->date('start_period')->nullable();
            $table->date('end_period')->nullable();
            $table->integer('active')->default(0);
            $table->integer('lembaga_id')->nullable()->index();
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
        Schema::dropIfExists('semester');
    }
}

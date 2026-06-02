<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';

            $table->increments('id');
            $table->string('name', 60);
            $table->string('description', 150)->nullable();
            $table->double('infaq')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->string('reference', 100)->nullable();
            $table->integer('sequence')->nullable();
            $table->string('next_program', 50)->nullable()->comment('Next Program');
            $table->integer('next_program_id')->nullable()->comment('Next Program ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program');
    }
}

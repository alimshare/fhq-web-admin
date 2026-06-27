<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSantriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('santri', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('nis', 60);
            $table->string('name', 60);
            $table->date('join_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place', 30)->nullable();
            $table->enum('gender', ['MALE', 'FEMALE'])->nullable();
            $table->string('address', 150)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('educational_background', 60)->nullable();
            $table->string('educational_field', 100)->nullable();
            $table->string('father_name', 60)->nullable();
            $table->string('father_job', 60)->nullable();
            $table->string('mother_name', 60)->nullable();
            $table->string('mother_job', 60)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->string('job_salary', 100)->nullable();
            $table->integer('marital_status')->default(1);
            $table->string('spouse_name', 60)->nullable();
            $table->string('spouse_job', 60)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('kota', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('propinsi', 50)->nullable()->comment('Propinsi Alamat Domisili');
            $table->string('registration_number', 30)->nullable()->comment('Nomor Pendaftaran Santri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('santri');
    }
}

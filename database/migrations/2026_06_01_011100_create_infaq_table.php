<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infaq', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';

            $table->increments('id');
            $table->integer('peserta_id')->index();
            $table->double('amount');
            $table->string('transaction_number', 30);
            $table->dateTime('transaction_date')->useCurrent();
            $table->string('transaction_type', 30)->nullable();
            $table->string('payment_method', 30)->nullable();
            $table->enum('status', ['PAID', 'UNPAID', 'CANCEL'])->nullable();
            $table->string('note', 150)->nullable();
            $table->string('recipient', 30);
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('updated_at')->nullable();
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
        Schema::dropIfExists('infaq');
    }
}

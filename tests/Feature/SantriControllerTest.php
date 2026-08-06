<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SantriControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);

        $this->app['db']->connection()->getSchemaBuilder()->create('santri', function ($table) {
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
            $table->string('propinsi', 50)->nullable();
            $table->string('registration_number', 30)->nullable();
        });
    }

    public function test_it_saves_birth_date_when_creating_santri()
    {
        $this->withoutMiddleware();

        $response = $this->post('/santri/save', [
            'name' => 'Ahmad',
            'nis' => '1001',
            'gender' => 'MALE',
            'phone' => '081234567890',
            'birth_date' => '1995-05-10',
        ]);

        $response->assertRedirect('/santri');

        $this->assertDatabaseHas('santri', [
            'nis' => '1001',
            'birth_date' => '1995-05-10',
        ]);
    }
}

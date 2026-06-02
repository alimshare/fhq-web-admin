<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateVwCheckSantriBelumTerdaftar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(<<<SQL
CREATE OR REPLACE VIEW `vw_check_santri_belum_terdaftar` AS
SELECT
    `t1`.`id` AS `id`,
    `t1`.`nis` AS `nis`,
    `t1`.`name` AS `name`,
    `t1`.`terdaftar` AS `terdaftar`
FROM (SELECT
        `santri`.`id` AS `id`,
        `santri`.`nis` AS `nis`,
        `santri`.`name` AS `name`,
        (SELECT count(1) FROM `peserta` WHERE (`peserta`.`santri_id` = `santri`.`id`)) AS `terdaftar`
    FROM `santri`) `t1`
WHERE ((`t1`.`terdaftar` < 1) OR (`t1`.`terdaftar` IS NULL))
SQL);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `vw_check_santri_belum_terdaftar`');
    }
}

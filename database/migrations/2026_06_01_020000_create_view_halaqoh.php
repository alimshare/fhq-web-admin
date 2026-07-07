<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateViewHalaqoh extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(<<<SQL
CREATE OR REPLACE VIEW `view_halaqoh` AS
SELECT
    `h`.`id` AS `halaqoh_id`,
    `h`.`reference` AS `halaqoh_reference`,
    `p`.`gender` AS `gender`,
    `pg`.`name` AS `program_name`,
    `pg`.`id` AS `program_id`,
    `pg`.`reference` AS `program_reference`,
    `p`.`name` AS `pengajar_name`,
    `p`.`id` AS `pengajar_id`,
    `p`.`nip` AS `nip`,
    `s`.`name` AS `semester_name`,
    `s`.`id` AS `semester_id`,
    `s`.`reference` AS `semester_reference`,
    `l`.`name` AS `lembaga_name`,
    `l`.`id` AS `lembaga_id`,
    `l`.`reference` AS `lembaga_reference`,
    `h`.`day` AS `day`,
    `h`.`start_hour` AS `start_hour`,
    `h`.`jenis_kbm` AS `jenis_kbm`,
    `h`.`gender` AS `halaqoh_gender`
FROM ((((`halaqoh` `h`
    LEFT JOIN `pengajar` `p` ON ((`h`.`pengajar_id` = `p`.`id`)))
    LEFT JOIN `program` `pg` ON ((`h`.`program_id` = `pg`.`id`)))
    LEFT JOIN `semester` `s` ON ((`h`.`semester_id` = `s`.`id`)))
    LEFT JOIN `lembaga` `l` ON ((`s`.`lembaga_id` = `l`.`id`)))
WHERE `h`.`deleted_at` IS NULL
ORDER BY `pg`.`name`, `p`.`gender`
SQL);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `view_halaqoh`');
    }
}

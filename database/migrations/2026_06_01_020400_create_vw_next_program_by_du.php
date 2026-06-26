<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateVwNextProgramByDu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(<<<SQL
CREATE OR REPLACE VIEW `vw_next_program_by_du` AS
SELECT
    `h`.`semester_id` AS `semester_id`,
    `du`.`next_semester_id` AS `next_semester_id`,
    `du`.`id` AS `du_id`,
    `du`.`peserta_id` AS `peserta_id`,
    `du`.`jenis_kbm` AS `jenis_kbm`,
    `du`.`hari` AS `hari`,
    `du`.`tgl_lahir` AS `tgl_lahir`,
    `s`.`phone` AS `phone`,
    `s`.`id` AS `santri_id`,
    `s`.`nis` AS `nis`,
    `s`.`name` AS `name`,
    `p`.`management_note` AS `management_note`,
    `h`.`program_id` AS `current_program_id`,
    `pg`.`name` AS `current_program_name`,
    coalesce(`p`.`status`, 'TETAP') AS `status`,
    (CASE WHEN (`p`.`status` = 'NAIK') THEN `pg`.`next_program_id` ELSE `h`.`program_id` END) AS `next_program_id`,
    (CASE WHEN (`p`.`status` = 'NAIK') THEN `pg`.`next_program` ELSE `pg`.`name` END) AS `next_program_name`
FROM ((((`daftar_ulang` `du`
    JOIN `peserta` `p` ON ((`p`.`id` = `du`.`peserta_id`)))
    JOIN `santri` `s` ON ((`p`.`santri_id` = `s`.`id`)))
    JOIN `halaqoh` `h` ON ((`h`.`id` = `p`.`halaqoh_id`)))
    LEFT JOIN `program` `pg` ON ((`pg`.`id` = `h`.`program_id`)))
WHERE (`du`.`deleted_at` IS NULL)
SQL);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `vw_next_program_by_du`');
    }
}

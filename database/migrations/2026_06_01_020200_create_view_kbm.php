<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateViewKbm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(<<<SQL
CREATE OR REPLACE VIEW `view_kbm` AS
SELECT
    `ac`.`id` AS `activity_id`,
    `ac`.`tgl` AS `tgl`,
    `vh`.`program_name` AS `program_name`,
    `vh`.`day` AS `day`,
    `vh`.`pengajar_id` AS `pengajar_id`,
    `vh`.`pengajar_name` AS `pengajar_name`,
    `ac`.`description` AS `description`,
    `ac`.`management_note` AS `management_note`,
    `ac`.`status` AS `status_kbm`,
    `ac`.`start_time` AS `start_time`,
    `ac`.`end_time` AS `end_time`,
    `vh`.`program_id` AS `program_id`,
    `vh`.`semester_id` AS `semester_id`,
    `vh`.`semester_name` AS `semester_name`,
    (SELECT count(1) FROM `attendance` `a` WHERE (`a`.`activity_id` = `ac`.`id`)) AS `jumlah_peserta`,
    (SELECT count(1) FROM `attendance` `a` WHERE ((`a`.`activity_id` = `ac`.`id`) AND (`a`.`status` = 1))) AS `hadir`,
    (SELECT count(1) FROM `attendance` `a` WHERE ((`a`.`activity_id` = `ac`.`id`) AND (`a`.`status` = 0))) AS `tidak_hadir`
FROM (`activity_report` `ac`
    LEFT JOIN `view_halaqoh` `vh` ON ((`ac`.`halaqoh_id` = `vh`.`halaqoh_id`)))
ORDER BY `ac`.`tgl` DESC
SQL);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `view_kbm`');
    }
}

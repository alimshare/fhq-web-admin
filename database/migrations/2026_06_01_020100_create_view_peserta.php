<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateViewPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(<<<SQL
CREATE OR REPLACE VIEW `view_peserta` AS
SELECT
    `ps`.`id` AS `peserta_id`,
    `ps`.`reference` AS `peserta_reference`,
    `santri`.`id` AS `santri_id`,
    `santri`.`nis` AS `nis`,
    `santri`.`name` AS `santri_name`,
    `santri`.`gender` AS `gender_santri`,
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
    `ps`.`nilai_uts_teori` AS `nilai_uts_teori`,
    `ps`.`nilai_uts_praktek` AS `nilai_uts_praktek`,
    `ps`.`nilai_uas_teori` AS `nilai_uas_teori`,
    `ps`.`nilai_uas_praktek` AS `nilai_uas_praktek`,
    `ps`.`khatam` AS `khatam`,
    `ps`.`status` AS `status`,
    `ps`.`note` AS `catatan`,
    `ps`.`management_note` AS `catatan_manajemen`,
    `ps`.`kehadiran` AS `kehadiran`,
    `h`.`jenis_kbm` AS `jenis_kbm`,
    `h`.`lokasi_kbm` AS `lokasi_kbm`,
    `ps`.`deleted_at` AS `deleted_at`
FROM ((((((`peserta` `ps`
    LEFT JOIN `santri` ON ((`ps`.`santri_id` = `santri`.`id`)))
    LEFT JOIN `halaqoh` `h` ON ((`ps`.`halaqoh_id` = `h`.`id`)))
    LEFT JOIN `pengajar` `p` ON ((`h`.`pengajar_id` = `p`.`id`)))
    LEFT JOIN `program` `pg` ON ((`h`.`program_id` = `pg`.`id`)))
    LEFT JOIN `semester` `s` ON ((`h`.`semester_id` = `s`.`id`)))
    LEFT JOIN `lembaga` `l` ON ((`s`.`lembaga_id` = `l`.`id`)))
ORDER BY `h`.`day`, `pg`.`name`, `p`.`gender`, `p`.`name`, `santri`.`name`
SQL);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `view_peserta`');
    }
}

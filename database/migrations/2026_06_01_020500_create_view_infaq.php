<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateViewInfaq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(<<<SQL
CREATE OR REPLACE VIEW `view_infaq` AS
SELECT
    `i`.`id` AS `infaq_id`,
    `i`.`amount` AS `amount`,
    `i`.`transaction_number` AS `transaction_number`,
    `i`.`transaction_date` AS `transaction_date`,
    `i`.`transaction_type` AS `transaction_type`,
    `i`.`payment_method` AS `payment_method`,
    `i`.`status` AS `status`,
    `i`.`note` AS `note`,
    `i`.`recipient` AS `recipient`,
    `i`.`reference` AS `infaq_reference`,
    `i`.`deleted_at` AS `deleted_at`,
    `ps`.`id` AS `peserta_id`,
    `santri`.`id` AS `santri_id`,
    `santri`.`nis` AS `nis`,
    `santri`.`name` AS `santri_name`,
    `pg`.`name` AS `program_name`,
    `pg`.`id` AS `program_id`,
    `s`.`name` AS `semester_name`,
    `s`.`id` AS `semester_id`,
    `l`.`name` AS `lembaga_name`,
    `l`.`id` AS `lembaga_id`
FROM ((((((`infaq` `i`
    LEFT JOIN `peserta` `ps` ON ((`i`.`peserta_id` = `ps`.`id`)))
    LEFT JOIN `santri` ON ((`ps`.`santri_id` = `santri`.`id`)))
    LEFT JOIN `halaqoh` `h` ON ((`ps`.`halaqoh_id` = `h`.`id`)))
    LEFT JOIN `program` `pg` ON ((`h`.`program_id` = `pg`.`id`)))
    LEFT JOIN `semester` `s` ON ((`h`.`semester_id` = `s`.`id`)))
    LEFT JOIN `lembaga` `l` ON ((`s`.`lembaga_id` = `l`.`id`)))
ORDER BY `i`.`transaction_date` DESC
SQL);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `view_infaq`');
    }
}

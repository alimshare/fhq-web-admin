CREATE OR REPLACE VIEW `view_kbm` AS
select
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
    (
    select
        count(1)
    from
        `attendance` `a`
    where
        `a`.`activity_id` = `ac`.`id`) AS `jumlah_peserta`,
    (
    select
        count(1)
    from
        `attendance` `a`
    where
        `a`.`activity_id` = `ac`.`id`
        and `a`.`status` = 1) AS `hadir`,
    (
    select
        count(1)
    from
        `attendance` `a`
    where
        `a`.`activity_id` = `ac`.`id`
        and `a`.`status` = 0) AS `tidak_hadir`
from
    (`activity_report` `ac`
left join `view_halaqoh` `vh` on
    (`ac`.`halaqoh_id` = `vh`.`halaqoh_id`))
order by
    `ac`.`tgl` desc;
alter table users add column profile_id int;
alter table users add column profile_type varchar(100);

CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE `permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `sequance` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37;

CREATE TABLE `roles_permissions` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `fk_roles_permissions_permission_id` (`permission_id`),
  CONSTRAINT `fk_roles_permissions_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_roles_permissions_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `users_roles` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `users_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `fk_users_roles_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_users_roles_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

INSERT INTO roles (id,name,slug,created_at,updated_at,deleted_at) VALUES 
(1,'Administrator','admin','2019-08-18 13:48:10',NULL,NULL)
,(2,'Muwajih','pengajar','2019-08-18 13:48:10',NULL,NULL)
,(3,'Sekretaris','sekretaris','2019-08-18 13:48:10',NULL,NULL)
,(4,'Mudir','mudir','2019-08-18 13:48:10',NULL,NULL)
,(5,'Direktur Pendidikan','direktur-pendidikan','2019-08-18 13:48:10',NULL,NULL)
;

INSERT INTO permissions (id,name,slug,category,sequance) VALUES 
(1,'Ganti Password','change-password','password',0)
,(3,'Daftar Pengajar','list-pengajar','pengajar',0)
,(4,'Tambah Pengajar','add-pengajar','pengajar',0)
,(5,'Ubah Pengajar','edit-pengajar','pengajar',0)
,(6,'Hapus Pengajar','delete-pengajar','pengajar',0)
,(7,'Detil Pengajar','detail-pengajar','pengajar',0)
,(8,'Daftar Santri','list-santri','santri',0)
,(9,'Tambah Santri','add-santri','santri',0)
,(10,'Ubah Santri','edit-santri','santri',0)
,(11,'Hapus Santri','delete-santri','santri',0)
;
INSERT INTO permissions (id,name,slug,category,sequance) VALUES 
(12,'Detil Santri','detail-santri','santri',0)
,(13,'Daftar Program','list-program','program',0)
,(14,'Tambah Program','add-program','program',0)
,(15,'Ubah Program','edit-program','program',0)
,(16,'Hapus Program','delete-program','program',0)
,(17,'Detil Program','detail-program','program',0)
,(18,'Daftar Lembaga','list-lembaga','lembaga',0)
,(19,'Detil Lembaga','detail-lembaga','lembaga',0)
,(20,'Daftar Halaqoh','list-halaqoh','halaqoh',0)
,(21,'Tambah Halaqoh','add-halaqoh','halaqoh',0)
;
INSERT INTO permissions (id,name,slug,category,sequance) VALUES 
(22,'Ubah Halaqoh','edit-halaqoh','halaqoh',0)
,(23,'Hapus Halaqoh','delete-halaqoh','halaqoh',0)
,(24,'Detil Halaqoh','detail-halaqoh','halaqoh',0)
,(25,'Input Nilai','input-nilai','pengajar',0)
,(26,'Input Nilai Admin','input-nilai-admin','halaqoh',0)
,(27,'Daftar Role','list-role','role',0)
,(28,'Tambah Role','add-role','role',0)
,(29,'Ubah Role','edit-role','role',0)
,(30,'Hapus Role','delete-role','role',0)
,(31,'Daftar Permission','detail-permission','role',0)
;
INSERT INTO permissions (id,name,slug,category,sequance) VALUES 
(32,'Daftar Pengguna','list-user','user',0)
,(33,'Tambah Pengguna','add-user','user',0)
,(34,'Ubah Pengguna','edit-user','user',0)
,(35,'Hapus Pengguna','delete-user','user',0)
,(36,'Reset Password','reset-password','user',0)
;

INSERT INTO roles_permissions (role_id,permission_id) VALUES 
(1,1)
,(4,1)
,(1,3)
,(4,3)
,(1,4)
,(4,4)
,(1,5)
,(4,5)
,(1,6)
,(4,6)
;
INSERT INTO roles_permissions (role_id,permission_id) VALUES 
(1,7)
,(4,7)
,(1,8)
,(4,8)
,(1,9)
,(4,9)
,(1,10)
,(4,10)
,(1,11)
,(4,11)
;
INSERT INTO roles_permissions (role_id,permission_id) VALUES 
(1,12)
,(4,12)
,(1,13)
,(4,13)
,(1,14)
,(4,14)
,(1,15)
,(4,15)
,(1,16)
,(4,16)
;
INSERT INTO roles_permissions (role_id,permission_id) VALUES 
(1,17)
,(4,17)
,(1,18)
,(4,18)
,(1,19)
,(4,19)
,(1,20)
,(4,20)
,(1,21)
,(4,21)
;
INSERT INTO roles_permissions (role_id,permission_id) VALUES 
(1,22)
,(4,22)
,(1,23)
,(4,23)
,(1,24)
,(4,24)
,(1,25)
,(4,25)
,(1,26)
,(4,26)
;
INSERT INTO roles_permissions (role_id,permission_id) VALUES 
(1,27)
,(2,27)
,(4,27)
,(1,28)
,(2,28)
,(4,28)
,(1,29)
,(2,29)
,(4,29)
,(1,30)
;
INSERT INTO roles_permissions (role_id,permission_id) VALUES 
(2,30)
,(4,30)
,(1,31)
,(2,31)
,(4,31)
,(1,32)
,(4,32)
,(1,33)
,(4,33)
,(1,34)
;
INSERT INTO roles_permissions (role_id,permission_id) VALUES 
(4,34)
,(1,35)
,(4,35)
,(1,36)
,(2,36)
,(4,36)
;

INSERT INTO users_roles (user_id,role_id) VALUES 
(1,2)
;
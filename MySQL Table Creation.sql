use sv;

DROP TABLE IF EXISTS `sv_news`;
DROP TABLE IF EXISTS `sv_users`;
DROP TABLE IF EXISTS `sv_profiles_permissions`;
DROP TABLE IF EXISTS `sv_profiles`;
DROP TABLE IF EXISTS `sv_permissions`;
DROP TABLE IF EXISTS `sv_teachers_contacts`;

CREATE TABLE IF NOT EXISTS `sv_permissions`(
	`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	`permission_description` varchar (100) NOT NULL,
	PRIMARY KEY (`id`)
)	ENGINE=InnoDB;

INSERT INTO `sv_permissions` (permission_description) values
	('Basic'),
	('Admin');

CREATE TABLE IF NOT EXISTS `sv_profiles` (
	`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	`profile_description` varchar (100) NOT NULL,
	PRIMARY KEY (`id`)
)	ENGINE=InnoDB;

INSERT INTO `sv_profiles` (profile_description) values
	('Admin'),
	('Student');
	
CREATE TABLE IF NOT EXISTS `sv_profiles_permissions`(
	`id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
	`profile_id` smallint(5) unsigned NOT NULL,
	`permission_id` smallint(5) unsigned NOT NULL,
	`allow` tinyint(1) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `sv_profperm_FKpermissions` FOREIGN KEY (`permission_id`) REFERENCES `sv_permissions` (`id`),
	CONSTRAINT `sv_profperm_FKprofiles` FOREIGN KEY (`profile_id`) REFERENCES `sv_profiles` (`id`)	
)	ENGINE=InnoDB;

INSERT INTO `sv_profiles_permissions` (profile_id,permission_id,allow) values
	(1,1,1),
	(1,2,1),
	(2,1,1),
	(2,2,0);

CREATE TABLE IF NOT EXISTS `sv_users`(
	`id` bigint (11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar (64) NOT NULL,
	`username` varchar (128) NOT NULL,
	`pwd` varchar (256) NOT NULL,
	`profile_id` smallint (5) unsigned NOT NULL,
	`status` tinyint (3) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `sv_users_FKprofiles` FOREIGN KEY (`profile_id`) REFERENCES `sv_profiles` (`id`)
)	ENGINE=InnoDB;

INSERT INTO `sv_users` (name,username,pwd,profile_id,status) values
	('Admin','admin','321admin',1,1),
	('Student','student','british123',2,1);

CREATE TABLE IF NOT EXISTS `sv_news`(
	`id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
	`position` tinyint (1) NOT NULL,
	`ordering` bigint(11) NOT NULL,
	`audience` bigint(17) NOT NULL,
	`title` varchar(64) NULL,
	`text` text NULL,
	`picture` varchar(256) NULL,
	`picture_position` tinyint (1) NULL,
	`author_id` bigint(11) unsigned NOT NULL,
	`status` varchar (16) NOT NULL,
	`created_on` datetime NOT NULL,
	`last_modified` datetime NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `sv_news_FKuser` FOREIGN KEY (`author_id`) REFERENCES `sv_users` (`id`)
)	ENGINE=InnoDB;

INSERT INTO `sv_news` (position,ordering,audience,title,text,author_id,status,created_on,last_modified) values
	(1,5,1,'second in left','text from this article','1','active','25/01/16','25/01/16'),
	(3,1,1,'first in right','text from this article','1','active','25/01/16','25/01/16'),
	(2,7,1,'third in center','text from this article','1','active','25/01/16','25/01/16'),
	(2,6,1,'second in center','text from this article','1','active','25/01/16','25/01/16'),
	(3,9,1,'third in right','text from this article','1','active','25/01/16','25/01/16'),
	(1,3,1,'first in left','text from this article','1','active','25/01/16','25/01/16'),
	(3,4,1,'second in right','text from this article','1','active','25/01/16','25/01/16'),
	(1,8,1,'third in left','text from this article','1','active','25/01/16','25/01/16'),
	(2,2,1,'first in center','text from this article','1','active','25/01/16','25/01/16'),
	(2,10,1,'hidden in center','text from this article','1','hidden','25/01/16','25/01/16'),
	(1,11,1,'hidden in left','text from this article','1','hidden','25/01/16','25/01/16'),
	(3,12,1,'hidden in right','text from this article','1','hidden','25/01/16','25/01/16'),
	(4,13,1,'first in all','text from this article','1','active','25/01/16','25/01/16'),
	(4,15,1,'third in all','text from this article','1','active','25/01/16','25/01/16'),
	(4,14,1,'second in all','text from this article','1','active','25/01/16','25/01/16'),
	(4,16,1,'hidden in all','text from this article','1','hidden','25/01/16','25/01/16');


CREATE TABLE IF NOT EXISTS `sv_teachers_contacts`(
	`id` bigint (11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar (64) NOT NULL,
	`subject` varchar (64) NOT NULL,
	`email` varchar (64) NULL,
	PRIMARY KEY (`id`)
)	ENGINE=InnoDB;

INSERT INTO `sv_teachers_contacts` (name,subject,email) values
	('Adrian Jarrat','Learning Technologies','ajarratt@britishschool.g12.br'),
	('Jakki Saysell','Pastoral Coordinator','jsaysell@britishschool.g12.br'),
	('Jean Claude Remita','ICT','jremita@britishschool.g12.br'),
	('João Paulo Dias','Portuguese','jpdias@britishschool.g12.br');
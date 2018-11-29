CREATE DATABASE doingsdone
  DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

USE doingsdone;


CREATE TABLE IF NOT EXISTS `user`
(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`email` char(255) NOT NULL UNIQUE,
	`name` char(255) NOT NULL,
	`password` char(64),
	`created_at` timestamp default current_timestamp
);

CREATE TABLE IF NOT EXISTS `project`
(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` char(255) NOT NULL UNIQUE,
	`user_id` int(11) unsigned NOT NULL,
	FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE IF NOT EXISTS `task`
(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`project_id` int(11) unsigned NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`created_at` timestamp default current_timestamp NOT NULL,
	`done_at` datetime,
	`status` int(11) unsigned NOT NULL,
	`title` char(255) NOT NULL,
	`deadline` datetime,
	`fileUrl` char(255),
	FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
	FOREIGN KEY (`project_id`) REFERENCES `project` (`id`)
);

CREATE INDEX task ON task(title);
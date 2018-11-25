CREATE DATABASE doingsdone
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;


CREATE TABLE `users` 
(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`email` char(255) NOT NULL UNIQUE,
	`name` char(255) NOT NULL,
	`password` char(64),
	`date_reg` timestamp default current_timestamp
);

CREATE TABLE `projects` 
(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` char(255) NOT NULL UNIQUE,
	`user_id` int(11) unsigned NOT NULL
);

CREATE TABLE `tasks` 
(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`category_id` int(11) unsigned NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`date_create` timestamp default current_timestamp NOT NULL,
	`date_done` datetime,
	`status` int(11) unsigned NOT NULL,
	`title` char(255) NOT NULL,
	`deadline` datetime,
	`file` char(255)
);

CREATE INDEX task ON tasks(title);
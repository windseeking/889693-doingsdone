CREATE DATABASE doingsdone
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

USE doingsdone;


CREATE TABLE IF NOT EXISTS `user`
(
	`id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`email` char(255) NOT NULL UNIQUE KEY,
	`name` char(255) NOT NULL,
	`password` char(64) NOT NULL,
	`created_at` timestamp default current_timestamp NOT NULL
);

CREATE TABLE IF NOT EXISTS `project`
(
	`id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` char(255) NOT NULL UNIQUE KEY,
	`user_id` int unsigned NOT NULL,
	KEY project_user_id_fk (user_id),
  CONSTRAINT project_user_id_fk FOREIGN KEY (user_id) REFERENCES user (id)
);

CREATE TABLE IF NOT EXISTS `task`
(
	`id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`project_id` int unsigned DEFAULT NULL,
	`user_id` int unsigned NOT NULL,
	`created_at` timestamp default current_timestamp NOT NULL,
	`done_at` datetime DEFAULT NULL,
	`status` int unsigned NOT NULL,
	`title` char(255) NOT NULL,
	`deadline_at` datetime DEFAULT NULL,
	`file_url` char(255) DEFAULT NULL,
	KEY task (title),
  KEY task_project_id_fk (project_id),
  KEY task_user_id_fk (user_id),
  CONSTRAINT task_project_id_fk FOREIGN KEY (project_id) REFERENCES project (id),
  CONSTRAINT task_user_id_fk FOREIGN KEY (user_id) REFERENCES user (id)
);

CREATE INDEX task ON task(title);
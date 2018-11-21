<?php

require_once('functions.php');
require_once ('data.php');

$page_title = 'Дела в порядке';

$page_content = include_template ('index.php', [
	'tasks' => $tasks, 
	'show_complete_tasks' => $show_complete_tasks 
]);

$layout_content = include_template ('layout.php', [
	'content' => $page_content, 
	'title' => $page_title, 
	'projects' => $projects, 
	'tasks' => $tasks
]);

print($layout_content);

?>
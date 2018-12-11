<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('functions.php');
require_once('config/db.php');

$con = get_connection($db);

$cur_user = 1;

$projects = get_projects($con, $cur_user);
$tasks = get_tasks($con, $cur_user);

$page_title = 'Дела в порядке';

$page_content = include_template('index.php', [
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => $page_title,
    'projects' => $projects,
]);

print($layout_content);

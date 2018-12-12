<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('functions.php');
require_once('config/db.php');

$con = get_connection($database_config);

$cur_user = 1;

if (isset($_GET['project_id'])) {
    $project_id = (int)$_GET['project_id'];
    $projects = get_projects_by_id($project_id, $con);
    if (!$projects) {
        die(http_response_code(404));
    }
    $tasks = get_tasks_by_project_id($project_id, $con);
}
else {
    $tasks = get_tasks_by_user_id($cur_user, $con);
}


$page_title = 'Дела в порядке';

$page_content = include_template('index.php', [
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => $page_title,
    'projects' => get_projects_by_user_id($cur_user, $con)
]);

print($layout_content);

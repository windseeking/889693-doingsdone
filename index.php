<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('functions.php');
require_once('config.php');

$con = get_connection($database_config);

$current_user_id = 1;
$tasks = [];

if (isset($_GET['project_id'])) {
    $project_id = (int)$_GET['project_id'];
    $project = get_project_by_id($project_id, $con);
    if (empty($project)) {
        die(http_response_code(404));
    }
    $tasks = get_tasks_by_project_id($project_id, $con);
}
else {
    $tasks = get_tasks_by_user_id($current_user_id, $con);
}

$page_title = 'Дела в порядке';

$page_content = include_template('index.php', [
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => $page_title,
    'projects' => get_projects_by_user_id($current_user_id, $con)
]);

print($layout_content);

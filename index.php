<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('functions.php');
require_once('config/db.php');

$con = get_connection($db);

$cur_user = 1;

$projects = get_projects_byUser($cur_user, $con);

if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $project = get_projects_byId($project_id, $con);
    if (!$project) {
        die(http_response_code(404));
    }
    else {
        $tasks = get_tasks_byProject($project_id, $con);
    }
}
else {
    $tasks = get_tasks_byUser($cur_user, $con);
}

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

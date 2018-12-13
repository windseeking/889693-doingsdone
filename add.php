<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('functions.php');
require_once('config.php');

$con = get_connection($database_config);

$current_user_id = 1;
$projects = get_projects_by_user_id($current_user_id, $con);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST['task'];
    $errors = [];
    // проверка имени задачи
    if (empty($task['title'])) {
            $errors['title'] = 'Обязательное поле';
        }
    }
    // проверка существования проекта
    $is_project_exists = false;
    foreach ($projects as $project) {
        if($project['id'] == $tasks['project_id']) {
            $is_project_exists = true;
            break;
        }
    }
    if(!$is_project_exists) {
        $errors['project'] = 'Выберите существующий проект';
    }
    // проверка формата даты
    if ($tasks['deadline_at'] == '') {
        $tasks['deadline_at'] = null;
    }
    else if (!date_validation($tasks['deadline_at'])) {
        $errors['deadline_at'] = 'Некорректный формат даты';
    }

    if (!empty($tasks['file_url'])) {
        $filename = uniqid() . '-' . $_FILES['tasks']['title']['file_url'];
        $tasks['file_url'] = $filename;
        move_uploaded_file($_FILES['tasks']['tmp_name']['file_url'], 'uploads/' . $filename);
    }
    else {
        $tasks['file_url'] = null;
    }

    if (count($errors) > 0) {
        $page_content = include_template('add.php', ['projects' => $projects, 'tasks' => $tasks, 'errors' => $errors]);
    }
    else {
        add_task($con, $tasks['title'], $tasks['deadline_at'], $tasks['file_url'], $tasks['project_id']);
        die();
    }

$page_title = 'Добавление задачи';

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => $page_title,
    'projects' => $projects
]);

print($layout_content);

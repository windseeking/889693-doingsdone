<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('functions.php');
require_once('config.php');

$con = get_connection($database_config);
$current_user_id = 1;
$projects = get_projects_by_user_id($current_user_id, $con);
$task = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST['task'];
    $errors = [];

    if (empty($task['title'])) {
        $errors['title'] = 'Обязательное поле';
    }
    // проверка существования проекта
    if(!is_project_exists($con, (int) $task['project_id'])) {
        $errors['project_id'] = 'Выберите существующий проект';
    }

    if ($task['deadline_at'] == '') {
        $task['deadline_at'] = null;
    }
    else if (!is_valid_date($task['deadline_at'])) {
        $errors['deadline_at'] = 'Некорректный формат даты';
    }

    if (isset($_FILES['task']['file_url'])) {
        $file_name = uniqid() . '-' . $_FILES['task']['title']  ;
        $file_path = __DIR__ . '/uploads/';
        move_uploaded_file($_FILES['task']['tmp_name'], '/uploads'. $file_name);
        print($file_name);
    }
    else {
        $task['file_url'] = null;
    }
    if (empty($errors)) {
        add_task($con, $task);
        die();
    }
    $page_content = include_template('add.php', ['projects' => $projects, 'task' => $task, 'errors' => $errors]);
}
else {
    $page_content = include_template('add.php', [
        'projects' => $projects,
        'task' => $task
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление задачи',
    'side_content' => include_template('index_side_content.php', ['projects' => $projects])
]);

print($layout_content);

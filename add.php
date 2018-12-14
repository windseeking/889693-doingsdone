<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('functions.php');
require_once('config.php');

$con = get_connection($database_config);
$current_user_id = 1;
$projects = get_projects_by_user_id($current_user_id, $con);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST['task'];
    $errors = [];
    // проверка имени задачи
    if (empty($task['title'])) {
        $errors['title'] = 'Обязательное поле';
    }
    // проверка существования проекта
    $is_project_exists = false;
    if(!is_project_exists($projects, $task)) {
        $errors['project'] = 'Выберите существующий проект';
    }
    // проверка формата даты
    if ($task['deadline_at'] == '') {
        $task['deadline_at'] = null;
    }
    else if (!is_valid_date($task['deadline_at'])) {
        $errors['deadline_at'] = 'Некорректный формат даты';
    }
    if (!empty($task['file_url'])) {
        $file_name = uniqid() . '-' . $_FILES['task']['title'];
        $file_path = __DIR__ . '/uploads';
        $file_url = '/uploads/' . $file_name;
        move_uploaded_file($_FILES['task']['tmp_name'], $file_path . $file_name);
        print("<a href='$file_url'>$file_name</a>");
    }
    else {
        $task['file_url'] = null;
    }
    if (count($errors)) {
        $page_content = include_template('add.php', ['projects' => $projects, 'errors' => $errors]);
    }
    else {
        add_task($con, $task['title'], $task['deadline_at'], $task['file_url'], $task['project_id']);
        header('Location: index.php');
        die();
    }
}
else {
    $page_content = include_template('add.php', ['projects' => $projects]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление задачи',
    'side_content' => include_template('index_side_content.php', ['projects' => $projects])
]);

print($layout_content);

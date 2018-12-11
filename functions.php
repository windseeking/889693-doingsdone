<?php

require_once('mysql_helper.php');

$show_complete_tasks = rand(0, 1);

// Шаблонизатор
function include_template(string $name, array $data): string {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
};

// Защита от XSS-атак
function filter_tags($str): string {
    if ($str === null) {
        return '';
    }
    return strip_tags($str);
};

// Выделение задач, до даты выполнения которых осталось менее 24 часов
function almost_elapsed(string $elapse_date): bool {
    $deadline = strtotime($elapse_date);
    $now = time();
    $diff = $deadline - $now;
    if ($diff <= 86400 && !empty($elapse_date)) {
        return true;
    }
    return false;
};

function get_connection(array $db) {
    $con = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
    if (!$con) {
        $err = mysqli_connect_error();
        die(include_template('error.php', ['error' => $err]));
    }
    mysqli_set_charset($con, 'utf8');
    return $con;
};

// Получение проекта по ID
function get_projects_byId($project_id, $con) {
    $sql =
        "SELECT id AS project_id, name FROM project ".
        "WHERE id = ?";
    $values = [$project_id];
    $project = db_fetch_data($con, $sql, $values);
    return $project ? $project[0] : null;
}

// Получение ссылки на проект
function get_url(int $project_id): string {
    $scriptname = 'index.php';
    $query = http_build_query($project_id);
    $url = '/' . $scriptname . '?' . $query;
    return $url;
};

// Получение проектов для текущего пользователя
function get_projects_byUser($user_id, $con) {
    $sql =
        "SELECT p.id, p.name, COUNT(t.id) AS task_amount FROM project p ".
        "JOIN user u ON p.user_id = u.id ".
        "LEFT JOIN task t ON p.id = t.project_id ".
        "WHERE p.user_id = ? GROUP BY p.id ".
        "ORDER BY p.name";
    $values = [$user_id];
    $projects = db_fetch_data($con, $sql, $values);
    return $projects;
};

// Получение задач для текущего пользователя
function get_tasks_byUser($user_id, $con) {
    $sql =
        "SELECT t.title, t.created_at, t.deadline_at, t.status, t.file_url, p.name AS project_name FROM task t ".
        "JOIN user u ON t.user_id = u.id ".
        "JOIN project p ON t.project_id = p.id ".
        "WHERE t.user_id = ?";
    $values = [$user_id];
    $tasks = db_fetch_data($con, $sql, $values);
    return $tasks;
};

// Получение задач для текущего проекта
function get_tasks_byProject($project_id, $con) {
    $sql =
        "SELECT t.title, t.created_at, t.deadline_at, t.status, t.file_url, p.id AS project_id, p.name AS project_name FROM task t ".
        "JOIN user u ON t.user_id = u.id ".
        "JOIN project p ON t.project_id = p.id ".
        "WHERE project_id = ?";
    $values = [$project_id];
    $tasks = db_fetch_data($con, $sql, $values);
    return $tasks;
};

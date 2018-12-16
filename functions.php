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
function filter_tags(string $str = null): string {
    return $str === null ? '' : strip_tags($str);
};

// Выделение задач, до даты выполнения которых осталось менее 24 часов
function almost_elapsed($elapse_date = null): bool {
    $deadline = strtotime($elapse_date);
    $now = time();
    $diff = $deadline - $now;
    if ($diff <= 86400 && !empty($elapse_date)) {
        return true;
    }
    return false;
};

function get_connection(array $database_config) {
    $con = mysqli_connect($database_config['host'], $database_config['user'], $database_config['password'], $database_config['database']);
    if (!$con) {
        $err = mysqli_connect_error();
        die(include_template('error.php', ['error' => $err]));
    }
    mysqli_set_charset($con, 'utf8');
    return $con;
};

// Получение проекта по ID
function get_project_by_id(int $project_id, $con): array {
    $sql =
        'SELECT id AS project_id, name FROM project '.
        'WHERE id = ?';
    $values = [$project_id];
    $projects = db_fetch_data($con, $sql, $values);
    return $projects ? $projects[0] : [];
};

function get_projects_by_user_id(int $user_id, $con): array {
    $sql =
        'SELECT p.id, p.name, COUNT(t.id) AS task_amount FROM project p '.
        'JOIN user u ON p.user_id = u.id '.
        'LEFT JOIN task t ON p.id = t.project_id '.
        'WHERE p.user_id = ? GROUP BY p.id '.
        'ORDER BY p.name';
    $values = [$user_id];
    return db_fetch_data($con, $sql, $values);
};

function get_tasks_by_user_id(int $user_id, $con): array {
    $sql =
        'SELECT t.title, t.created_at, t.deadline_at, t.status, t.file_url, p.name AS project_name FROM task t '.
        'JOIN user u ON t.user_id = u.id '.
        'JOIN project p ON t.project_id = p.id '.
        'WHERE t.user_id = ?';
    $values = [$user_id];
    return db_fetch_data($con, $sql, $values);
};

function get_tasks_by_project_id(int $project_id, $con): array {
    $sql =
        'SELECT t.title, t.created_at, t.deadline_at, t.status, t.file_url, p.id AS project_id, p.name AS project_name FROM task t '.
        'JOIN user u ON t.user_id = u.id '.
        'JOIN project p ON t.project_id = p.id '.
        'WHERE project_id = ?';
    $values = [$project_id];
    return db_fetch_data($con, $sql, $values);
};

function get_project_url(int $project_id): string {
    $data = ['project_id' => $project_id];
    $scriptname = 'index.php';
    $query = http_build_query($data);
    $url = '/' . $scriptname . '?' . $query;
    return $url;
};

function add_task($con, array $task) {
    $sql =
        'INSERT INTO task (title, deadline_at, file_url, project_id, created_at)
        VALUES (?, ?, ?, ?, NOW())';
    $values = [
        $task['title'],
        $task['deadline_at'],
        $task['file_url'],
        $task['project_id']
    ];
    $stmt = db_get_prepare_stmt($con, $sql, $values);
    mysqli_stmt_execute($stmt);
};

function is_valid_date(string $date, $format = 'Y-m-d'): bool {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
};

function is_project_exists($con, int $project_id): bool {
    $project = get_project_by_id($project_id, $con);
    if ($project = null) {
        return false;
    }
    return true;
};

function add_user($con, array $user) {
    $sql =
        'INSERT INTO user (email, name, password, created_at) 
        VALUES (?, ?, ?, NOW())';
    $values = [
        $user['email'],
        $user['name'],
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT)
    ];
    $stmt = db_get_prepare_stmt($con, $sql, $values);
    mysqli_stmt_execute($stmt);
};

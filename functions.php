<?php

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
function filter_tags(?string $str): string {
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

// Проверка подключения к БД и установка кодировки
function get_connection($con) {
    if (!$con) {
        $err = mysqli_connect_error();
        $content = include_template('error.php', ['error' => $err]);
        $layout = include_template('layout.php', ['content' => $content]);
        print($layout);
        die();
    }
    mysqli_set_charset($con, 'utf8');
};

// Получение списка проектов для текущего пользователя
function get_projects($con, $user): array {
    $sql =
        'SELECT p.id, p.name, COUNT(t.id) AS task_amount FROM project p '.
        'LEFT JOIN task t ON p.id = t.project_id '.
        'WHERE p.user_id = 1 GROUP BY p.id';

    $res = mysqli_query($con, $sql);

    if (!$res) {
        $err = mysqli_error($con);
        print('Ошибка получения списка проектов: ' . $err);
    }
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
};

// Получение списка задач для текущего пользователя
//function get_tasks($con, $user): array {
//    $sql =
//        'SELECT status, title, file_url, deadline_at FROM tasks t' .
//        'WHERE user_id = 1 '.
//        'ORDER BY created_at';
//
//    $res = mysqli_query($con, $sql);
//
//    if (!$res) {
//        $err = mysqli_error($con);
//        print('Ошибка получения списка задач: ' . $err);
//    }
//    return mysqli_fetch_all($res, MYSQLI_ASSOC);
//};

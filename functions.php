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

// Подсчет задач для каждой категории
function task_count(array $task_list, string $project_name): int {
    $task_amount = 0;
    foreach ($task_list as $task) {
        if ($task['project'] === $project_name) {
          $task_amount++;
        }
    }
    return $task_amount;
};

// Защита от XSS-атак
function filter_tags(string $str): string {
    return strip_tags($str);
}

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
function check_connection($con) {
    if (!$con) {
        $err = mysqli_connect_error();
        print('Ошибка подключения к БД: ' . $err);
        //include_template('error.php', ['error' => $err]);
    }
    mysqli_set_charset($con, 'utf8');
};


// Получение списка проектов для текущего пользователя
function get_projects($con, $user): array {
    $sql = 'SELECT `id`, `name` FROM `project` WHERE `user_id` =' . $user;
    $res = mysqli_query($con, $sql);
    if (!$res) {
        $err = mysqli_error($con);
        print('Ошибка получения списка проектов: ' . $err);
    }
    return $projects =  mysqli_fetch_all($res,MYSQLI_ASSOC);
};


// Получение списка задач для текущего пользователя
function get_tasks($con, int $user): array {
    $sql = 'SELECT `status`, `title`, `file_url`, `deadline_at` FROM `task` WHERE `user_id` =' . $user;
    $res = mysqli_query($con, $sql);
    if (!$res) {
        $err = mysqli_error($con);
        print('Ошибка получения списка проектов: ' . $err);
    }
    return $tasks = mysqli_fetch_all($res,MYSQLI_ASSOC);
};

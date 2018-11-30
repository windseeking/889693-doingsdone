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
    foreach ($task_list as $property => $value) {
        if ($value['category'] === $project_name) {
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

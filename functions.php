<?php

// Шаблонизатор
function include_template($name, $data) {
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
function task_count($task_list, $project_name) {
  $task_amount = 0;
  foreach ($task_list as $property => $value) {
    if ($value['category'] === $project_name) {
      $task_amount++;
    }
  }
  return $task_amount;
};

// Защита от XSS-атак
function filter_tags($str) {
    $text = strip_tags($str);
    return $text;
}

// Выделение задач, до даты выполнения которых осталось менее 24 часов
function almost_elapsed($elapse_date) {
  if ($elapse_date != '') {
      $deadline = strtotime($elapse_date);
      $now = time();
      $diff = $deadline - $now;
      if ($diff <= 86400) {
          echo 'task--important';
      }
  }
}





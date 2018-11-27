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

// Фильтр данных для защиты от XSS-атак

function tags_filter($str) {
  $text = strip_tags($str);
  return $text;
};

function filter_data($list_tasks, $filterKey) {
    foreach ($list_tasks as $key => $task) {
        $list_tasks[$key][$filterKey] = strip_tags($task[$filterKey]);
    }
    return $list_tasks;
}


?>



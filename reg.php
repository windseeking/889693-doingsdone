<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('functions.php');
require_once('config.php');


$con = get_connection($database_config);
$user = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $required = ['email', 'password', 'name'];

    foreach ($required as $value) {
        if (empty($user[$value])) {
            $errors[$value] = 'Это поле нужно заполнить';
        } elseif (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введите корректный email';
        }

        if (empty($errors)) {
            add_user($con, $user);
            header('Location: index.php');
            die();
        }
        $page_content = include_template('reg.php', ['user' => $user, 'errors' => $errors]);
    }
}
else {
    $page_content = include_template('reg.php', ['user' => $user, 'errors' => $errors]);
}

$side_content = include_template('reg_side_content.php', []);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'side_content' => $side_content,
    'title' => 'Регистрация'

]);

print($layout_content);

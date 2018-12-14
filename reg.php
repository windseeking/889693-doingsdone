<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('functions.php');
require_once('config.php');

$con = get_connection($database_config);
$user = $_POST;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST;
    $required = ['email', 'password', 'name'];
    $errors = [];
        if (empty($user['email'])) {
            $errors['email'] = 'Введите email';
        }
        elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введен некорректный e-mail';
        }
        if (empty($user['password'])) {
            $errors['password'] = 'Введите пароль';
        }
        if (empty($user['name'])) {
            $errors['name'] = 'Введите имя';
        }
    if (count($errors)) {
        $page_content = include_template('reg.php', ['user' => $user, 'errors' => $errors]);
    }
    else {
        add_user($con, $user['email'], $user['password'], $user['name']);
        header('Location: index.php');
        die();
    }
}
else {
    $page_content = include_template('reg.php', ['user' => $user]);
}

$side_content = include_template('reg_side_content.php', []);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'side_content' => $side_content,
    'title' => 'Регистрация'
]);

print($layout_content);

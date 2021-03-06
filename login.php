<?php
date_default_timezone_set("Europe/Moscow");

require_once("functions.php");
require_once("DB_connection.php");

$categories = get_categories($link);

session_start();

if (isset($_SESSION['user'])) {
    header('Location:index.php');
}

$errors = [];
$user = [];
$db_user = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {git checkout master

    /// validate email
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = 'Заполните это поле';
    } else {
        $user['email'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if ($user['email'] === false) {
            $errors['email'] = 'Поле заполнено не корректно';
            $user['email'] = $_POST['email'];
        } else {
            $user['email'] = $_POST['email'];
        }
    }

    // validate password
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = 'Заполните это поле';
    } else {
        $user['password'] = $_POST['password'];
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($link, $_POST['email']);
        $sql_user = "SELECT * FROM users WHERE email='$email'";
        $SQL_result = mysqli_query($link, $sql_user);

        if ($SQL_result) {
            $users = mysqli_fetch_all($SQL_result, MYSQLI_ASSOC);
            if (!empty($users)) {
                $db_user = $users[0];
            } else {
                $errors['wrong_pass'] = 'Вы вели неверный email/пароль';
            }
        }
    }

    if (empty($errors)) {
        if (password_verify($user['password'], $db_user['password'])) {
            $_SESSION['user'] = $db_user;
            header('Location:index.php');
        }
    }
}

$page_content = include_template('login.php', [
    'categories' => $categories,
    'errors' => $errors,
    'user' => $user
]);

$layout_content = include_template("layout.php", [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Логин'
]);
print($layout_content);

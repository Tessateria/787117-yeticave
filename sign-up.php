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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // validate email
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = 'Заполните это поле';
    } else {
        $user['email'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if ($user['email'] === false) {
            $errors['email'] = 'Поле заполнено не корректно';
            $user['email'] = $_POST['email'];
        } else {
            $email = mysqli_real_escape_string($link, $_POST['email']);
            $sql_user = "SELECT * FROM users WHERE email='$email'";
            $SQLresult = mysqli_query($link, $sql_user);

            if ($SQLresult) {
                $users = mysqli_fetch_all($SQLresult, MYSQLI_ASSOC);
                if (!empty($users)) {
                    $errors['email'] = 'Пользователь с таким Email уже существует';
                    $user['email'] = $_POST['email'];
                }
            } else {
                echo "Не удалось получить информацию с БД";
            }
        }
    }

    // validate password
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = 'Заполните это поле';
    } else {
        $user['password'] = $_POST['password'];
    }

    // validate name
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $errors['name'] = 'Заполните это поле';
    } else {
        $user['name'] = $_POST['name'];
        $sql_user = "SELECT * FROM users WHERE username='" . $user['name'] . "'";
        $SQLresult = mysqli_query($link, $sql_user);

        if ($SQLresult) {
            $users = mysqli_fetch_all($SQLresult, MYSQLI_ASSOC);
            if (!empty($users)) {
                $errors['name'] = 'Пользователь с таким именем уже существует';
            }
        } else {
            echo "Не удалось получить информацию с БД";
        }
    }

    // validate message
    if (!isset($_POST['message']) || empty($_POST['message'])) {
        $errors['message'] = 'Заполните это поле';
    } else {
        $user['message'] = $_POST['message'];
    }

    // validate image
    if (isset($_FILES['user_image']['name']) && !empty($_FILES['user_image']['name'])) {
        $tmp_name = $_FILES['user_image']['tmp_name'];
        $path = uniqid() . '.jpeg';

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg") {
            $errors['user_image'] = 'Загрузите картинку в формате JPEG';
        }

        if (empty($errors)) {
            move_uploaded_file($tmp_name, 'avatars/' . $path);
            $user['image_path'] = 'avatars/' . $path;
        }
    }

    if (empty($errors)) {
        $sql_add = "INSERT INTO users
SET email = '" . $user['email'] . "',
	username = '" . $user['name'] . "',
	password = '" . password_hash($user['password'], PASSWORD_DEFAULT) . "',
	avatar = '" . $user['image_path'] . "',
	contacts ='" . $user['message'] . "'";
        mysqli_query($link, $sql_add);
        header("Location:login.php");

//    $password = password_hash($user['password'], PASSWORD_DEFAULT);
//    $sql_user = "INSERT INTO users (email, username, password, avatar, contacts) VALUES (?, ?, ?, ?, ?)";
//    $stmt = db_get_prepare_stmt($link, $sql_user, [$user['email'], $user['username'], $password, $user['image_path'], $user['contacts']]);
//    $res = mysqli_stmt_execute($stmt);
//    header("Location:login.php");

    }

}

$page_content = include_template('sign-up.php', [
    'categories' => $categories,
    'errors' => $errors,
    'user' => $user
]);

$layout_content = include_template("layout.php", [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Регистрация'
]);
print($layout_content);


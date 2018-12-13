<?php
date_default_timezone_set("Europe/Moscow");

require_once("functions.php");
require_once("DB_connection.php");


$categories = get_categories($link);

session_start();
$user = [];

if (isset($_SESSION['user'])) {
    $user['name'] = $_SESSION['user']['username'];
    $user['avatar'] = $_SESSION['user']['avatar'];
    $user['id'] = $_SESSION['user']['id'];
} else {
    header("Location:login.php");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lot = $_POST['lot'];

    $required = ['lot_name', 'category_id', 'specification', 'start_price', 'step_up_value', 'date_finish'];

    $errors = [];

    foreach ($required as $key) {
        if (empty($lot[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    //Validation step_up_value
    $lot["step_up_value"] = filter_var($lot["step_up_value"], FILTER_VALIDATE_INT);
    if ($lot["step_up_value"] === false) {
        $errors['step_up_value'] = 'В этом поле впишите число';
    }
    if ($lot["step_up_value"] <= 0) {
        $errors['step_up_value'] = "Cтавка должна быть больше нуля";
    }
    if (empty($lot["step_up_value"])) {
        $errors['step_up_value'] = "Введите шаг ставки";
    }

    //Validation start_prise
    $lot["start_price"] = filter_var($lot["start_price"], FILTER_VALIDATE_FLOAT);
    if ($lot["start_price"] === false) {
        $errors['start_price'] = 'В этом поле впишите число';
    }

    if ($lot["start_price"] <= 0) {
        $errors['start_price'] = "Цена должна быть больше нуля";
    }

    if (empty($lot["start_price"])) {
        $errors['start_price'] = "Введите начальную цену";
    }

    if (!intval($lot['category_id'])) {
        $errors['category_id'] = 'Это поле надо заполнить';
    }

    //Validation date_finish
    $date_fin = $lot['date_finish'];
    $change_date_fin = date("Y-m-d H:i:s", strtotime($date_fin));

    if (isset($date_fin)) {
        if (strtotime($date_fin) <= strtotime("now")) {
            $errors ['date_finish'] = "Дата завершения не раньше завтра";
        }
    }

    //Validation image
    if (isset($_FILES['lot_image']['name']) && !empty($_FILES['lot_image']['name'])) {
        $tmp_name = $_FILES['lot_image']['tmp_name'];
        $path = uniqid() . '.jpeg';

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type === "image/jpeg" || $file_type === "image/png") {
            move_uploaded_file($tmp_name, 'img/' . $path);
            $lot['path'] = $path;
        } else {
            $errors['lot_image'] = 'Загрузите картинку в формате JPEG или PNG';
        }
    } else {
        $errors['lot_image'] = 'Вы не загрузили файл';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', [
            'lot_image' => $lot_image,
            'errors' => $errors,
            'categories' => $categories,
            'lot' => $lot
        ]);
    } else {
        $sql_add = "INSERT INTO lots (lot_name, specification, image, start_price, step_up_value, author_id, category_id, date_finish) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?) ";
        $sql_pre = db_get_prepare_stmt($link, $sql_add, [$lot['lot_name'], $lot['specification'], 'img/' . $path, $lot['start_price'], $lot['step_up_value'], $user['id'], $lot['category_id'], $change_date_fin]);
        $res = mysqli_stmt_execute($sql_pre);

        $id = mysqli_insert_id($link);
        header("Location:lot.php?id=$id");
    }
} else {
    $page_content = include_template('add.php', [
        'categories' => $categories
    ]);

}
$layout_content = include_template("layout.php", [
    'page_content' => $page_content,
    'categories' => $categories,
    'user' => $user,
    'title' => 'Добавление лота'
]);
print($layout_content);

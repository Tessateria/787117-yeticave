<?php
date_default_timezone_set("Europe/Moscow");

require_once("functions.php");
require_once("DB_connection.php");

if (!$link) {
    $error = mysqli_connect_error();
    echo "Не удалось подключиться к MySQL";
} else {
    $sql_cat = "SELECT * FROM categories";
    $result_c = mysqli_query($link, $sql_cat);

    if ($result_c) {
        $categories = mysqli_fetch_all($result_c, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($link);
        echo "Не удалось получить информацию с БД";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lot = $_POST['lot'];

    $required = ['lot_name', 'category_id', 'specification', 'start_price', 'step_up_value', 'date_finish'];
    $dict = ['lot_name' => 'Название',
        'category_id' => 'Категория',
        'specification' => 'Описание',
        'lot_image' => 'Изображение',
        'start_price' => 'Цена',
        'step_up_value' => 'Ставка',
        'date_finish' => 'Финал'];

    $errors = [];

    foreach ($required as $key) {
        if (empty($lot[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }
    $lot["step_up_value"] = filter_var($lot["step_up_value"], FILTER_VALIDATE_FLOAT);
    if ($lot["step_up_value"] === false) {
        $errors['step_up_value'] = 'В этом поле впишите число';
    }

    $lot["start_price"] = filter_var($lot["start_price"], FILTER_VALIDATE_FLOAT);
    if ($lot["start_price"] === false) {
        $errors['step_up_value'] = 'В этом поле впишите число';
    }
    if (!intval($lot['category_id'])){
        $errors['category_id'] = 'Это поле надо заполнить';
    }

    if (isset($_FILES['lot_image']['name']) && !empty($_FILES['lot_image']['name'])) {
        $tmp_name = $_FILES['lot_image']['tmp_name'];
        $path = uniqid() . '.jpeg';

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg") {
            $errors['lot_image'] = 'Загрузите картинку в формате JPEG';
        } else {
            move_uploaded_file($tmp_name, 'img/' . $path);
            $lot['path'] = $path;
        }
    } else {
        $errors['lot_image'] = 'Вы не загрузили файл';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', [
            'lot_image' => $lot_image,
            'errors' => $errors,
            'dict' => $dict,
            'categories' => $categories,
            'lot' => $lot
        ]);
    } else {
        $sql_add = "INSERT INTO lots
SET lot_name = '" . $lot['lot_name'] . "',
	specification = '" . $lot['specification'] . "',
	image = 'img/" . $path . "',
	start_price = " . $lot['start_price'] . ",
	step_up_value = " . $lot['step_up_value'] . ",
	author_id = 2,
	category_id = " . $lot['category_id'] . ",
	date_finish = '" . date("Y-m-d H:i:s", strtotime($lot['date_finish'])) . "'";
        mysqli_query($link, $sql_add);
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
    'title' => $title
]);
print($layout_content);

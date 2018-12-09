<?php
date_default_timezone_set("Europe/Moscow");

require_once ("functions.php");
require_once ("DB_connection.php");

if (!$link)
{
    $error = mysqli_connect_error();
    echo "Не удалось подключиться к MySQL";
} else {
    $sql_cat = "SELECT * FROM categories";
    $result_c = mysqli_query($link, $sql_cat);

    if ($result_c)
    {
        $categories = mysqli_fetch_all($result_c, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($link);
        echo "Не удалось получить информацию с БД";
    }
}

//$page_content = include_template('add.php', [
//    'categories' => $categories
//    ]);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lot = $_POST;

    $required = ['lot_name', 'category_id', 'specification', 'lot_image', 'stert_price', 'step_up_value', 'date_finish'];
    $dict = ['lot_name' => 'Название',
        'category_id' => 'Категория',
        'specification' => 'Описание',
        'lot_image' => 'Изображение',
        'stert_price' => 'Цена',
        'step_up_value' => 'Ставка',
        'date_finish' => 'Финал'];

    $errors = [];
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    if (isset($_FILES['lot_image']['name'])) {
        $tmp_name = $_FILES['lot_image']['tmp_name'];
        $path = $_FILES['lot_image'][name];

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
            'categories' => $categories
        ]);
    } else {
        $page_content = include_template('lot.php', [
            'lot_image' => $lot_image
        ]);
    }
}
else {
    $page_content = include_template('add.php', [
        'categories' => $categories
    ]);

}
$lot["step_up_value"] = filter_var($lot["step_up_value"], FILTER_VALIDATE_FLOAT);

$id = mysqli_insert_id($link);
header("Location:lot.php?id=".$id);
//echo '<pre>';
//var_dump($lots);
//echo '</pre>';
//
$layout_content = include_template("layout.php", [
'page_content' => $page_content,
//    'user_name' => $user_name,
//    'is_auth' => $is_auth,
//    'user_avatar' => $user_avatar,
    'categories' => $categories,
    'title' => $title
]);
print($layout_content);

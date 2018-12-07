<?php
date_default_timezone_set("Europe/Moscow");

$is_auth = rand(0, 1);
$user_name = 'Наталья';
$title = 'Главная';
$user_avatar = 'img/user.jpg';

require_once ("functions.php");
require_once ("DB_connection.php");

if (!$link) {
    $error = mysqli_connect_error();
    echo "Не удалось подключиться к MySQL";
}
else {
    $sql_cat = "SELECT * FROM categories";
    $result_c = mysqli_query($link, $sql_cat);

    if ($result_c ) {
        $categories = mysqli_fetch_all($result_c, MYSQLI_ASSOC);
        }
    else {
        $error = mysqli_error($link);
        echo "Не удалось получить информацию с БД";
    }

    $page_content = include_template("404.php", [
        'categories' => $categories
    ]);

    if (isset($_GET['id'])) {
        $lot_id = intval($_GET['id']);
        $sql_lot = "SELECT l.lot_name, l.specification, l.image, l.start_price, l.step_up_value, r.cost AS cost FROM lots l
INNER JOIN categories ON l.category_id=categories.id
LEFT OUTER JOIN rates r ON l.id = r.lot_id
WHERE l.id=$lot_id
ORDER BY date_add DESC LIMIT 1";

        $result_l = mysqli_query($link, $sql_lot);


        if ($result_l) {
            $lot_info = mysqli_fetch_all($result_l, MYSQLI_ASSOC);

            if (!empty($lot_info)) {
                $lot_info = check_lots_cost($lot_info);
                $page_content = include_template('lot.php', [
                    'categories' => $categories,
                    'lot_info' => $lot_info,
                    'time_to_midnight' => time_to_midnight()
                ]);
            }
        }
    }

    $layout_content = include_template("layout.php", [
        'page_content' => $page_content,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'user_avatar' => $user_avatar,
        'categories' => $categories,
        'title' => $title
    ]);

    print($layout_content);
}




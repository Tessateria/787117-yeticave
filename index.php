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


    $sql_lot = "SELECT l.id, l.lot_name, l.start_price, l.image, l.date_finish, c.category AS category, MAX(r.cost) AS cost
FROM lots l
LEFT OUTER JOIN categories c ON l.category_id=c.id
LEFT OUTER JOIN rates r ON l.id = r.lot_id
GROUP BY l.id
ORDER BY date_create DESC";
    $result_l = mysqli_query($link, $sql_lot);


    if ($result_c and $result_l) {
        $categories = mysqli_fetch_all($result_c, MYSQLI_ASSOC);

        $advertisement = mysqli_fetch_all($result_l, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        echo "Не удалось получить информацию с БД";
    }
}
$advertisement = check_lots_cost($advertisement);

foreach ($advertisement as $key => $lot) {
    $advertisement[$key]['time_to_end'] = time_to_midnight($lot['date_finish']);
}


$page_content = include_template('index.php', [
    'advertisement' => $advertisement,
    'categories' => $categories

]);

$layout_content = include_template("layout.php", [
    'page_content' => $page_content,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'user_avatar' => $user_avatar,
    'categories' => $categories,
    'title' => $title
]);
print($layout_content);


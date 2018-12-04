<?php
date_default_timezone_set("Europe/Moscow");
$is_auth = rand(0, 1);

$user_name = 'Наталья';
$title = 'Главная';
$user_avatar = 'img/user.jpg';


    require_once ("functions.php");


$link = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($link, "utf8");

if (!$link) {
    $error = mysqli_connect_error();
    echo "Не удалось подключиться к MySQL";
}
else {
    $sql_cat = "SELECT * FROM categories";
    $result_c = mysqli_query($link, $sql_cat);


    $sql_lot = "SELECT l.id, l.lot_name, l.start_price, l.image, c.category AS category, MAX(r.cost) AS cost
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

$page_content = include_template('index.php', [
    'advertisement' => $advertisement,
    'categories' => $categories,
    'time_to_midnight' => time_to_midnight()

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


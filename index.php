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
}

$sql_lot = "SELECT l.id, l.lot_name, l.start_price, l.image, l.date_finish, c.category AS category, MAX(r.cost) AS cost
    FROM lots l
    LEFT OUTER JOIN categories c ON l.category_id=c.id
    LEFT OUTER JOIN rates r ON l.id = r.lot_id
    GROUP BY l.id
    ORDER BY date_create DESC";
$result_l = mysqli_query($link, $sql_lot);

if ($result_l) {
    $lots = mysqli_fetch_all($result_l, MYSQLI_ASSOC);
} else {
    echo "Не удалось получить информацию с БД";
}

$lots = check_lots_cost($lots);

foreach ($lots as $key => $lot) {
    $lots[$key]['time_to_end'] = time_to_midnight($lot['date_finish']);
}


$page_content = include_template('index.php', [
    'lots' => $lots,
    'categories' => $categories

]);

$layout_content = include_template("layout.php", [
    'page_content' => $page_content,
    'user' => $user,
    'categories' => $categories,
    'title' => 'Главная'
]);
print($layout_content);


<?php
date_default_timezone_set("Europe/Moscow");

require_once("functions.php");
require_once("DB_connection.php");

$categories = get_categories($link);

session_start();
$user = [];
$errors = [];

if (isset($_SESSION['user'])) {
    $user['name'] = $_SESSION['user']['username'];
    $user['avatar'] = $_SESSION['user']['avatar'];
    $user['id'] = $_SESSION['user']['id'];
}

$page_content = include_template("404.php", [
    'categories' => $categories
]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cost = intval($_POST['cost']);
    $lot_id = intval($_GET['id']);
    $sql_lot = "SELECT l.lot_name, l.specification, l.image, l.start_price, l.step_up_value, l.date_finish, c.category, r.cost AS cost FROM lots l
INNER JOIN categories c ON l.category_id=c.id
LEFT OUTER JOIN rates r ON l.id = r.lot_id
WHERE l.id=$lot_id
ORDER BY date_add DESC LIMIT 1";
    $result_l = mysqli_query($link, $sql_lot);
    $lot_info = mysqli_fetch_array($result_l, MYSQLI_ASSOC);

    if (intval($lot_info['cost'] + $lot_info['step_up_value']) > $cost) {
        $errors['cost'] = 'Ставка должна быть больше';
    }

    if (empty($errors)) {
        $sql_add = "INSERT INTO rates (cost, user_id, lot_id) 
VALUES (?, ?, ?) ";
        $sql_pre = db_get_prepare_stmt($link, $sql_add, [$cost, $user['id'], $lot_id]);
        $res = mysqli_stmt_execute($sql_pre);
        header('Location:lot.php?id=' . $lot_id);
    }
}

if (isset($_GET['id'])) {
    $lot_id = intval($_GET['id']);
    $sql_lot = "SELECT l.lot_name, l.specification, l.image, l.start_price, l.step_up_value, l.date_finish, c.category, r.cost AS cost FROM lots l
INNER JOIN categories c ON l.category_id=c.id
LEFT OUTER JOIN rates r ON l.id = r.lot_id
WHERE l.id=$lot_id
ORDER BY date_add DESC LIMIT 1";

    $result_l = mysqli_query($link, $sql_lot);

    if ($result_l) {
        $lot_info = mysqli_fetch_all($result_l, MYSQLI_ASSOC);

        if (!empty($lot_info)) {
            $lot_info[0]['min_rate'] = $lot_info[0]['cost'] + $lot_info[0]['step_up_value'];
            $lot_info[0]['min_rate'] = number_format($lot_info[0]['min_rate'], $decimals = 0, $dec_point = ".", $thousands_sep = " ");
            $sql_rates = "SELECT date_add, cost, u.username FROM rates
JOIN users u ON rates.user_id=u.id
WHERE lot_id=$lot_id
ORDER BY date_add DESC";
            $result_rates = mysqli_query($link, $sql_rates);
            $rates = mysqli_fetch_all($result_rates, MYSQLI_ASSOC);
            foreach ($rates as $key => $rate) {
                $rates[$key] = format_rate($rate);
            }
            $lot_info = check_lots_cost($lot_info);
            $lot_info[0]['rates'] = $rates;
            $page_content = include_template('lot.php', [
                'categories' => $categories,
                'user' => $user,
                'errors' => $errors,
                'cost_try' => $cost,
                'lot_info' => $lot_info[0],
                'time_to_midnight' => time_to_midnight($lot_info[0]['date_finish'])
            ]);
        }
    }
}

$layout_content = include_template("layout.php", [
    'page_content' => $page_content,
    'user' => $user,
    'categories' => $categories,
    'title' => $lot_info[0]['lot_name']
]);

print($layout_content);

<?php
function include_template($name, $data)
{
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function number_form_rub($arg)
{
    $num = number_format($arg, $decimals = 0, $dec_point = ".", $thousands_sep = " ");
    return $num . " <b class=\"rub\">р</b>";
}

function xss($arg)
{
    $text = strip_tags($arg);
    return $text;
}
function time_to_midnight ($end_date)
{
    $time_now = date_create();
    $time_end = date_create($end_date);
    $diff = date_diff($time_end, $time_now);
    $days = date_interval_format($diff, '%D');
    $hours = date_interval_format($diff, '%H');
    $minutes = date_interval_format($diff, '%I');
    return ($days * 24 + $hours).':'.$minutes;
}

function check_lots_cost($arr)
{
    foreach ($arr as $key => $lot) {
        if (is_null($lot['cost'])) {
            $lot['cost'] = $lot['start_price'];
            $arr[$key] = $lot;
        }
    }
    return $arr;
}

function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

function debug($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function get_categories($link)
{
    $sql_cat = "SELECT * FROM categories";
    $result_c = mysqli_query($link, $sql_cat);

    if ($result_c) {
        return mysqli_fetch_all($result_c, MYSQLI_ASSOC);
    } else {
        echo "Не удалось получить информацию с БД";
    }
}

function format_rate($rate)
{
    $rate['cost'] = number_format($rate['cost'], $decimals = 0, $dec_point = ".", $thousands_sep = " ");
    $time_now = date_create();
    $time_add = date_create($rate['date_add']);
    $time_string = '';

    $diff = date_diff($time_now, $time_add);
    $hours = date_interval_format($diff, '%H');
    $minutes = date_interval_format($diff, '%I');

    $check_minutes = $hours * 60 + $minutes;
    if ($check_minutes == 60) {
        $time_string = '1 час назад';
    } elseif ($check_minutes < 60) {
        $time_string = $check_minutes.' минут назад';
    } else {
        $time_string = date_format($time_add, "d.m.y в H:i");
    }

    $rate['date_add'] = $time_string;
    return $rate;
}

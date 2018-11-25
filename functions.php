<?php
function include_template($name, $data) {
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
function number_form_rub ($arg){
    $num = number_format($arg, $decimals = 0, $dec_point=".", $thousands_sep = " ");
    return $num . " <b class=\"rub\">р</b>";
}
function xss ($arg){
    $text = strip_tags($arg);
    return $text;
}
function time_to_midnight (){
    $time_now = date_create();
    $time_end = date_create('tomorrow');
    $diff = date_diff($time_end, $time_now);
    $date_modified = date_interval_format($diff, '%H:%I');
    return $date_modified;
}

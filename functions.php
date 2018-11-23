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

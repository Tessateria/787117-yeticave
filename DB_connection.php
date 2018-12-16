<?php
$link = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($link, "utf8");
if (!$link) {
    $error = mysqli_connect_error();
    die("Не удалось подключиться к MySQL");
}

<?php
$is_auth = rand(0, 1);

$user_name = 'Наталья';
$title = 'Главная';
$user_avatar = 'img/user.jpg';
$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
$advertisement = [
    0 => ["name" => "2014 Rossignol District Snowboard",
          "categor" => "Доски и лыжи",
          "price" => 10999,
          "picture_url" => "img/lot-1.jpg"],

    1 => ["name" => "DC Ply Mens 2016/2017 Snowboard",
         "categor" => "Доски и лыжи",
         "price" => 159999,
         "picture_url" => "img/lot-2.jpg"],
    2 => ["name" => "Крепления Union Contact Pro 2015 года размер L/XL",
         "categor" => "Крепления",
         "price" => 8000,
         "picture_url" => "img/lot-3.jpg"],
    3 => ["name" => "Ботинки для сноуборда DC Mutiny Charocal",
         "categor" => "Ботинки",
         "price" => 10999,
         "picture_url" => "img/lot-4.jpg"],
    4 => ["name" => "Куртка для сноуборда DC Mutiny Charocal",
         "categor" => "Одежда",
         "price" => 7500,
         "picture_url" => "img/lot-5.jpg"],
    5 => ["name" => "Маска Oakley Canopy",
         "categor" => "Разное",
         "price" => 5400,
         "picture_url" => "img/lot-6.jpg"]
];

require_once ("functions.php");

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


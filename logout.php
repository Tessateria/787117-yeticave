<?php
date_default_timezone_set("Europe/Moscow");

session_start();

session_destroy();
header('Location:index.php');

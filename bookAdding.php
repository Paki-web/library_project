<?php
include 'includes/class-autoloader.inc.php';
session_start();
$queries = new MySQLQuery;
$queries->checkAdminStatus();
$name_book = filter_input(INPUT_POST, 'name_book');
$name_author = filter_input(INPUT_POST, 'name_author');
$name_category = filter_input(INPUT_POST, 'name_category');
$pub = filter_input(INPUT_POST, 'pub');
$num = filter_input(INPUT_POST, 'num');
$_SESSION['logged_admin']->addBook($name_book, $name_author, $name_category, $pub, $num);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>done</p>
    <a href="addBook.php">Wroc</a>
</body>
</html>
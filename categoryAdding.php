<?php
include 'includes/class-autoloader.inc.php';
session_start();
$queries = new MySQLQuery;
$queries->checkAdminStatus();
$_SESSION['logged_admin']->addCategory(filter_input(INPUT_POST, 'name_category'));
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
    <a href="addCategory.php">Wroc</a>
</body>
</html>
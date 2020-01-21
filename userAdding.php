<?php
include 'includes/class-autoloader.inc.php';
session_start();
$queries = new MySQLQuery;
$queries->checkAdminStatus();
$_SESSION['logged_admin']->addUser(filter_input(INPUT_POST, 'user_firstname'), filter_input(INPUT_POST, 'user_lastname'), filter_input(INPUT_POST, 'user_login'), filter_input(INPUT_POST, 'user_pass'), filter_input(INPUT_POST, 'user_pesel'));
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
    <a href="addUser.php">Wroc</a>
</body>
</html>
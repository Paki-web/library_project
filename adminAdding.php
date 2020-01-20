<?php
include 'includes/class-autoloader.inc.php';
session_start();
$queries = new MySQLQuery;
$queries->checkAdminStatus();
$_SESSION['logged_admin']->addAdmin(filter_input(INPUT_POST, 'admin_firstname'), filter_input(INPUT_POST, 'admin_lastname'), filter_input(INPUT_POST, 'admin_login'), filter_input(INPUT_POST, 'admin_pass'), filter_input(INPUT_POST, 'admin_pesel'));
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
    <a href="addAdmin.php">Wroc</a>
</body>
</html>
<?php
session_start();
include 'includes/class-autoloader.inc.php';
$queries = new MySQLQuery;
$queries->checkIndexStatus();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald:400,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
</head>

<body>
    <div class="wrapper">
        <header class="main">
            <h1>System biblioteki</h1>
        </header>
        <div class="login">
            <h2>Zaloguj jako</h2>
            <div class="mode">
                <a href="userlog.php" class="user">
                    <div><img src="../images/user.png" alt=""></div>
                    <p>Czytelnik</p>
                </a>
                <a href="adminlog.php" class="librarian">
                    <div><img src="../images/librarian.png" alt=""></div>
                    <p>Bibliotekarz</p>
                </a>
            </div>
        </div>
    </div>
    <div class="bgd"></div>
</body>

</html>
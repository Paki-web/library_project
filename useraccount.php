<?php
include 'includes/class-autoloader.inc.php';
session_start();
$queries = new MySQLQuery;
if (!isset($_SESSION['logged_user'])) {
$queries->loginUser(filter_input(INPUT_POST, 'user_login'),filter_input(INPUT_POST, 'user_pass'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/loggedstyle.css">
</head>
<body>
<div class="wrapper">
    <div class="container">
    <header class="logged">
    <div class="banner">
        <h1>System biblioteki</h1>
    </div>
    <nav>
        <ul>
            <li><a href="useraccount.php">Moje konto</a>
                <ul>
                    <li><a href="useraccount.php">Moje dane</a></li>
                    <li><a href="borrowed.php">Wypożyczone</a></li>
                    <li><a href="reservations.php">Zarezerwowane</a></li>
                </ul>
            </li>
            <li><a href="ubooks.php">Książki</a></li>
            <li><a href="">Wyszukaj</a>
            <ul>
                    <li><a href="searchByName.php">Według nazwy</a></li>
                    <li><a href="searchByAuthor.php">Według autora</a></li>
                    <li><a href="searchByCategory.php">Według gatunku</a></li>
            </ul>
            </li>
            <li><a href="logout.php">Wyloguj</a></li>
        </ul>
    </nav>
    </header>
    <section class="data">
        <div class="title">
            <h2>Twoje dane</h2>
        </div>
        <div class="information">
        <table width='1200' align='center' border='1'>
                <tr>
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Login</th>
                    <th>Hasło</th>
                    <th>Pesel</th>
                    <th>Należności</th>
                </tr>
                <tr>
                    <?php
                    $queries->showUserInfo();
                    ?>
                </tr>
            </table>
            </div>
    </section>
    </div>
</div>
<div class="bgd"></div>
</body>
</html>
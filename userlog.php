<?php
include 'includes/class-autoloader.inc.php';
session_start();
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
    <link rel="stylesheet" href="styles/main.css">
</head>

<body>
    <div class="wrapper">
        <header class="main">
            <h1>System biblioteki</h1>
        </header>
        <div class="login">
            <h2 class="usrlog">Logowanie jako użytkownik</h2>
            <form action="useraccount.php" method="post">
                <input type="text" name="user_login" placeholder="Login" <?= isset($_SESSION['given_login']) ? 'value="' . $_SESSION['given_login'] . '"' : '' ?>>
                <input type="password" name="user_pass" placeholder="Hasło">
                <button type="submit">Zaloguj</button>
                <?php
					if (isset($_SESSION['bad_attempt'])) {
						echo '<p>Niepoprawny login lub hasło!</p>';
						unset($_SESSION['bad_attempt']);
					}
					?>
            </form>
        </div>
    </div>
    <div class="bgd"></div>
</body>

</html>
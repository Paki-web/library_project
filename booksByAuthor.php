<?php
include 'includes/class-autoloader.inc.php';
session_start();
$queries = new MySQLQuery;
$queries->checkLogin();
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
    <?php
    if(isset($_SESSION['logged_user'])){
        echo "<ul>
        <li><a href='useraccount.php'>Moje konto</a>
            <ul>
                <li><a href='useraccount.php'>Moje dane</a></li>
                <li><a href='borrowed.php'>Wypożyczone</a></li>
                <li><a href='reservations.php'>Zarezerwowane</a></li>
            </ul>
        </li>
        <li><a href='ubooks.php'>Książki</a></li>
        <li><a href=''>Wyszukaj</a>
        <ul>
                <li><a href='searchByName.php'>Według nazwy</a></li>
                <li><a href='searchByAuthor.php'>Według autora</a></li>
                <li><a href='searchByCategory.php'>Według gatunku</a></li>
        </ul>
        </li>
        <li><a href='logout.php'>Wyloguj</a></li>
    </ul>";
    }else{
        echo "<ul>
            <li><a href='adminaccount.php'>Akcje</a>
                <ul>
                    <li><a href='adminaccount.php'>Moje dane</a></li>
                    <li><a href='addUser.php'>Dodaj czytelnika</a></li>
                    <li><a href='userReservations.php'>Rezerwacje</a></li>
                    <li><a href='borrow.php'>Wypozycz</a></li>
                    <li><a href='borrows.php'>Wypozyczenia</a></li>
                    <li><a href='addAdmin.php'>Dodaj admina</a></li>
                    <li><a href='adminsList.php'>Lista adminow</a></li>
                    <li><a href='usersList.php'>Lista czytelnikow</a></li>
                </ul>
            </li>
            <li><a href='abooks.php'>Książki</a>
            <ul>
                    <li><a href='addBook.php'>Dodaj ksiazke</a></li>
                    <li><a href='addAuthor.php'>Dodaj autora</a></li>
                    <li><a href='addCategory.php'>Dodaj gatunek</a></li>
                </ul>
            </li>
            </li>
            <li><a href=''>Wyszukaj</a>
            <ul>
                    <li><a href='searchByName.php'>Według nazwy</a></li>
                    <li><a href='searchByAuthor.php'>Według autora</a></li>
                    <li><a href='searchByCategory.php'>Według gatunku</a></li>
            </ul>
            </li>
            <li><a href='logout.php'>Wyloguj</a></li>
        </ul>";
    }
    ?>
    </nav>
    </header>
    <section class="data">
        <div class="title">
            <h2>Książki</h2>
        </div>
        <div class="information">
        <table width='1400' align='center' border='1'>
                <tr>
                    <th>Nazwa</th>
                    <th>Autor</th>
                    <th>Gatunek</th>
                    <th>Wydawnictwo</th>
                    <?php
                    if(isset($_SESSION['logged_user'])){
                        echo "<th>Zarezerwuj książkę</th>";
                    }else{
                        echo "<th>Usuń książkę</th>";
                    }
                    ?> 
                </tr>
                <tr>
                    <?php
                    $queries->byNameAuthor(filter_input(INPUT_POST, 'author_name'));
                    ?>
                </tr>
            </table>
            </div>
    </section>
    </div>
</div>
<div class="bgd"></div>
<script src="js/changeHeight.js"></script>
</body>
</html>
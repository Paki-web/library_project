<?php

session_start();
if($_SESSION['logged_user']){
    unset($_SESSION['logged_user']);}
else{
unset($_SESSION['logged_admin']);
}

header('Location: index.php');

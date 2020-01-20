<?php
spl_autoload_register('myAutoLoader');
function myAutoLoader($className)
{
    $extension = ".class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $className . $extension;
}

<?php

class Dbh
{
    private $host = "localhost";
    private $user = "32073864_library";
    private $password = "Project132";
    private $dbName = "32073864_library";

    protected function connect()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        $pdo = new PDO($dsn, $this->user, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}

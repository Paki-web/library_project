<?php
include_once 'abstract/Person.abstract.php';
class User extends Person{
    private $fees;

    public function __construct($id,$firstname,$lastname,$login,$pass,$pesel,$fees){
        parent::__construct($id,$firstname,$lastname,$login,$pass,$pesel);
        $this->fees=$fees;
    }

    public function getFees(){
        return $this->fees;
    }

    public function reserve($id_book){
        $sql = "SELECT num FROM books WHERE id_book = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_book]);
        $book = $stmt->fetch();

        if($book['num']<1){
            echo "<p>Brak książki!</p>";
            echo "<a href='index.php'>Wroc</a>";
            exit();
        }

        $id_user = $_SESSION['logged_user']->getId();

        $sql = "SELECT * FROM reservations WHERE id_user = ? AND id_book = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_user, $id_book]);
        $checkRepetition = $stmt->fetch();

        if($checkRepetition){
            echo "<p>Zarezerwowales juz te ksiazke!</p>";
            echo "<a href='index.php'>Wroc</a>";
            exit();
        }

        $newNum = $book['num']-1;
        $currentDate = date("y-m-d");
        $endDate = date("y-m-d", strtotime($currentDate . ' + 2 day'));
        $sql = "INSERT INTO reservations (id_user, id_book, enddate) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_user, $id_book, $endDate]);

        $sql = "UPDATE books SET num = ? WHERE id_book = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$newNum, $id_book]);
    }

    public function cancelReserve($id_res){
        $sql = "SELECT id_book FROM reservations WHERE id_reservation = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_res]);
        $book = $stmt->fetch();

        $sql = "SELECT num FROM books WHERE id_book = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$book['id_book']]);
        $num = $stmt->fetch();

        $newNum = $num['num']+1;

        $sql = "UPDATE books SET num = ? WHERE id_book = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$newNum, $book['id_book']]);

        $sql = "DELETE FROM reservations WHERE id_reservation = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_res]);
    }
}
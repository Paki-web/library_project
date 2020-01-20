<?php
include_once 'abstract/Person.abstract.php';
class Admin extends Person{
    public function addUser($firstname, $lastname, $login, $pass, $pesel){
        $sql = "INSERT INTO users (firstname, lastname, login, pass, pesel) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$firstname, $lastname, $login, $pass, $pesel]);
    }

    public function delUser($id_user){
        $sql = "DELETE FROM users WHERE id_user = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_user]);
    }

    public function addAdmin($firstname, $lastname, $login, $pass, $pesel){
        $sql = "INSERT INTO admins (firstname, lastname, login, pass, pesel) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$firstname, $lastname, $login, $pass, $pesel]);
    }

    public function delAdmin($id_admin){
        $sql = "DELETE FROM admins WHERE id_admin = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_admin]);
    }

    public function addBook($name_book, $name_author, $name_category, $pub, $num){
        $sql = "SELECT id_author FROM authors WHERE name_author= ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name_author]);
        $author = $stmt->fetch();
        $id_author = $author['id_author'];

        $sql = "SELECT id_category FROM categories WHERE name_category = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name_category]);
        $category = $stmt->fetch();
        $id_category = $category['id_category'];

        $sql = "INSERT INTO books (name_book, id_author, id_category, pub, num) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name_book, $id_author, $id_category, $pub, $num]);
    }

    public function resBorrow($id_book, $id_user){
        $currentDate = date("y-m-d");
        $endDate = date("y-m-d", strtotime($currentDate . ' + 60 day'));

        $sql = "INSERT INTO borrows (id_user, id_book, enddate) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_user, $id_book, $endDate]);

        $sql = "DELETE FROM reservations WHERE id_user = ? AND id_book = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_user, $id_book]);
    }

    public function borrow($pesel, $author, $name_book){
        $currentDate = date("y-m-d");
        $endDate = date("y-m-d", strtotime($currentDate . ' + 60 day'));

        $sql = "SELECT id_author FROM authors WHERE name_author= ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$author]);
        $author = $stmt->fetch();

        $id_author = $author['id_author'];

        $sql = "SELECT num, id_book FROM books WHERE name_book = ? AND id_author = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name_book, $id_author]);
        $book = $stmt->fetch();

        if(!$book){
            echo "<p>Złe dane!</p>";
            echo "<a href='borrow.php'>Wroc</a>";
            exit();
        }

        $sql = "SELECT id_user FROM users WHERE pesel = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$pesel]);
        $user = $stmt->fetch();

        if($book['num']<1){
            echo "<p>Brak książki!</p>";
            echo "<a href='borrow.php'>Wroc</a>";
            exit();
        }
        $id_user = $user['id_user'];
        $id_book = $book['id_book'];
        $newNum = $book['num']-1;

        $sql = "INSERT INTO borrows (id_user, id_book, enddate) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_user, $id_book, $endDate]);

        $sql = "UPDATE books SET num = ? WHERE id_book = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$newNum, $id_book]);
    }

    public function cancelBorrow($id_bor){
        $sql = "SELECT id_book FROM borrows WHERE id_borrow = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_bor]);
        $book = $stmt->fetch();

        $sql = "SELECT num FROM books WHERE id_book = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$book['id_book']]);
        $num = $stmt->fetch();

        $newNum = $num['num']+1;

        $sql = "UPDATE books SET num = ? WHERE id_book = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$newNum, $book['id_book']]);

        $sql = "DELETE FROM borrows WHERE id_borrow = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id_bor]);
    }

    public function addAuthor($name){
        $sql = "INSERT INTO authors (name_author) VALUES (?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name]);
    }

    public function addCategory($category){
        $sql = "INSERT INTO categories (name_category) VALUES (?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$category]);
    }
}
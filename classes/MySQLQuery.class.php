<?php

class MySQLQuery extends Dbh
{
    public function loginUser($login, $password){
                
            $sql = "SELECT * FROM users WHERE login = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$login]);
                
            $userData = $stmt->fetch();
                
            if ($userData && $userData['pass'] == $password) {
                $user = new User($userData['id_user'], $userData['firstname'],$userData['lastname'],$userData['login'],$userData['pass'],$userData['pesel'],$userData['fees']);
                $_SESSION['logged_user']=$user;
                unset($_SESSION['bad_attempt']);
              } else {
                   $_SESSION['bad_attempt'] = true;
                   $_SESSION['given_login'] = $login;
                   header('Location: userlog.php');
                exit();
             }
        }

    public function loginAdmin($login, $password){
        $sql = "SELECT * FROM admins WHERE login = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$login]);
            
        $adminData = $stmt->fetch();
            
        if ($adminData && $adminData['pass'] == $password) {
            $admin = new Admin($adminData['id_admin'], $adminData['firstname'],$adminData['lastname'],$adminData['login'],$adminData['pass'],$adminData['pesel']);
            $_SESSION['logged_admin']=$admin;
            unset($_SESSION['bad_attempt']);
          } else {
               $_SESSION['bad_attempt'] = true;
               $_SESSION['given_login'] = $login;
               header('Location: adminlog.php');
            exit();
         }
    }

    public function showUserInfo(){
        echo "<td>" . $_SESSION['logged_user']->getId() . "</td>";
        echo "<td>" . $_SESSION['logged_user']->getFirstname() . "</td>";
        echo "<td>" . $_SESSION['logged_user']->getLastname() . "</td>";
        echo "<td>" . $_SESSION['logged_user']->getLogin() . "</td>";
        echo "<td>" . $_SESSION['logged_user']->getPass() . "</td>";
        echo "<td>" . $_SESSION['logged_user']->getPesel() . "</td>";
        echo "<td>" . $_SESSION['logged_user']->getFees() . "</td>";
    }

    public function showAdminInfo(){
        echo "<td>" . $_SESSION['logged_admin']->getId() . "</td>";
        echo "<td>" . $_SESSION['logged_admin']->getFirstname() . "</td>";
        echo "<td>" . $_SESSION['logged_admin']->getLastname() . "</td>";
        echo "<td>" . $_SESSION['logged_admin']->getLogin() . "</td>";
        echo "<td>" . $_SESSION['logged_admin']->getPass() . "</td>";
        echo "<td>" . $_SESSION['logged_admin']->getPesel() . "</td>";
    }

    private function showUserBooks($books){
        foreach($books as $book){
            $sql = "SELECT * FROM authors WHERE id_author = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$book['id_author']]);
            $author = $stmt->fetch();

            $id_book = $book['id_book'];

            $sql = "SELECT * FROM categories WHERE id_category = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$book['id_category']]);
            $category = $stmt->fetch();

            echo "<tr>";
            echo "<td>" . $book['name_book'] . "</td>";
            echo "<td>" . $author['name_author'] . "</td>";
            echo "<td>" . $category['name_category'] . "</td>";
            echo "<td>" . $book['pub'] . "</td>";
            echo "<td><a href='reserve.php?res=$id_book' style='color: black'>Zarezerwuj</a></td>";
            echo "</tr>";
        }
    }

    private function showAdminBooks($books){
        foreach($books as $book){
            $sql = "SELECT * FROM authors WHERE id_author = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$book['id_author']]);
            $author = $stmt->fetch();

            $id_book = $book['id_book'];

            $sql = "SELECT * FROM categories WHERE id_category = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$book['id_category']]);
            $category = $stmt->fetch();

            echo "<tr>";
            echo "<td>" . $book['name_book'] . "</td>";
            echo "<td>" . $author['name_author'] . "</td>";
            echo "<td>" . $category['name_category'] . "</td>";
            echo "<td>" . $book['pub'] . "</td>";
            echo "<td><a href='delete.php?del=$id_book' style='color: black'>Usuń</a></td>";
            echo "</tr>";
        }
    }

    public function allBooks(){
        $sql = "SELECT * FROM books";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $books = $stmt->fetchAll();
        if($_SESSION['logged_user']){
            $this->showUserBooks($books);}
        else{
            $this->showAdminBooks($books);
        }
    }

    public function byNameBooks($book_name){
        $sql = "SELECT * FROM books WHERE name_book LIKE '%{$book_name}%'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $books = $stmt->fetchAll();
        if($_SESSION['logged_user']){
            $this->showUserBooks($books);}
        else{
            $this->showAdminBooks($books);
        }
    }

    public function byNameAuthor($author_name){
        $sql = "SELECT id_author FROM authors WHERE name_author LIKE '%{$author_name}%'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $authors = $stmt->fetchAll();

        foreach($authors as $author)
        {
            $sql = "SELECT * FROM books WHERE id_author = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$author['id_author']]);

            $books = $stmt->fetchAll();
            if($_SESSION['logged_user']){
                $this->showUserBooks($books);}
            else{
                $this->showAdminBooks($books);
            }
        }
    }

    public function byCategory($category){
        $sql = "SELECT id_category FROM categories WHERE name_category LIKE '%{$category}%'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $categories = $stmt->fetchAll();

        foreach($categories as $category)
        {
            $sql = "SELECT * FROM books WHERE id_category = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$category['id_category']]);

            $books = $stmt->fetchAll();
            if($_SESSION['logged_user']){
                $this->showUserBooks($books);}
            else{
                $this->showAdminBooks($books);
            }
        }
    }

    public function reservedBooks(){
        $sql = "SELECT * FROM reservations WHERE id_user = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$_SESSION['logged_user']->getId()]);

        $reservations = $stmt->fetchAll();

        foreach($reservations as $reservation){
            $sql = "SELECT * FROM books WHERE id_book = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$reservation['id_book']]);
            $book = $stmt->fetch();

            $id_reservation = $reservation['id_reservation'];

            $sql = "SELECT * FROM authors WHERE id_author = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$book['id_author']]);
            $author = $stmt->fetch();

            $sql = "SELECT * FROM categories WHERE id_category = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$book['id_category']]);
            $category = $stmt->fetch();

            echo "<tr>";
            echo "<td>" . $reservation['id_reservation'] . "</td>";
            echo "<td>" . $book['name_book'] . "</td>";
            echo "<td>" . $author['name_author'] . "</td>";
            echo "<td>" . $category['name_category'] . "</td>";
            echo "<td>" . $book['pub'] . "</td>";
            echo "<td>" . $reservation['enddate'] . "</td>";
            echo "<td><a href='cancelRes.php?res=$id_reservation' style='color: black'>Anuluj</a></td>";
            echo "</tr>";
        }
    }

    public function reservedBooksAdmin(){
        $sql = "SELECT * FROM reservations";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $reservations = $stmt->fetchAll();

        foreach($reservations as $reservation){
            $sql = "SELECT * FROM books WHERE id_book = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$reservation['id_book']]);
            $book = $stmt->fetch();

            $sql = "SELECT firstname, lastname, pesel FROM users WHERE id_user = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$reservation['id_user']]);
            $user = $stmt->fetch();

            $id_book = $book['id_book'];
            $id_user = $reservation['id_user'];

            $sql = "SELECT * FROM authors WHERE id_author = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$book['id_author']]);
            $author = $stmt->fetch();

            echo "<tr>";
            echo "<td>" . $reservation['id_reservation'] . "</td>";
            echo "<td>" . $user['firstname'] . "</td>";
            echo "<td>" . $user['lastname'] . "</td>";
            echo "<td>" . $user['pesel'] . "</td>";
            echo "<td>" . $book['name_book'] . "</td>";
            echo "<td>" . $author['name_author'] . "</td>";
            echo "<td>" . $reservation['enddate'] . "</td>";
            echo "<td><a href='borrowing.php?bor=$id_book&user=$id_user' style='color: black'>Wypozycz</a></td>";
            echo "</tr>";
        }
    }

    public function borrowedBooks(){
        $sql = "SELECT * FROM borrows";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $borrows = $stmt->fetchAll();

        foreach($borrows as $borrow){
            $sql = "SELECT * FROM books WHERE id_book = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$borrow['id_book']]);
            $book = $stmt->fetch();

            $sql = "SELECT firstname, lastname, pesel FROM users WHERE id_user = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$borrow['id_user']]);
            $user = $stmt->fetch();

            $id_borrow = $borrow['id_borrow'];

            $sql = "SELECT * FROM authors WHERE id_author = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$book['id_author']]);
            $author = $stmt->fetch();

            echo "<tr>";
            echo "<td>" . $borrow['id_borrow'] . "</td>";
            echo "<td>" . $user['firstname'] . "</td>";
            echo "<td>" . $user['lastname'] . "</td>";
            echo "<td>" . $user['pesel'] . "</td>";
            echo "<td>" . $book['name_book'] . "</td>";
            echo "<td>" . $author['name_author'] . "</td>";
            echo "<td>" . $borrow['enddate'] . "</td>";
            echo "<td><a href='cancelBorrow.php?bor=$id_borrow' style='color: black'>Wypozycz</a></td>";
            echo "</tr>";
        }
    }

    public function showAdmins(){
        $sql = "SELECT * FROM admins";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $admins = $stmt->fetchALL();

        foreach ($admins as $admin) {
            $idAdmin = $admin['id_admin'];
            echo "<tr>";
            echo "<td>" . $admin['id_admin'] . '</td>';
            echo "<td>" . $admin['firstname'] . '</td>';
            echo "<td>" . $admin['lastname'] . '</td>';
            echo "<td>" . $admin['login'] . '</td>';
            echo "<td>" . $admin['pass'] . '</td>';
            echo "<td>" . $admin['pesel'] . '</td>';
            echo "<td><a href='deleteAdmin.php?del=$idAdmin' style='color: black'>Usun</a></td>";
            echo "</tr>";
        }
    }

    public function showUsers(){
        $sql = "SELECT * FROM users";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchALL();

        foreach ($users as $user) {
            $idUser = $user['id_user'];
            echo "<tr>";
            echo "<td>" . $user['id_user'] . '</td>';
            echo "<td>" . $user['firstname'] . '</td>';
            echo "<td>" . $user['lastname'] . '</td>';
            echo "<td>" . $user['login'] . '</td>';
            echo "<td>" . $user['pass'] . '</td>';
            echo "<td>" . $user['pesel'] . '</td>';
            echo "<td>" . $user['fees'] . '</td>';
            echo "<td><a href='deleteUser.php?del=$idUser' style='color: black'>Usun</a></td>";
            echo "</tr>";
        }
    }

    public function checkIndexStatus(){
        if (isset($_SESSION['logged_user'])) {
            header('Location: useraccount.php');
            exit();
        }else if (isset($_SESSION['logged_admin'])){
            header('Location: adminaccount.php');
            exit();
        }
        }

        public function checkLogin(){
            if (!isset($_SESSION['logged_user']) && !isset($_SESSION['logged_admin'])) {
                header('Location: index.php');
                exit();
            }
        }

    public function checkUserStatus(){
        if (!isset($_SESSION['logged_user'])) {
            header('Location: index.php');
            exit();
    }
}

    public function checkAdminStatus(){
        if (!isset($_SESSION['logged_admin'])){
            header('Location: index.php');
            exit();
    }
}

    public function showPesels(){
        $sql = "SELECT pesel FROM users";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchALL();
        foreach($users as $user){
            $pesel = $user['pesel'];
            echo "<option value='$pesel'>$pesel</option>";
            }
    }

    public function showNameBooks(){
        $sql = "SELECT name_book FROM books";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $books = $stmt->fetchALL();
        foreach($books as $book){
            $name_book = $book['name_book'];
            echo "<option value='$name_book'>$name_book</option>";
        }
    }

    public function showAuthors(){
        $sql = "SELECT name_author FROM authors";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $authors = $stmt->fetchALL();
        foreach($authors as $author){
            $name_author = $author['name_author'];
            echo "<option value='$name_author'>$name_author</option>";
        }
    }

    public function showCategories(){
        $sql = "SELECT name_category FROM categories";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchALL();
        foreach($categories as $category){
            $name_category = $category['name_category'];
            echo "<option value='$name_category'>$name_category</option>";
        }
    }

    public function formBorrow(){
        echo "<p>Pesel: </p> <select type='text' name='user_pesel'>";
        $this->showPesels();
        echo "</select>";
        echo "<p>Ksiazka: </p><select type='text' name='name_book'>";
        $this->showNameBooks();
        echo "</select>";
        echo "<p>Autor: </p><select type='text' name='name_author'>";
        $this->showAuthors();
        echo "</select>";
    }

    public function formAddBook(){
        echo "<p>Nazwa: </p> <input type='text' name='name_book'>";
        echo "</input>";
        echo "<p>Autor: </p><select type='text' name='name_author'>";
        $this->showAuthors();
        echo "</select>";
        echo "<p>Gatunek: </p><select type='text' name='name_category'>";
        $this->showCategories();
        echo "</select>";
        echo "<p>Wydawnictwo: </p><input type='text' name='pub'>";
        echo "</input>";
        echo "<p>Ilość: </p><input type='number' name='num'>";
        echo "</input>";
    }

    public function getUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $names = $stmt->fetchALL();

        foreach ($names as $name) {
            echo "<tr>";
            echo "<td>" . $name['firstname'] . '</td>';
            echo "<td>" . $name['lastname'] . '</td>';
            echo "<td>" . $name['login'] . '</td>';
            echo "<td>" . $name['pass'] . '</td>';
            echo "<td>" . $name['pesel'] . '</td>';
            echo "<td>" . $name['fees'] . '</td>';
            echo "</tr>";
        }
    }
}

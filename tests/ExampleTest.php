<?php
class Person{
    private $id;
    private $firstname;
    private $lastname;
    private $login;
    private $pass;
    private $pesel;

    public function __construct($id,$firstname,$lastname,$login,$pass,$pesel){
        $this->id=$id;
        $this->firstname=$firstname;
        $this->lastname=$lastname;
        $this->login=$login;
        $this->pass=$pass;
        $this->pesel=$pesel;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname(){
        return $this->firstname;
    }

    public function getLastname(){
        return $this->lastname;
    }

    public function getLogin(){
        return $this->login;
    }

    public function getPass(){
        return $this->pass;
    }

    public function getPesel(){
        return $this->pesel;
    }
}


class ExampleTest extends PHPUnit_Framework_TestCase {
    
 public function testId()
 {
    $person = new Person('3', 'Mariusz', 'Wsol', 'itwsolek', 'mery', '97583627561');
    $personId = $person->getId();
    $this->assertEquals('3', $personId);
 }

 public function testFirstname(){
    $person = new Person('3', 'Mariusz', 'Wsol', 'itwsolek', 'mery', '97583627561');
    $personFirstname = $person->getFirstname();
    $this->assertEquals('Mariusz', $personFirstname);
 }

 public function testLastname(){
    $person = new Person('3', 'Mariusz', 'Wsol', 'itwsolek', 'mery', '97583627561');
    $personLastname = $person->getLastname();
    $this->assertEquals('Wsol', $personLastname);
 }

 public function testLogin(){
    $person = new Person('3', 'Mariusz', 'Wsol', 'itwsolek', 'mery', '97583627561');
    $personLogin = $person->getLogin();
    $this->assertEquals('itwsolek', $personLogin);
 }

 public function testPass(){
    $person = new Person('3', 'Mariusz', 'Wsol', 'itwsolek', 'mery', '97583627561');
    $personPass = $person->getPass();
    $this->assertEquals('mery', $personPass);
 }

 public function testPesel(){
    $person = new Person('3', 'Mariusz', 'Wsol', 'itwsolek', 'mery', '97583627561');
    $personPesel = $person->getPesel();
    $this->assertEquals('97583627561', $personPesel);
 }

}
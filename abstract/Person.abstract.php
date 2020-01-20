<?php
abstract class Person extends Dbh
{
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
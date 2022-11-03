<?php
require_once("modeles/ConnectionManager.php");

class UserManager extends ConnectionManager {

    public function addUser($firstName, $lastName, $email, $password) {
        $db = $this -> dbConnection();
        $pass_hach = password_hash($password, PASSWORD_DEFAULT);
        $request = $db -> prepare("INSERT INTO users(firstName, lastName, email, password, balance) VALUES (:firstName, :lastName, :email, :password, :balance) ");
        $request -> execute(array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $pass_hach,
            'balance' => 0
        ));

        return $request; 
    }

    public function getUser($userID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT userID, firstName, lastName, email, password, balance FROM users WHERE userID=?");
        $request -> execute(array($userID));

        return $request -> fetch();
    }

    public function setBalance($userID, $balance) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("UPDATE users SET balance = :balance WHERE userID=:userID");
        $request -> execute(array(
            'userID' => $userID,
            'balance' => $balance
        ));

        return $request;    
    }

    public function setPassword($userID, $password) {
        $db = $this -> dbConnection();
        $pass_hach = password_hash($password, PASSWORD_DEFAULT);
        $request = $db -> prepare("UPDATE users SET password = :password WHERE userID=:userID");
        $request -> execute(array(
            'userID' => $userID,
            'password' => $pass_hach
        ));

        return $request;    
    }

    public function getUserLoginInfo($email) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT userID, password FROM users WHERE email=:email");
        $request -> execute(array(
            'email' => $email
        ));

        return $request->fetch();
    }

    public function checkEmail($email) { 
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT email FROM users WHERE email=?");
        $request -> execute((array($email)));

        return $request -> fetch();
    }

    public function getEmail($userId) { 
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT email FROM users WHERE userID=?");
        $request -> execute((array($userId)));

        return $request -> fetch();
    }

    public function updateUser($firstName, $lastName, $email, $userID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email WHERE userID=:userID");
        $request -> execute(array(
            'userID' => $userID,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
        ));

        return $request;
    }
    
    public function getBalance($userID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT balance FROM users WHERE userID=?");
        $request -> execute(array($userID));

        return $request -> fetch();
    }

    public function deleteUser($userID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("DELETE FROM users WHERE userID=?");
        $request -> execute(array($userID));
    }

    public function findStocksFromUser($userID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT stockID FROM orders WHERE userID=? GROUP BY stockID;");
        $request -> execute(array($userID));
        $result = $request -> fetchAll();
        
        return $result;
    }
}
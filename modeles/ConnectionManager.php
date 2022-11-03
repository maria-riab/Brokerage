<?php

class ConnectionManager {
    public function dbConnection() {
        try {
            $db = new PDO('mysql:host=localhost;dbname=brokerage;charset=utf8', 'root', '');
            return $db;
        } 
        catch (Exception $e) {
            die('Error : ' . $e -> getMessage());
        }
    }
}
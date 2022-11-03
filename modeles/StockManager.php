<?php
require_once("modeles/ConnectionManager.php");

class StockManager extends ConnectionManager {

    public function addStock($companyName, $ticker, $price) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("INSERT INTO stocks(companyName, ticker, price) VALUES (:companyName, :ticker, :price) ");
        $request -> execute(array(
            'companyName' => $companyName,
            'ticker' => $ticker,
            'price' => $price,
        ));

        return $request; 
    }
    
    public function getStockInfo($stockID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT companyName, ticker, price FROM stocks WHERE stockID=?");
        $request -> execute(array($stockID));

        return $request -> fetch();
    }

    public function getAllStocks() {
        $db = $this -> dbConnection();
        $request = $db -> query('SELECT * FROM stocks ORDER BY companyName');
        
        return $request;
    }
}
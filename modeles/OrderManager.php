<?php
require_once("modeles/ConnectionManager.php");

class OrderManager extends ConnectionManager {

    public function addOrder($stockID, $quantity, $priceBought, $isBuy, $userID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("INSERT INTO orders(stockID, quantity, priceBought, transactionDate,
            	    isBuy, userID) VALUES (:stockID, :quantity, :priceBought, NOW(),:isBuy, :userID) ");
        $request -> execute(array(
            'stockID' => $stockID,
            'quantity' => $quantity,
            'priceBought' => $priceBought,
            'isBuy' => $isBuy,
            'userID' => $userID,
        ));

        return $request; 
    }

    public function getOrderDetails($orderID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT * FROM orders WHERE orderID=:orderID");
        $request -> execute(array($orderID));

        return $request;
    }

    public function getAllUserOrders($userID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT * FROM orders WHERE userID=? ORDER BY transactionDate DESC");
        $request -> execute(array($userID));

        return $request;
    }

    public function getAllUserOrdersByStock($userID, $stockID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT * FROM orders WHERE userID=:userID AND stockID=:stockID 
                ORDER BY transactionDate DESC");
        $request -> execute(array(
            'userID' => $userID,
            'stockID' => $stockID
        ));

        return $request;
    }

    public function getNumberBoughtByUserByStock($userID, $stockID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT SUM(quantity) AS quantityStocksBought FROM orders WHERE userID=:userID 
                AND stockID=:stockID AND isBuy=1");
        $request -> execute(array(
            'userID' => $userID,
            'stockID' => $stockID
        ));

        return $request -> fetch();
    }

    public function getNumberSoldByUserByStock($userID, $stockID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT SUM(quantity) AS quantityStocksSold FROM orders WHERE userID=:userID 
                AND stockID=:stockID AND isBuy=0");
        $request -> execute(array(
            'userID' => $userID,
            'stockID' => $stockID
        ));

        return $request -> fetch();
    }

    public function getDistinctListOfStocksInOrders($userID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT stockID FROM orders GROUP BY stockID");
        $request -> execute(array(
            'userID' => $userID
        ));

        return $request;
    }

    public function getAveragePriceOfStockBought($userID, $stockID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT ROUND(AVG(priceBought), 2) as avgPrice FROM `orders` WHERE  userID=:userID AND stockID=:stockID AND isBuy=1");
        $request -> execute(array(
            'userID' => $userID,
            'stockID' => $stockID
        ));
        
        return $request -> fetch();
    }
}
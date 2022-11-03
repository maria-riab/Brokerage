<?php
require_once("modeles/ConnectionManager.php");

class PortfolioPieChartManager extends ConnectionManager {

    public function getDataPieChart($userID) {
        $db = $this -> dbConnection();
        $request = $db -> prepare("SELECT
        orders.stockID,
        (sum(case WHEN orders.isbuy=1 then orders.quantity else 0  END)-
        sum(case WHEN orders.isbuy=0 then orders.quantity else 0  END)) AS stockqty
        FROM orders
        WHERE userID=?
        GROUP by stockID");
        $request -> execute(array($userID));
        
        return $request;
    } 
}
<?php
require_once('modeles/UserManager.php');
require_once('modeles/OrderManager.php');
require_once('controlleurs\MarketController.php');
require_once('modeles\PortfolioPieChartManager.php');

function initialisePortfolioPage() {
    $userManager = new UserManager();
    $user = $userManager -> getUser($_SESSION['userID']);
    $array = getArraySymbolToAvgPrice();
    $php_data_array = populatePieChart();
    require("vues/pieChartSection.php");
}

function initialiseEmptyPortfolioPage() {
    $userManager = new UserManager();
    $user = $userManager -> getUser($_SESSION['userID']);
    require("vues/emptyPortfolio.php");
}

function getArraySymbolToAvgPrice() {
    $orderManager = new OrderManager();
    $userManager = new UserManager();
    $listOfStocks = $orderManager -> getDistinctListOfStocksInOrders($_SESSION['userID']);
    $arraySymbolAvgPrice = array();

    while ($data = $listOfStocks -> fetch()) {
        // Cette fonction du marketcontroller trouve la différence entre le nombre d'actions
        // achetés et vendus pour ce symbole en particulier
        $numberOfStockInPortfolio = getDifferenceBetweenStockBoughtAndSold($userManager -> getUser($_SESSION['userID']),
                $data['stockID']);
        if ($numberOfStockInPortfolio > 0) {
            $averagePrice = $orderManager -> getAveragePriceOfStockBought(
                $_SESSION['userID'],
                $data['stockID']
            )['avgPrice'];

            $quantity =  $numberOfStockInPortfolio;
            $arraySymbolAvgPrice[$data['stockID']] = array("quantity" => $quantity, "avgPrice" => $averagePrice);
        }
    }

    return $arraySymbolAvgPrice;
}

function populatePieChart() {
    $pieManager = new PortfolioPieChartManager();
    $request = $pieManager -> getDataPieChart($_SESSION['userID']);
    $php_data_array = array();
   
    while ($row = $request -> fetch()) {
        $php_data_array[] = $row; // Ajoute au tableau
    }
    
    return $php_data_array;
}
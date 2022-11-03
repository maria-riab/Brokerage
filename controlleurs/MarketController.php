<?php 
require_once('modeles/StockManager.php');
require_once('modeles/UserManager.php');

function initialiseMarket() {
    require("vues\market.php");
}

function displayQuoteResult() {
    clearAlertAndMessageVariables();
    $data=$_POST;
    $userManager = new UserManager();
    $balance= $userManager -> getBalance($_SESSION['userID'])['balance'];
    require("vues\market.php");
}

function processTransaction() {
    clearAlertAndMessageVariables();
    $transactionData = $_POST;
    $userManager = new UserManager();

    $currentUser = $userManager -> getUser($_SESSION['userID']);

    if ($transactionData['transactionType'] == 1) {
        $buySuccesful = processBuy($transactionData['symbolTr'], $transactionData['quantity'], 
                $transactionData['latestPriceTr'] );
        echo $buySuccesful;
        if ($buySuccesful) {
            $_SESSION['alert'] = "success";
            $_SESSION['message'] = "Merci " . $currentUser['firstName'] . " pour votre achat!";
        }
    }
    else {
        $saleSuccesful = processSell($transactionData['symbolTr'], $transactionData['quantity'], 
                $transactionData['latestPriceTr']);
        if ($saleSuccesful) {
            $_SESSION['alert'] = "success";
            $_SESSION['message'] = "Merci " . $currentUser['firstName'] . " pour votre vente!";
        }
    }

    header("Location: index.php");
} 
function processBuy($stockID, $quantity, $priceBought) {
    $userManager = new UserManager();
    $orderManager = new OrderManager();

    $currentUser =  $currentUser = $userManager -> getUser($_SESSION['userID']);
    $transactionValue = $priceBought * $quantity;
    if (!hasEnoughBalance($currentUser, $transactionValue)) {
        $_SESSION['alert'] = "error";
        $_SESSION['message'] = "ERREUR! Vous n'avez pas assez d'argent pour completer cette transaction";

        return 0;
    }
 
    $balanceChangeRequest = $userManager -> setBalance($currentUser['userID'], 
            ($currentUser['balance'] - $transactionValue));
    $orderRequest = $orderManager -> addOrder(
       $stockID,
       $quantity,
        $priceBought,
        1,
        $_SESSION['userID']
    );

    // assure qu'on a bien traité la commande et changement de balance; 
    return (($orderRequest -> rowCount() == 1) && ($balanceChangeRequest -> rowCount() == 1));
}

function processSell($stockID, $quantity, $sellPrice) {
    $userManager = new UserManager();
    $orderManager = new OrderManager();

    $currentUser =  $currentUser = $userManager -> getUser($_SESSION['userID']);
    $transactionValue = $sellPrice * $quantity;

    if (getDifferenceBetweenStockBoughtAndSold($currentUser, $stockID) < $quantity) {
        $_SESSION['alert'] = "error";
        $_SESSION['message'] = "ERREUR! Vous n'avez pas assez d'actions dans votre portfolio pour 
                completer cette transaction";

        return 0;
    }

    $balanceChangeRequest = $userManager -> setBalance($currentUser['userID'], 
            ($currentUser['balance'] + $transactionValue));
    $orderRequest = $orderManager -> addOrder(
        $stockID,
        $quantity,
        $sellPrice,
        0,
        $_SESSION['userID']
    );

    // assure qu'on a bien traité la commande et changement de balance; 
    return (($orderRequest -> rowCount() == 1) && ($balanceChangeRequest -> rowCount() == 1));
}

function getDifferenceBetweenStockBoughtAndSold($user, $stockID) {
    $orderManager = new OrderManager();
    $numberBought = $orderManager -> getNumberBoughtByUserByStock($user['userID'], $stockID);
    $numberSold = $orderManager -> getNumberSoldByUserByStock($user['userID'], $stockID);

    if ($numberBought['quantityStocksBought'] == false) return 0;
    if ($numberSold['quantityStocksSold'] == false) return $numberBought['quantityStocksBought'];
    
    return ($numberBought['quantityStocksBought'] - $numberSold['quantityStocksSold']);
}

function getNumberOfStocksToSell($user, $stockID) {
    $orderManager = new OrderManager();
    $numberBought = $orderManager -> getNumberBoughtByUserByStock($user['userID'], $stockID);
    $numberSold = $orderManager -> getNumberSoldByUserByStock($user['userID'], $stockID);

    if ($numberBought['quantityStocksBought'] == false) return 0;
    if ($numberSold['quantityStocksSold'] == false) return $numberBought['quantityStocksBought'];
    
    return ($numberBought['quantityStocksBought'] - $numberSold['quantityStocksSold']); 
}

function hasEnoughBalance($user, $transactionValue) {
    return (($user['balance'] - $transactionValue) >= 0);
}


function clearAlertAndMessageVariables() {
    $_SESSION['alert'] = "";
    $_SESSION['message'] = "";
}
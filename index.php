<?php
require('controlleurs/MarketController.php');
require('controlleurs\UserRegistrationLoginController.php');
require('controlleurs\UserInformationController.php');
require('controlleurs\PortfolioController.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['userID'])) {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "logout") {
            logoutUser();
        }

        if ($_GET['action'] == "account-home") {
            initialiseUserInformationPage();
        }

        if ($_GET['action'] == "market") {
            initialiseMarket();
        }

        if ($_GET['action'] == "portfolio") {
            $orderManager = new OrderManager();
            $list = $orderManager->getAllUserOrders($_SESSION['userID']);
            if ($list->rowCount() == 0) {
                initialiseEmptyPortfolioPage();
            }
            else {
                initialisePortfolioPage();
            }
        }

        if ($_GET['action'] == "quote") {
            displayQuoteResult();
        }

        if ($_GET['action'] == "sendOrder") {
            processTransaction();
        }

        if ($_GET['action'] == "updateUserGeneral") {
            if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email'])) {
                modifyUser();
            }
        }

        if ($_GET['action'] == "updatePassword") {
            if (isset($_POST['mdp1']) && isset($_POST['mdpConfirmation'])) {
                modifyPassword();
            }
        }

        if ($_GET['action'] == "updateBalance") {
            if (isset($_POST['balance'])){
                modifyBalance();
            }
        }
        
        if ($_GET['action'] == "removeUser") {
            removeUser();
        }
    } 
    else {
        // Ceci va être la page portfoliom, l'action n'a pas encore été établie
        $orderManager = new OrderManager();
        $list = $orderManager->getAllUserOrders($_SESSION['userID']);
        if ($list->rowCount() == 0) {
            initialiseEmptyPortfolioPage();
        }
        else {
            initialisePortfolioPage();
        }
    }
} 
else {
    // Aucune session n'a été établie, c'est ici que se trouve toutes les actions sans session
    if (isset($_GET['action'])) {
        // Gère la connexion de l'utilisateur
        if ($_GET['action'] == "login") {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                loginUser($_POST['email'], $_POST['password']);
            }
        }

        if ($_GET['action'] == "newUser") {
            if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['passwordConfirm'])) {
                createUser($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'], $_POST['passwordConfirm']);
            } else echo 'Usager non créé, newUser a été appelé';
        }
    } 
    else {
        // L'action n'a pas été établie alors c'est la page d'accueil par défault
        require("vues\login.php");
    }
}
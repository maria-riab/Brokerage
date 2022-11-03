<?php
require_once('modeles/UserManager.php');
require_once('controlleurs/MarketController.php');

function  initialiseUserInformationPage() {
    $userManager = new UserManager();
    $user = $userManager -> getUser($_SESSION['userID']);
    require("vues\account-home.php");
}

function modifyUser() {
    clearAlertAndMessageVariables();
    $data = $_POST;
    $userManager = new UserManager();
    $emailInSystem = $userManager -> checkEmail($_POST['email']);
    $currentUserEmail = $userManager -> getEmail($_SESSION['userID']);
    if (($emailInSystem) &&  $_POST['email'] !=  $currentUserEmail['email'] ) {
        $_SESSION['alert'] = 'error';
        $_SESSION['message'] = 'ERREUR! Ce courriel est déjà utilisé.';
        initialiseUserInformationPage();

        return;
    }
    
    $modifyUserModel = $userManager -> updateUser($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_SESSION['userID']);
    if (!$modifyUserModel){
        $_SESSION['alert'] = 'error';
        $_SESSION['message'] = 'ERREUR! Incapacité de mettre à jour votre information.';
        initialiseUserInformationPage();

        return;
    }

    $_SESSION['alert'] = 'success';
    $_SESSION['message'] = 'Vos informations personnelles ont été mises à jour avec succès!';
    initialiseUserInformationPage();
}

function modifyPassword() {
    clearAlertAndMessageVariables();
    $data = $_POST;
    if ($data['mdp1'] != $data['mdpConfirmation']) {
        $_SESSION['alert'] = 'error';
        $_SESSION['message'] = 'ERREUR! Les saisies de votre mot de passe et de la confirmation 
                de votre mot de passe doivent correspondre!';
        initialiseUserInformationPage();

        return;
    }

    $userManager = new UserManager();
    $updatePasswordSuccessful = $userManager -> setPassword($_SESSION['userID'],$data['mdp1']);
    if (!$updatePasswordSuccessful) {
        $_SESSION['alert'] = 'error';
        $_SESSION['message'] = 'ERREUR! Incapacité de mettre à jour votre mot de passe!';
    }
    else {
        $_SESSION['alert'] = 'success';
        $_SESSION['message'] = 'Votre mot de passe a été mis à jour avec succès.';
    }

    initialiseUserInformationPage();
}

function modifyBalance() {
    clearAlertAndMessageVariables();
    $data = $_POST;
    $userManager = new UserManager();
    $currentBalance = $userManager -> getBalance($_SESSION['userID'])['balance'];
    if ($data['buttonVal'] == 'add') {
        $userManager -> setBalance($_SESSION['userID'], ($data['balance'] + $currentBalance ));
        $_SESSION['alert'] = 'success';
        $_SESSION['message'] = 'L\'ajout à votre balance a été effectué avec succès.';
        initialiseUserInformationPage();

        return;
    }

    if ($data['buttonVal'] == 'remove') {
        if (($currentBalance - $data['balance']) >= 0) {
            $userManager -> setBalance($_SESSION['userID'], $currentBalance - $data['balance']);
            $_SESSION['alert'] = 'success';
            $_SESSION['message'] = 'Le retrait à votre balance a été effectué avec succès.';
            initialiseUserInformationPage();
            return;
        } 
        else {
            $_SESSION['alert'] = 'error';
            $_SESSION['message'] = 'ERREUR! Vous ne pouvez pas retirer plus que ce que vous avez 
                    dans votre balance. Veuillez essayer à nouveau.';
            initialiseUserInformationPage();

            return;
        }
    }

    initialiseUserInformationPage();
}

function removeUser() {
    clearAlertAndMessageVariables();
    $userManager = new UserManager();
    $currentUser = $userManager -> getUser($_SESSION['userID']);
        if (verifyBalanceIsEmpty() == 1 && verifyStockIsEmpty($currentUser) == 1) {             
            $userManager -> deleteUser($_SESSION['userID']);
            logoutUser();
            session_start();
            $_SESSION['alert'] = 'success';
            $_SESSION['message'] = 'Compte supprimé avec succès.';
        }
}

function verifyStockIsEmpty($currentUser) {
    clearAlertAndMessageVariables();
    $userManager = new UserManager();
    $listStockID = array(null);

    // Vérifie si les stocks sont définis
    if (isset($userManager -> findStocksFromUser($_SESSION['userID'])[0]['stockID'])) {
        $listStockID = [$userManager -> findStocksFromUser($_SESSION['userID'])[0]['stockID']];
    }
    
    foreach ($listStockID as $stockID) {     
        if (getNumberOfStocksToSell($currentUser, $stockID) > 0) {
            $_SESSION['alert'] = "error";
            $_SESSION['message'] = "ERREUR! Votre portfolio doit être vide pour pouvoir supprimer votre compte.";
            initialiseUserInformationPage();

            return 0;
        }
    }

    unset($stockID);

    return 1;
}

function verifyBalanceIsEmpty() {
    $userManager = new UserManager();
    $balance = $userManager->getBalance($_SESSION['userID'])['balance'];
    if ($balance > 0) {
        $_SESSION['alert'] = "error";
        $_SESSION['message'] = "ERREUR! Votre balance doit être à 0 pour pouvoir supprimer votre compte.";
        initialiseUserInformationPage();

        return 0;
    }

    return 1;
}
<?php
require_once('modeles/UserManager.php');
require_once('controlleurs/MarketController.php');

function loginUser($email, $password) {
    clearAlertAndMessageVariables();
    $usermanager = new UserManager();
    $validUser = $usermanager -> getUserLoginInfo($email);
    $validPassword = password_verify($password, $validUser['password']);
    if ($validUser && $validPassword) {
        $_SESSION['userID'] = $validUser['userID'];
    } 
    else {
        $_SESSION['alert'] = 'error';
        $_SESSION['message'] = 'Le courriel ou le mot de passe est invalide. Veuillez réessayer.';
    }

    header("Location: index.php");
}

function logoutUser() {
    $_SESSION = array();
    session_destroy();
    // redirige l'utilisateur à index.php où maintenant aucune variable de session n'a été définie
    header("Location: index.php");
}

function redirectToUserHome() {
   require("vues\accountVues\account-home.php");
}

function createUser($firstName, $lastName, $email, $password, $passwordConfirm) {
    clearAlertAndMessageVariables();
    $usermanager = new UserManager();
    $data = $_POST;

    // Vérification de tous les champs non-vides
    if (empty($data['firstName']) ||
        empty($data['lastName']) ||
        empty($data['email']) ||
        empty($data['password']) ||
        empty($data['passwordConfirm'])) {
        $_SESSION['alert'] = 'error';
        $_SESSION['message'] = 'ERREUR! Veuillez remplir tous les champs requis!';
        header("Location: index.php");
        
        return;
    }

    // Vérification que les mots de passe soient identiques
    if ($data['password'] !== $data['passwordConfirm']) {
        $_SESSION['alert'] = 'error';
        $_SESSION['message'] = 'ERREUR! Les deux mots de passe saisis sont différents.';
        header("Location: index.php");

        return;
    }

    // Vérification que le courriel est unique
    if ($usermanager -> checkEmail($email)) {
        $_SESSION['alert'] = 'error';
        $_SESSION['message'] = 'ERREUR! Ce courriel existe déjà.';
        header("Location: index.php");

        return;
    }

    // Création de l'utilisateur
    $requete = $usermanager -> addUser($firstName, $lastName, $email, $password);
    if ($requete -> rowCount() <= 0) {
        $_SESSION['alert'] = 'error';
        $_SESSION['message'] = 'ERREUR! L\'utilisateur n\'a pas été ajouté.';
        header("Location: index.php");

        return;
    }
    
    $_SESSION['alert'] = 'success';
    $_SESSION['message'] = 'Merci pour votre inscription!';
    header("Location: index.php");
}
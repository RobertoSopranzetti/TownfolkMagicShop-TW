<?php
require_once 'bootstrap.php';

if(isset($_POST["identifier"]) && isset($_POST["password"])){
    $login_result = $dbh->checkLogin($_POST["identifier"], $_POST["password"]);
    if($login_result == false){
        //Login fallito
        $templateParams["errorelogin"] = "Errore! Controllare username o password!";
    }
    else{
        registerLoggedUser($login_result);
        header("location: login-home.php");
        exit();
    }
}

if(isUserLoggedIn()){
    $templateParams["titolo"] = "TownfolkMagicShop - User Home";
    $templateParams["nome"] = "login-home.php";
    if(isset($_GET["formmsg"])){
        $templateParams["formmsg"] = $_GET["formmsg"];
    }
}
else{
    $templateParams["titolo"] = "TownfolkMagicShop - Login";
    $templateParams["nome"] = "login-form.php";
}
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["ruolo"] = isUserLoggedIn() ? $dbh->getRoleByUsername($_SESSION["username"])["ruolo"] : "cliente";


require 'template/base.php';
?>
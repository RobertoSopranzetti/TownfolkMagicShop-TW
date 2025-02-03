<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TownfolkMagicShop - Home";
$templateParams["ruolo"] = isUserLoggedIn() ? $dbh->getRoleByUsername($_SESSION["username"])["ruolo"] : "cliente";
$templateParams["nome"] = $templateParams["ruolo"] == "venditore" ? "home-venditore.php" : "home-cliente.php";

//Home Template
$templateParams["prodottiCasuali"] = $dbh->getRandomProducts(2);

if ($templateParams["ruolo"] == "venditore") {
    $idVenditore = $_SESSION["idutente"];
    $templateParams["ordiniInSospeso"] = getPendingOrders($dbh->getOrdersBySellerId($idVenditore));
    $templateParams["notificheNuove"] = getNewNotifications($dbh->getUserNotifications($idVenditore));
    $templateParams["prodottiInEsaurimento"] = getShortageProducts($dbh->getShortageProducts($idVenditore));
}

require 'template/base.php';
?>
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TownfolkMagicShop - Home";
$templateParams["nome"] = $templateParams["ruolo"] == "venditore" ? "home-venditore.php" : "home-cliente.php";


if ($templateParams["ruolo"] == "venditore") {
    $idVenditore = $_SESSION["idutente"];
    $templateParams["ordiniInSospeso"] = getPendingOrders($dbh->getOrdersBySellerId($idVenditore));
    $templateParams["notificheNuove"] = getNewNotifications($dbh->getUserNotifications($idVenditore));
    $templateParams["prodottiInEsaurimento"] = getShortageProducts($dbh->getShortageProducts($idVenditore));
}

require 'template/base.php';
?>
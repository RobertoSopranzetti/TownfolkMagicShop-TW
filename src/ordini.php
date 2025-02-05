<?php
require_once 'bootstrap.php';

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$templateParams["titolo"] = "TownfolkMagicShop - Ordini";
$templateParams["nome"] = "lista-ordini.php";
$templateParams["ordini"] = $templateParams["ruolo"] == "cliente" ? $dbh->getOrdersByUserId($_SESSION["idutente"]) : $dbh->getOrdersBySellerId($_SESSION["idutente"]);

require 'template/base.php';
?>
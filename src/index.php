<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TownfolkMagicShop - Home";
$templateParams["ruolo"] = isUserLoggedIn() ? $dbh->getRoleByUsername($_SESSION["username"])["ruolo"] : "cliente";
$templateParams["nome"] = $templateParams["ruolo"] == "venditore" ? "home-venditore.php" : "home-cliente.php";
$templateParams["categorie"] = $dbh->getCategories();
//Home Template
$templateParams["prodottiCasuali"] = $dbh->getRandomProducts(2);

require 'template/base.php';
?>
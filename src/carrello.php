<?php
require_once 'bootstrap.php';

if (!isUserLoggedIn()) {
    header("location: login.php");
    exit();
}

$templateParams["titolo"] = "TownfolkMagicShop - Carrello";
$templateParams["nome"] = "shopping-cart.php";
$templateParams["prodottiCarrello"] = $dbh->getProductsInCart($_SESSION["idutente"]);

// Calcola il subtotale
$subtotale = 0;
foreach ($templateParams["prodottiCarrello"] as $prodotto) {
    $subtotale += $prodotto["prezzo"] * $prodotto["quantita"];
}
$templateParams["subtotale"] = $subtotale;

require 'template/base.php';
?>
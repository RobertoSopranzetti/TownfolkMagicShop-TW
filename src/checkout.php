<?php
require_once 'bootstrap.php';

// Verifica se l'utente è loggato
if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Recupera i prodotti nel carrello
$prodottiCarrello = $dbh->getProductsInCart($_SESSION["idutente"]);
$subtotale = array_sum(array_column($prodottiCarrello, 'prezzo_totale'));

// Imposta i parametri del template
$templateParams["titolo"] = "TownfolkMagicShop - Checkout";
$templateParams["nome"] = "checkout-form.php";
$templateParams["prodottiCarrello"] = $prodottiCarrello;
$templateParams["subtotale"] = $subtotale;

// Carica il template
require 'template/base.php';
?>
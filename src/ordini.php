<?php
require_once 'bootstrap.php';

// Verifica se l'utente è loggato
if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Recupera il ruolo dell'utente
$ruolo = $_SESSION["ruolo"];

// Recupera gli ordini dal database
if ($ruolo == "cliente") {
    $ordini = $dbh->getOrdersByUserId($_SESSION["idutente"]);
} else if ($ruolo == "venditore") {
    $ordini = $dbh->getOrdersBySellerId($_SESSION["idutente"]);
}

// Imposta i parametri del template
$templateParams["titolo"] = "TownfolkMagicShop - Ordini";
$templateParams["nome"] = "lista-ordini.php";
$templateParams["ruolo"] = $ruolo;
$templateParams["ordini"] = $ordini;

// Carica il template
require 'template/base.php';
?>
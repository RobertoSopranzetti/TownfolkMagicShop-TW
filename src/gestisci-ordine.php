<?php
require_once 'bootstrap.php';

// Verifica se l'utente è loggato e se è un venditore
if (!isUserLoggedIn() || $_SESSION["ruolo"] != "venditore" || !isset($_GET["id"])) {
    header("Location: login.php");
    exit();
}

// Recupera l'ID dell'ordine dalla query string
$idOrdine = intval($_GET["id"]);

// Recupera i dettagli dell'ordine dal database
$ordine = $dbh->getOrderById($idOrdine);

// Se l'ordine non esiste o non appartiene al venditore loggato, reindirizza alla pagina degli ordini
if (!$ordine || $ordine["id_venditore"] != $_SESSION["idutente"]) {
    header("Location: ordini.php");
    exit();
}

// Imposta i parametri del template
$templateParams["titolo"] = "TownfolkMagicShop - Gestisci Ordine";
$templateParams["nome"] = "order-form.php";
$templateParams["ordine"] = $ordine;

// Aggiungi il messaggio di feedback se presente
$templateParams["formmsg"] = isset($_GET["formmsg"]) ? $_GET["formmsg"] : '';

require 'template/base.php';
?>
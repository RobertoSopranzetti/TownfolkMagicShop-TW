<?php
require_once 'bootstrap.php';

// Recupera l'ID del prodotto dalla query string
$idprodotto = -1;
if (isset($_GET["id"])) {
    $idprodotto = $_GET["id"];
}

// Recupera i dettagli del prodotto dal database
$templateParams["prodotto"] = $dbh->getProductById($idprodotto);

// Imposta il titolo della pagina in modo dinamico in base al nome del prodotto
if ($templateParams["prodotto"] && count($templateParams["prodotto"]) > 0) {
    $titoloProdotto = $templateParams["prodotto"]["titolo"];
    $templateParams["titolo"] = "TownfolkMagicShop - " . $titoloProdotto;
} else {
    $templateParams["titolo"] = "TownfolkMagicShop - Prodotto non trovato";
    $templateParams["prodotto"] = null; // Assicurati che il prodotto sia null se non trovato
}

// Imposta altri parametri del template
$templateParams["nome"] = "singolo-prodotto.php";
$templateParams["categorie"] = $dbh->getCategories();

require 'template/base.php';
?>
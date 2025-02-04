<?php
require_once 'bootstrap.php';

if (!isUserLoggedIn() || !isset($_GET["action"]) || ($_GET["action"] != 1 && $_GET["action"] != 2 && $_GET["action"] != 3) || ($_GET["action"] != 1 && !isset($_GET["id"]))) {
    header("location: login.php");
    exit();
}

$templateParams["azione"] = $_GET["action"];

if ($_GET["action"] != 1) {
    $productId = $_GET["id"];
    $sellerId = $_SESSION["idutente"];

    $risultato = $dbh->getProductByIdAndSeller($productId, $sellerId);

    if (empty($risultato)) {
        $templateParams["prodotto"] = null;
    } else {
        $templateParams["prodotto"] = $risultato;
    }
} else {
    $templateParams["prodotto"] = getEmptyProduct();
}

$templateParams["titolo"] = "TownfolkMagicShop - Gestisci Prodotti";
$templateParams["nome"] = "product-form.php";
$templateParams["categorie"] = $dbh->getCategories();

// Aggiungi il messaggio di feedback se presente
$templateParams["formmsg"] = isset($_GET["formmsg"]) ? $_GET["formmsg"] : '';

require 'template/base.php';
?>
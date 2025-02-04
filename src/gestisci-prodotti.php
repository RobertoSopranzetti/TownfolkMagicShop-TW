<?php
require_once 'bootstrap.php';

if (!isUserLoggedIn() || !isset($_GET["action"]) || ($_GET["action"] != 1 && $_GET["action"] != 2 && $_GET["action"] != 3) || ($_GET["action"] != 1 && !isset($_GET["id"]))) {
    header("location: login.php");
    exit();
}

if ($_GET["action"] != 1) {
    $risultato = $dbh->getProductByIdAndSeller($_GET["id"], $_SESSION["idutente"]);
    if (count($risultato) == 0) {
        $templateParams["prodotto"] = null;
    } else {
        $templateParams["prodotto"] = $risultato[0];
    }
} else {
    $templateParams["prodotto"] = getEmptyProduct();
}

$templateParams["titolo"] = "TownfolkMagicShop - Gestisci Prodotti";
$templateParams["nome"] = "product-form.php";
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["prodottiCasuali"] = $dbh->getRandomProducts(2);

$templateParams["azione"] = $_GET["action"];

// Aggiungi il messaggio di feedback se presente
$templateParams["formmsg"] = isset($_GET["formmsg"]) ? $_GET["formmsg"] : '';

require 'template/base.php';
?>
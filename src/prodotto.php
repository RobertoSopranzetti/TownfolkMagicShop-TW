<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TownfolkMagicShop - Prodotto";
$templateParams["nome"] = "singolo-prodotto.php";
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["prodottiCasuali"] = $dbh->getRandomProducts(2);

//Home Template
$idprodotto = -1;
if (isset($_GET["id"])) {
    $idprodotto = $_GET["id"];
}
$templateParams["prodotto"] = $dbh->getProductById($idprodotto);

require 'template/base.php';
?>
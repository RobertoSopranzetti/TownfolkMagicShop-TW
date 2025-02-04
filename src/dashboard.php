<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TownfolkMagicShop - Prodotti";

$minPrice = $dbh->getMinPrice();
$maxPrice = $dbh->getMaxPrice();
$selectedCategory = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$selectedMaxPrice = isset($_GET['prezzoMax']) ? $_GET['prezzoMax'] : $maxPrice;
$limitedEdition = isset($_GET['edizioneLimitata']) && $_GET['edizioneLimitata'] == '1' ? true : false;

$templateParams["categorie"] = $dbh->getCategories();
$templateParams["prezzoMin"] = $minPrice;
$templateParams["prezzoMax"] = $maxPrice;
$templateParams["selectedCategory"] = $selectedCategory;
$templateParams["selectedMaxPrice"] = $selectedMaxPrice;
$templateParams["limitedEdition"] = $limitedEdition;

if ($templateParams["ruolo"] == "venditore") {
    if (isset($_GET['shortage']) && $_GET['shortage'] == 1) {
        $prodotti = $dbh->getShortageProducts($_SESSION["idutente"]);
    } else {
        $prodotti = $dbh->getProductsByUserId($_SESSION["idutente"]);
    }
} else {
    $prodotti = $dbh->getProductsByPriceRange($minPrice, $selectedMaxPrice);
    $prodotti = filterProducts($prodotti, $selectedCategory, $limitedEdition);
}

$templateParams["prodotti"] = $prodotti;
$templateParams["nome"] = "lista-prodotti.php";
$templateParams["formmsg"] = isset($_GET["formmsg"]) ? $_GET["formmsg"] : '';

require 'template/base.php';
?>
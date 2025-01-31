<?php
require_once 'bootstrap.php';
require_once 'utils/functions.php';

$templateParams["titolo"] = "TownfolkMagicShop - Prodotti";
$templateParams["ruolo"] = isUserLoggedIn() ? $dbh->getRoleByUsername($_SESSION["username"])["ruolo"] : "cliente";

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

// Logica per filtrare i prodotti
if ($templateParams["ruolo"] == "venditore") {
    if ($_GET['shortage'] == 1) {
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

require 'template/base.php';
?>
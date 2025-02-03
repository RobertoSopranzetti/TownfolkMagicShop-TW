<?php
require_once 'bootstrap.php';

if (!isUserLoggedIn()) {
    header("location: login.php");
    exit();
}

$azione = isset($_GET['azione']) ? getAction($_GET['azione']) : '';

switch ($azione) {
    case 'Inserisci':
        $id_prodotto = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
        $quantita = isset($_GET["quantita"]) ? intval($_GET["quantita"]) : 1;
        if ($id_prodotto > 0 && $quantita > 0) {
            $dbh->addToCart($_SESSION["idutente"], $id_prodotto, $quantita);
            echo json_encode(["success" => true, "message" => "Prodotto aggiunto al carrello"]);
        } else {
            echo json_encode(["success" => false, "message" => "Parametri non validi"]);
        }
        exit();
    case 'Rimuovi':
        $id_prodotto = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
        if ($id_prodotto > 0) {
            $dbh->removeFromCart($_SESSION["idutente"], $id_prodotto);
            echo json_encode(["success" => true, "message" => "Prodotto rimosso dal carrello"]);
        } else {
            echo json_encode(["success" => false, "message" => "Parametri non validi"]);
        }
        exit();
    default:
        $templateParams["titolo"] = "TownfolkMagicShop - Carrello";
        $templateParams["nome"] = "shopping-cart.php";
        $templateParams["prodottiCarrello"] = $dbh->getProductsInCart($_SESSION["idutente"]);
        $templateParams["prodottiCasuali"] = $dbh->getRandomProducts(2);
        require 'template/base.php';
        break;
}
?>
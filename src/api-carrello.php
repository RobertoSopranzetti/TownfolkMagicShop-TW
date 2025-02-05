<?php
require_once 'bootstrap.php';

header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if (!isUserLoggedIn()) {
    $response["message"] = "Devi essere loggato per aggiungere prodotti al carrello";
    echo json_encode($response);
    exit();
}

$azione = isset($_GET['azione']) ? $_GET['azione'] : '';

switch ($azione) {
    case 'Inserisci':
        $id_prodotto = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
        $quantita = isset($_GET["quantita"]) ? intval($_GET["quantita"]) : 1;
        if ($id_prodotto > 0 && $quantita > 0) {
            $dbh->addToCart($_SESSION["idutente"], $id_prodotto, $quantita);
            $response["success"] = true;
            $response["message"] = "Prodotto aggiunto al carrello";
        } else {
            $response["message"] = "Parametri non validi";
        }
        break;
    case 'Cancella':
        $id_prodotto = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
        if ($id_prodotto > 0) {
            $dbh->removeFromCart($_SESSION["idutente"], $id_prodotto);
            $response["success"] = true;
            $response["message"] = "Prodotto rimosso dal carrello";
        } else {
            $response["message"] = "Parametri non validi";
        }
        break;
    case 'Aggiorna':
        $id_prodotto = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
        $quantita = isset($_GET["quantita"]) ? intval($_GET["quantita"]) : 1;
        if ($id_prodotto > 0 && $quantita > 0) {
            $dbh->updateCartQuantity($_SESSION["idutente"], $id_prodotto, $quantita);
            $response["success"] = true;
            $response["message"] = "Carrello aggiornato";
        } else {
            $response["message"] = "Parametri non validi";
        }
        break;
    default:
        $response["message"] = "Azione non valida";
        break;
}

error_log(json_encode($response)); // Log per verificare la risposta
echo json_encode($response);
?>
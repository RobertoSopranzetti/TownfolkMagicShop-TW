<?php
require_once 'bootstrap.php';

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$idUtente = $_SESSION["idutente"];

// Gestisci le azioni
if (isset($_GET["action"]) && isset($_GET["id"])) {
    $idNotifica = intval($_GET["id"]);
    $action = getAction($_GET["action"]);
    switch ($action) {
        case "Inserisci":
            $dbh->markNotificationAsRead($idNotifica, $idUtente);
            $formmsg = "Notifica segnata come letta!";
            break;
        case "Modifica":
            $dbh->markNotificationAsUnread($idNotifica, $idUtente);
            $formmsg = "Notifica segnata come non letta!";
            break;
        case "Cancella":
            $dbh->deleteNotification($idNotifica, $idUtente);
            $formmsg = "Notifica eliminata!";
            break;
        default:
            $formmsg = "Azione non valida.";
            break;
    }
    header("Location: notifiche.php?formmsg=" . urlencode($formmsg));
    exit();
}

// Recupera le notifiche dell'utente
$notifiche = $dbh->getUserNotifications($idUtente);

$templateParams["titolo"] = "TownfolkMagicShop - Notifiche";
$templateParams["nome"] = "lista-notifiche.php";
$templateParams["notifiche"] = $notifiche;
$templateParams["formmsg"] = isset($_GET["formmsg"]) ? $_GET["formmsg"] : "";
$templateParams["prodottiCasuali"] = $dbh->getRandomProducts(2);

require 'template/base.php';
?>
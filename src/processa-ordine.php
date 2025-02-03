<?php
require_once 'bootstrap.php';

if (!isUserLoggedIn() || $_SESSION["ruolo"] != "venditore" || !isset($_POST["id"]) || !isset($_POST["stato_ordine"])) {
    header("Location: login.php");
    exit();
}

$idOrdine = intval($_POST["id"]);
$nuovoStato = $_POST["stato_ordine"];

// Aggiorna lo stato dell'ordine nel database
$dbh->updateOrderStatus($idOrdine, $nuovoStato);

// Reindirizza alla pagina gestisci-ordine.php con un messaggio di feedback
header("Location: gestisci-ordine.php?id=$idOrdine&formmsg=" . urlencode("Stato dell'ordine aggiornato con successo!"));
exit();
?>
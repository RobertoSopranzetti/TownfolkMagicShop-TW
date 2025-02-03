<?php
require_once 'bootstrap.php';

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$email = $_POST["email"];
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$numero_carta = $_POST["numero_carta"];
$idUtente = $_SESSION["idutente"];

// Recupera i prodotti nel carrello
$prodottiCarrello = $dbh->getProductsInCart($idUtente);
$subtotale = array_sum(array_column($prodottiCarrello, 'prezzo_totale'));

// Salva l'ordine nel database
$idOrdine = $dbh->createOrder($idUtente, $subtotale);

// Salva i dettagli dell'ordine nel database
foreach ($prodottiCarrello as $prodotto) {
    $dbh->insertOrderItem($idOrdine, $prodotto["id"], $prodotto["quantita"], $prodotto["prezzo_totale"]);
}

// Svuota il carrello
$dbh->clearCart($idUtente);

// Reindirizza alla pagina di conferma dell'ordine con un messaggio di feedback
header("Location: conferma-ordine.php?id=$idOrdine&formmsg=" . urlencode("Ordine creato con successo!"));
exit();
?>
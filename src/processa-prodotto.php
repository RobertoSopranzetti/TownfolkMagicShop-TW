<?php
require_once 'bootstrap.php';

if (!isUserLoggedIn() || !isset($_POST["azione"])) {
    header("location: login.php");
    exit();
}

$azione = $_POST["azione"];
$titolo = htmlspecialchars($_POST["nomeProdotto"]);
$descrizione = htmlspecialchars($_POST["descrizione"]);
$prezzo = htmlspecialchars($_POST["prezzo"]);
$sconto = htmlspecialchars($_POST["sconto"]);
$quantita = htmlspecialchars($_POST["quantita"]);
$categoria = htmlspecialchars($_POST["categoria"]);
$id_utente = $_SESSION["idutente"];
$id_prodotto = isset($_POST["id"]) ? $_POST["id"] : null;
$edizione_limitata = isset($_POST['edizione_limitata']) ? 1 : 0;

$immagine = null;
if (isset($_FILES['immagine']) && $_FILES['immagine']['error'] == UPLOAD_ERR_OK) {
    $file_array = [
        'name' => $_FILES['immagine']['name'],
        'type' => $_FILES['immagine']['type'],
        'tmp_name' => $_FILES['immagine']['tmp_name'],
        'error' => $_FILES['immagine']['error'],
        'size' => $_FILES['immagine']['size']
    ];
    list($result, $msg) = uploadImage(UPLOAD_DIR, $file_array);
    if ($result == 1) {
        $immagine = $msg;
    } else {
        // Gestisci l'errore di caricamento dell'immagine
        echo "Errore nel caricamento dell'immagine: " . $msg;
        exit();
    }
} elseif ($azione == 'Modifica' || $azione == 'Cancella') {
    $risultato = $dbh->getProductByIdAndSeller($id_prodotto, $id_utente);
    if (empty($risultato)) {
        $msg = "Errore: prodotto non trovato o non autorizzato!";
        header("location: dashboard.php?formmsg=" . urlencode($msg));
        exit();
    }
    if ($azione == 'Modifica' && $immagine === null) {
        $immagine = isset($_POST['immagine_esistente']) ? $_POST['immagine_esistente'] : $risultato['immagine']; // Mantieni l'immagine esistente
    }
}

if ($azione == 'Inserisci') {
    $id_prodotto = $dbh->insertProduct($titolo, $descrizione, $prezzo, $sconto, $quantita, $categoria, $id_utente, $immagine, $edizione_limitata);
    if ($id_prodotto) {
        $msg = "Inserimento completato correttamente!";
    } else {
        $msg = "Errore nell'inserimento!";
    }
} elseif ($azione == 'Modifica') {
    $dbh->updateProduct($id_prodotto, $titolo, $descrizione, $prezzo, $sconto, $quantita, $categoria, $immagine, $edizione_limitata);
    $msg = "Modifica completata correttamente!";
} elseif ($azione == 'Cancella') {
    $dbh->deleteProduct($id_prodotto);
    $msg = "Cancellazione completata correttamente!";
} else {
    $msg = "ERRORE! Azione non valida!";
}

// Reindirizza alla pagina dashboard.php con un messaggio di feedback
header("location: dashboard.php?formmsg=" . urlencode($msg));
exit();
?>
<?php
require_once 'bootstrap.php';

try {
    // Recupera i parametri di filtro dai parametri GET
    $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
    $prezzoMin = isset($_GET['prezzoMin']) ? $_GET['prezzoMin'] : 0;
    $prezzoMax = isset($_GET['prezzoMax']) ? $_GET['prezzoMax'] : $dbh->getMaxPrice();
    $edizioneLimitata = isset($_GET['edizioneLimitata']) && $_GET['edizioneLimitata'] == '1' ? true : false;

    // Recupera i prodotti dal database in base ai filtri
    $prodotti = $dbh->getProductsByPriceRange($prezzoMin, $prezzoMax);
    $prodotti = filterProducts($prodotti, $categoria, $edizioneLimitata);

    // Aggiorna il percorso dell'immagine per ogni prodotto
    for ($i = 0; $i < count($prodotti); $i++) {
        $prodotti[$i]["immagine"] = UPLOAD_DIR . $prodotti[$i]["immagine"];
    }

    // Imposta l'intestazione del contenuto come JSON
    header('Content-Type: application/json');

    // Restituisce i prodotti in formato JSON
    echo json_encode($prodotti);
} catch (Exception $e) {
    // Imposta l'intestazione del contenuto come JSON e restituisce un errore
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
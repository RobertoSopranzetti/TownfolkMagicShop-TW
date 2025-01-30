<?php
function isActive($pagename)
{
    if (basename($_SERVER['PHP_SELF']) == $pagename) {
        echo " class='active' ";
    }
}

function getIdFromName($name)
{
    return preg_replace("/[^a-z]/", '', strtolower($name));
}

function isUserLoggedIn()
{
    return !empty($_SESSION['idutente']);
}

function registerLoggedUser($user)
{
    $_SESSION["idutente"] = $user["id"];
    $_SESSION["username"] = $user["username"];
}

function getUserIcon($ruolo)
{
    $_SESSION['ruolo'] = $ruolo;
    if ($_SESSION['ruolo'] == 'venditore') {
        return '<a class="navbar-brand d-lg-none" href="ordini.php"><i class="bi bi-clipboard-data"></i></a>
                <a class="navbar-brand d-none d-lg-block" href="ordini.php">Ordini</a>';
    } else {
        return '<a class="navbar-brand d-lg-none" href="carrello.php"><i class="bi bi-cart"></i></a>
                <a class="navbar-brand d-none d-lg-block" href="carrello.php">Carrello</a>';
    }
}

function getEmptyProduct()
{
    return array(
        "id" => "",
        "titolo" => "",
        "descrizione" => "",
        "prezzo" => "",
        "sconto" => "",
        "quantita_disponibile" => "",
        "id_categoria" => "",
        "id_venditore" => "",
        "immagine" => ""
    );
}

function getAction($action)
{
    $result = "";
    switch ($action) {
        case 1:
            $result = "Inserisci";
            break;
        case 2:
            $result = "Modifica";
            break;
        case 3:
            $result = "Cancella";
            break;
    }

    return $result;
}

function getRegistrationDetails($isVenditore)
{
    $details = [];
    $details['titolo'] = $isVenditore ? "Un nuovo commerciante si unisce alla gilda!!" : "Un nuovo avventuriero si unisce alla gilda!!";
    $details['linkVenditore'] = !$isVenditore ? '<p class="text-center">Sei un <a href="registra-utente.php?venditore=1">venditore</a>?</p>' : '';
    return $details;
}
function uploadImage($path, $image)
{
    $imageName = basename($image["name"]);
    $fullPath = $path . $imageName;

    $maxKB = 500;
    $acceptedExtensions = array("jpg", "jpeg", "png", "gif");
    $result = 0;
    $msg = "";
    //Controllo se immagine è veramente un'immagine
    $imageSize = getimagesize($image["tmp_name"]);
    if ($imageSize === false) {
        $msg .= "File caricato non è un'immagine! ";
    }
    //Controllo dimensione dell'immagine < 500KB
    if ($image["size"] > $maxKB * 1024) {
        $msg .= "File caricato pesa troppo! Dimensione massima è $maxKB KB. ";
    }

    //Controllo estensione del file
    $imageFileType = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $acceptedExtensions)) {
        $msg .= "Accettate solo le seguenti estensioni: " . implode(",", $acceptedExtensions);
    }

    //Controllo se esiste file con stesso nome ed eventualmente lo rinomino
    if (file_exists($fullPath)) {
        $i = 1;
        do {
            $i++;
            $imageName = pathinfo(basename($image["name"]), PATHINFO_FILENAME) . "_$i." . $imageFileType;
        }
        while (file_exists($path . $imageName));
        $fullPath = $path . $imageName;
    }

    //Se non ci sono errori, sposto il file dalla posizione temporanea alla cartella di destinazione
    if (strlen($msg) == 0) {
        if (!move_uploaded_file($image["tmp_name"], $fullPath)) {
            $msg .= "Errore nel caricamento dell'immagine.";
        } else {
            $result = 1;
            $msg = $imageName;
        }
    }
    return array($result, $msg);
}

?>
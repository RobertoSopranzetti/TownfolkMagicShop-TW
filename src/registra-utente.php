<?php
require_once 'bootstrap.php';

$isVenditore = isset($_GET['venditore']) && $_GET['venditore'] == 1;
$id_ruolo = $isVenditore ? 2 : 1; // Ruolo predefinito per un nuovo venditore o cliente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conferma_password = $_POST['conferma_password'];

    if ($password !== $conferma_password) {
        $templateParams["erroreregistrazione"] = "Le password non coincidono.";
    } else {
        $userId = $dbh->registerUser($nome, $cognome, $email, $username, password_hash($password, PASSWORD_BCRYPT), $id_ruolo);
        if ($userId) {
            registerLoggedUser($userId);
            header("Location: index.php");
            exit();
        } else {
            $templateParams["erroreregistrazione"] = "Errore durante la registrazione. Riprova.";
        }
    }
}

$templateParams["titolo"] = $isVenditore ? "Registrazione Venditore" : "Registrazione Cliente";
$templateParams["nome"] = "register-form.php";
$templateParams["isVenditore"] = $isVenditore;
$templateParams["ruolo"] = isUserLoggedIn() ? $dbh->getRoleByUsername($_SESSION["username"])["ruolo"] : "cliente";
$templateParams["prodottiCasuali"] = $dbh->getRandomProducts(2);

require 'template/base.php';
?>
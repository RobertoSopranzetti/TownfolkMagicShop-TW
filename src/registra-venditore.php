<?php
require_once 'bootstrap.php';

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
        $id_ruolo = 3; // Ruolo predefinito per un nuovo venditore
        $userId = $dbh->registerUser($nome, $cognome, $email, $username, password_hash($password, PASSWORD_BCRYPT), $id_ruolo);
        if ($userId) {
            header("Location: login.php");
            exit();
        } else {
            $templateParams["erroreregistrazione"] = "Errore durante la registrazione. Riprova.";
        }
    }
}

$templateParams["titolo"] = "Registrazione Venditore";
$templateParams["nome"] = "register-form.php";
$templateParams["isVenditore"] = true;
$templateParams["ruolo"] = isUserLoggedIn() ? $dbh->getRoleByUsername($_SESSION["username"])["ruolo"] : "cliente";
require 'template/base.php';
?>
<?php
require_once 'bootstrap.php';

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$templateParams["titolo"] = "Conferma Ordine";
$templateParams["nome"] = "order-confirmation.php";
$templateParams["formmsg"] = isset($_GET["formmsg"]) ? $_GET["formmsg"] : "";

require 'template/base.php';
?>
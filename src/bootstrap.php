<?php
session_start();
define("UPLOAD_DIR", "./upload/");
require_once("utils/functions.php");
require_once("database/database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "townfolkmagicshop", 3307);

$templateParams["ruolo"] = isUserLoggedIn() ? $dbh->getRoleByUsername($_SESSION["username"])["ruolo"] : "cliente";
$templateParams["prodottiCasuali"] = $dbh->getRandomProducts(2);

?>
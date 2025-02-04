<?php
require_once 'bootstrap.php';

$query = isset($_GET['q']) ? $_GET['q'] : '';

if (strlen($query) < 3) {
    echo json_encode([]);
    exit();
}

$results = $dbh->searchProducts($query);
echo json_encode($results);
?>